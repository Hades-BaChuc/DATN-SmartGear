<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address; // <-- thêm
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register'); // dùng view bạn đã làm
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','string','lowercase','email','max:255','unique:'.User::class],
            'phone'    => ['nullable','string','max:30'],
            'address'  => ['required','string','max:255'],        // <— thêm
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // tạo địa chỉ mặc định (đổi 'line1' thành tên cột bạn đang dùng)
        Address::create([
            'user_id'    => $user->id,
            'line1'      => $request->address,  // <-- nếu cột là 'address' thì đổi lại
            'name'       => $request->name,
            'phone'      => $request->phone,
            'is_default' => true,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended('/');
    }
}
