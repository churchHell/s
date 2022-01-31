<?php

namespace App\Policies\Pivots;

use App\Models\{User, Pivots\OrderUser};
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderUserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->isActive()) {
            return false;
        }
    }

    public function update(User $user, OrderUser $orderUser): bool
    {
        return $this->can($user, $orderUser);
    }

    public function delete(User $user, OrderUser $orderUser): bool
    {
        return $this->can($user, $orderUser);
    }

    private function can(User $user, OrderUser $orderUser): bool
    {
        return $orderUser->user_id == $user->id || $user->isAdmin();
    }
}
