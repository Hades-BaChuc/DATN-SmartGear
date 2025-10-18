<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $u = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $u->createToken('api')->plainTextToken;

        return response()->json(['success'=>true,'data'=>['token'=>$token]], 201);
    }

    public function login(Request $r)
    {
        $r->validate(['email'=>'required|email','password'=>'required']);
        $u = User::where('email',$r->email)->first();

        if (!$u || !Hash::check($r->password, $u->password)) {
            return response()->json(['success'=>false,'errors'=>['auth'=>'Invalid credentials']], 422);
        }

        $token = $u->createToken('api')->plainTextToken;
        return response()->json(['success'=>true,'data'=>['token'=>$token]]);
    }

    public function me(Request $r)
    {
        return response()->json(['success'=>true,'data'=>$r->user()]);
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()?->delete();
        return response()->json(['success'=>true,'message'=>'Logged out']);
    }
}
