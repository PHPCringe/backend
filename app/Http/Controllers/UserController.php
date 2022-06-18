<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = User::where('username', $request->user);

        return $this->responseJson(200, 'success get user', $user);
    }
}
