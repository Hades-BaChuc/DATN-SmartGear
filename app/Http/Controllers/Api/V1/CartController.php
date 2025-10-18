<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index(Request $req)
    {
        $uid = $req->user()->id;
        $items = CartItem::with('product')->where('user_id', $uid)->get();

        $rows = $items->map(function($i){
            $subtotal = (int) $i->qty * (int) $i->unit_price;
            return [
                'id' => $i->id,
                'product' => [
                    'id'    => $i->product->id,
                    'name'  => $i->product->name,
                    'image' => $i->product->image,
                ],
                'qty'        => (int) $i->qty,
                'unit_price' => (int) $i->unit_price,
                'subtotal'   => $subtotal,
            ];
        });

        return response()->json([
            'success'=>true,
            'data'=>[
                'items'=>$rows,
                'total'=>$rows->sum('subtotal'),
            ],
            'message'=>null,'errors'=>null
        ]);
    }

    public function add(Request $req)
    {
        $data = $req->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty'        => ['required','integer','min:1'],
        ]);

        $p = Product::findOrFail($data['product_id']);
        $item = CartItem::updateOrCreate(
            ['user_id'=>$req->user()->id, 'product_id'=>$p->id],
            ['qty' => \DB::raw('qty + '.$data['qty']), 'unit_price' => (int) $p->price]
        );

        return response()->json(['success'=>true,'data'=>['id'=>$item->id],'message'=>'Added to cart','errors'=>null], 201);
    }

    public function update(Request $req)
    {
        $data = $req->validate([
            'id'  => ['required','integer','exists:cart_items,id'],
            'qty' => ['required','integer','min:1'],
        ]);
        $item = CartItem::where('user_id',$req->user()->id)->findOrFail($data['id']);
        $item->update(['qty'=>$data['qty']]);
        return response()->json(['success'=>true,'data'=>null,'message'=>'Updated','errors'=>null]);
    }

    public function remove(Request $req)
    {
        $data = $req->validate(['id'=>['required','integer','exists:cart_items,id']]);
        CartItem::where('user_id',$req->user()->id)->where('id',$data['id'])->delete();
        return response()->json(['success'=>true,'data'=>null,'message'=>'Removed','errors'=>null]);
    }

    public function clear(Request $req)
    {
        CartItem::where('user_id',$req->user()->id)->delete();
        return response()->json(['success'=>true,'data'=>null,'message'=>'Cleared','errors'=>null]);
    }
}
