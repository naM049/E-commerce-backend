<?php

namespace App\Policies;

use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, OrderItem $orderItem): bool
    {
        return $user->role === 'admin' || $user->id === $orderItem->order->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, OrderItem $orderItem): bool
    {
        return $user->role === 'admin' || $user->id === $orderItem->order->user_id;
    }

    public function delete(User $user, OrderItem $orderItem): bool
    {
        return $user->role === 'admin' || $user->id === $orderItem->order->user_id;
    }

}
