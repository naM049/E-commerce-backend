<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'role' => $this->role,
            'address' => $this->address,
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
