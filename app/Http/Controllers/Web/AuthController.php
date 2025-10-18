<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()    { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function login(Request $r)
    {
        $data = $r->validate([
            'email' => ['required','email'],
            'password' => ['required','string','min:6'],
            'remember' => ['nullable','boolean'],
        ]);

        if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']], (bool)($data['remember'] ?? false))) {
            $r->session()->regenerate();
            return redirect()->intended(route('home'))->with('success','Đăng nhập thành công!');
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
    }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => ['required','string','max:100'],
            'email' => ['required','email','max:150','unique:users,email'],
            'password' => ['required','string','min:6','confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $r->session()->regenerate();

        return redirect()->intended(route('home'))->with('success','Tạo tài khoản thành công!');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('home')->with('success','Đã đăng xuất.');
    }
}
