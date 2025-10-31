<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(){ return view('auth.login'); }
    public function showRegisterForm(){ return view('auth.register'); }

    public function login(Request $r){
        $cred = $r->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($cred, true)) { $r->session()->regenerate(); return redirect()->intended('/'); }
        return back()->withErrors(['email'=>'Thông tin đăng nhập không đúng.']);
    }

    public function register(Request $r){
        $data = $r->validate([
            'name'=>'required|string|max:255',
            'phone'=>'nullable|string|max:30',
            'email'=>'required|email|unique:users,email',
            'address'=>'required|string|max:255',
            'password'=>'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);

        // tạo địa chỉ mặc định
        Address::create([
            'user_id' => $user->id,
            'line1'   => $data['address'], // <<< nếu cột tên "address" hãy đổi 'line1' -> 'address'
            'is_default' => true,
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }
}
