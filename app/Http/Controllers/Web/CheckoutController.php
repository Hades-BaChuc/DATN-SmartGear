<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart) {}

    // MUA NGAY: không cần đăng nhập
    public function buyNow(Request $request)
    {
        // Find the product in the database
        $product = Product::find($request->id);

        if ($product) {
            session()->put('cart', [
                $product->id => [
                    "name" => $product->product_name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->cover_url
                ]
            ]);

            \Log::info('Cart after adding product:', session()->get('cart'));

            // Proceed directly to checkout
            return redirect()->route('checkout.index');
        }

        return back()->with('error', 'Product not found');
    }


    // Trang checkout
    public function index(Request $r)
    {
        // Check nếu người dùng không đăng nhập, yêu cầu điền thông tin
        $user = auth()->user();

        if (!$user) {
            // Nếu không đăng nhập, yêu cầu thông tin cá nhân
            $r->validate([
                'full_name'    => ['required', 'string', 'max:255'],
                'phone'        => ['required', 'string', 'max:20'],
                'email'        => ['nullable', 'email'],
                'address_text' => ['required', 'string', 'max:500'],
            ]);
            $fullName = $r->input('full_name');
            $phone = $r->input('phone');
            $email = $r->input('email');
            $addressText = $r->input('address_text');
        } else {
            // Nếu người dùng đã đăng nhập thì lấy thông tin của họ
            $fullName = $user->name;
            $phone = $user->phone;
            $email = $user->email;
            $addressText = optional($user->addresses()->where('is_default', 1)->first())->full_text;
        }

        // Lấy dữ liệu giỏ hàng
        $cart = $this->cart->all();
        $totals = $this->cart->totals();

        return view('checkout.index', compact('cart', 'totals', 'fullName', 'phone', 'email', 'addressText'));
    }

    // Đặt hàng COD
    public function placeOrder(Request $r)
    {
        $items = $this->cart->items();
        abort_if(empty($items), 400, 'Giỏ trống');

        $user = auth()->user();

        // Validate for GUEST users (if not logged in)
        if (!$user) {
            $r->validate([
                'full_name'    => ['required', 'string', 'max:255'],
                'phone'        => ['required', 'string', 'max:20'],
                'email'        => ['nullable', 'email'],
                'address_text' => ['required', 'string', 'max:500'],
            ]);
        }

        // Collect user info (or guest info)
        $fullName = $user?->name ?? $r->input('full_name');
        $phone    = $user?->phone ?? $r->input('phone');
        $email    = $user?->email ?? $r->input('email');
        $addrText = $user
            ? optional($user->addresses()->where('is_default', 1)->first())->full_text
            : $r->input('address_text');

        // Snapshot totals & coupon (to prevent mid-checkout changes)
        $totals      = $this->cart->totals();
        $coupon      = $this->cart->coupon();
        $couponCode  = $coupon?->code;

        // Generate order number (optional)
        $genOrderNo = fn() => 'OD' . now()->format('ymdHis') . random_int(100, 999);

        DB::transaction(function () use ($items, $totals, $user, $fullName, $phone, $email, $addrText, $coupon, $couponCode, $genOrderNo) {
            // Lock products and decrement stock if necessary
            foreach ($items as $i) {
                $p = Product::whereKey($i['product_id'])->lockForUpdate()->firstOrFail();
                if (isset($p->stock) && $p->stock !== null) {
                    abort_if($p->stock < $i['qty'], 422, "Sản phẩm {$p->name} không đủ tồn");
                    $p->decrement('stock', (int)$i['qty']);
                }
            }

            // Create order
            $order = Order::create([
                'order_number'   => $genOrderNo(),
                'user_id'        => $user?->id,
                'full_name'      => $fullName,
                'phone'          => $phone,
                'email'          => $email,
                'address_text'   => $addrText,
                'subtotal'       => $totals['subtotal'],
                'shipping_fee'   => $totals['shipping'],
                'discount'       => $totals['discount'],
                'total'          => $totals['total'],
                'coupon_code'    => $couponCode,
                'payment_method' => 'cod',
                'status'         => 'pending',
            ]);

            // Create order items
            foreach ($items as $i) {
                $order->items()->create([
                    'product_id' => $i['product_id'],
                    'name'       => $i['name'],
                    'price'      => $i['price'],
                    'qty'        => $i['qty'],
                    'line_total' => $i['price'] * $i['qty'],
                ]);
            }

            // Increment coupon usage count (if applicable)
            if ($coupon) {
                $coupon->increment('used_count');
            }
        });

        // Clear the cart
        $this->cart->clear();

        return redirect('/')->with('ok', 'Đặt hàng thành công (COD)');
    }

}
