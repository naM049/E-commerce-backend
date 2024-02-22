<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::paginate());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:254'],
            'birthday' => ['date', 'before:today'],
            'country' => ['string'],
            'city' => ['string'],
            'postcode' => ['string'],
            'address_line_1' => ['string'],
            'address_line_2' => ['nullable'],
            'role' => ['string', 'in:admin,user']
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'birthday' => $request->birthday ?? $user->birthday,
        ]);

        if (auth()->user()->role === 'admin') {
            $user->role = $request->role ?? $user->role;
            $user->save();
        }

        $user->address()->update([
            'country' => $request->country ?? $user->address->country,
            'city' => $request->city ?? $user->address->city,
            'postcode' => $request->postcode ?? $user->address->postcode,
            'address_line_1' => $request->address_line_1 ?? $user->address->address_line_1,
            'address_line_2' => $request->address_line_2 ?? $user->address->address_line_2
        ]);

        return new UserResource($user);

    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([], 204);
    }
}
