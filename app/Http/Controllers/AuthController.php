<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string',
        //     'type' => 'required|'
        // ])

        $username = $request->type == 'personal' ? "user-" . $request->name : $request->name;

        $createdUser = User::create([
            'name' => $request->name,
            'username' => Str::slug($username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'avatar_url' => "avatar.png"
        ]);

        $accessToken = $createdUser->createToken('access_token')->plainTextToken;

        return $this->responseJson(201, 'Successfully registered a new account', [
            'user' => $createdUser,
            'access_token' => $accessToken,
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->responseJson(401, 'Invalid credentials');
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $accessToken = $user->createToken('access_token')->plainTextToken;

        return $this->responseJson(200, 'Successfully logged in', $accessToken);
    }
}
