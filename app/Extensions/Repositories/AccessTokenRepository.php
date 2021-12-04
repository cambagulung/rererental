<?php

namespace App\Extensions\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenRepository
{
    public function create(HasApiTokens $tokenable, string $name, array $abilities = ['*'])
    {
        return $tokenable->createToken($name, $abilities);
    }

    public function getOneByToken(string $token)
    {
        return PersonalAccessToken::findToken($token);
    }

    public function getOneById(int $id): PersonalAccessToken
    {
        return PersonalAccessToken::find($id);
    }

    public function getManyByTokenable(HasApiTokens $tokenable): Collection
    {
        return $tokenable->tokens;
    }

    public function getManyByTokenablePaginated(HasApiTokens $tokenable, int $paginate): LengthAwarePaginator
    {
        return $tokenable->tokens()->paginate($paginate);
    }

    public function deleteOneById(int $id): ?bool
    {
        return PersonalAccessToken::find($id)->delete();
    }
}
