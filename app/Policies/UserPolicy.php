<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        return $user->can('user.manage');
    }

    public function update(User $user, User $model)
    {
        return $user->can('user.update') || $user->id === $model->id;
    }

    public function delete(User $user, User $model)
    {
        return $user->can('user.delete') && $user->id !== $model->id;
    }
}
