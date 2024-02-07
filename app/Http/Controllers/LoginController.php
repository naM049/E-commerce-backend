<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $token = Auth::attempt($credentials);

        if (!$token) {

            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ]);

    }

    public function logout()
    {

        auth()->logout();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
