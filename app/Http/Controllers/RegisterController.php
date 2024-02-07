<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(UserRequest $request)
    {

        $request->validated();

        $user = User::create($request->only(['email', 'name', 'password', 'birthday']));
        Address::create([
           'user_id' => $user->id,
           'country' => $request->country,
           'city' => $request->city,
           'postcode' => $request->postcode,
           'address_line_1' => $request->address_line_1,
           'address_line_2' => $request->address_line_2
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => new UserResource($user)
        ]);
    }
}
