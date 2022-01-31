<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->isActive()) {
            return false;
        }
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Order $order)
    {
        return $user->isAdmin() || $order->users->contains($user);
    }

    public function join(User $user, Order $order)
    {
        return !$order->users()->where('user_id', auth()->id())->exists();
        return !$order->users->contains($user)
            && (app()->has('group') ? !app('group')->isArchived() : true);
    }

    public function refresh(User $user)
    {
        return true;
    }
}
