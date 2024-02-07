<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class RefreshTokenController extends Controller
{
    public function refresh()
    {
        $token = auth()->refresh();

        return response()->json([
            'user' => new UserResource(auth()->user()),
            'token' => $token
        ]);
    }
}
