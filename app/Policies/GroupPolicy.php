<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if (!$user->isAdmin() || !$user->isActive()) {
            return false;
        }
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Group $group)
    {
        return !$group->isArchived();
    }

    public function delete(User $user, Group $group)
    {
        abort_if($group->orders->count() > 0, 403, __('group-not-empty'));
        return true;
    }
}
