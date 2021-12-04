<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laravel\Sanctum\PersonalAccessToken;

class TokenPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, PersonalAccessToken $accessToken)
    {
        return $user->id === $accessToken->tokenable->id;
    }
}
