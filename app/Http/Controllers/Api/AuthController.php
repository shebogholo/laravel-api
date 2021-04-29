<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request){
        $user_data = $request->validate([
            'name' => 'required|max:50',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user_data['password'] = bcrypt($request->password);
        $user = User::create($user_data);
        $accessToken = $user->createToken('token')->accessToken;
        return response(['user' => $user, 'token' => $accessToken]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        
        if(!auth()->attempt($credentials)){
            return response(['message' => 'Invalid Credentials!']);
        }
        
        $accessToken = auth()->user()->createToken('token')->accessToken;
        return response(['user' => auth()->user(), 'token' => $accessToken]);
    }
}
