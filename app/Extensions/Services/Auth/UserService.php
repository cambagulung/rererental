<?php

namespace App\Extensions\Services\Auth;

use App\Extensions\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
        //
    }

    protected function passwordHash(string $password): string
    {
        return password_hash($password, password_algos()[0]);
    }

    public function create(array $data = [])
    {
        $data['password'] = $this->passwordHash($data['password']);

        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data = [])
    {
        if (isset($data['password'])) $data['password'] = $this->passwordHash($data['password']);

        return $this->userRepository->update($user, $data);
    }

    public function getManyPaginated(int $paginate)
    {
        return $this->userRepository->getManyPaginated($paginate);
    }

    public function getOneById(string $id)
    {
        return $this->userRepository->getOneById($id);
    }

    public function destroyOneById(int $id)
    {
        return $this->getOneById($id)->delete();
    }

    public function detroyOneByModel(User $user)
    {
        return $user->delete();
    }
}
