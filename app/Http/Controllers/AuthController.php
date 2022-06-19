<?php

namespace App\Http\Controllers;

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'type' => ['required', new Enum(UserTypes::class)],
        ]);

        if ($validation->fails()) {
            return $this->responseJson(422, 'Invalid data', $validation->errors());
        }

        $username = $request->type == UserTypes::PERSONAL
            ? "user-" . $request->name
            : $request->name;

        $createdUser = User::create([
            'name' => $request->name,
            'username' => Str::slug($username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'avatar_url' => "avatar.png"
        ]);

        $accessToken = $createdUser->createToken('access_token')->plainTextToken;

        return $this->responseJson(201, 'Successfully registered a new account, Verification link has been sent to your email address', [
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

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->responseJson(200, 'Email already verified');
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->responseJson(200, 'Verification email has been sent');
    }

    public function verifyEmailAddress(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->responseJson(200, 'Email already verified');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
            return $this->responseJson(200, 'Email address has been verified');
        }

        return $this->responseJson(200, 'Email has been verified');
    }
}
