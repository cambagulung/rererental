<?php

namespace App\Extensions\Services\Auth;

use App\Extensions\Repositories\AccessTokenRepository;
use Laravel\Sanctum\Contracts\HasApiTokens;

class TokenService
{
    public function __construct(protected AccessTokenRepository $accessTokenRepository)
    {
        //
    }

    public function create(HasApiTokens $tokenable, string $name)
    {
        return $this->accessTokenRepository->create($tokenable, $name);
    }

    public function getOneByToken(string $token)
    {
        return $this->accessTokenRepository->getOneByToken($token);
    }

    public function getOneById(int $id)
    {
        return $this->accessTokenRepository->getOneById($id);
    }

    public function getManyByTokenable(HasApiTokens $tokenable)
    {
        return $this->accessTokenRepository->getManyByTokenable($tokenable);
    }

    public function getManyByTokenablePaginated(HasApiTokens $tokenable, int $paginate)
    {
        return $this->accessTokenRepository->getManyByTokenablePaginated($tokenable, $paginate);
    }

    public function destroyOneById(int $id)
    {
        return $this->accessTokenRepository->deleteOneById($id);
    }
}
