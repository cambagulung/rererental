<?php

namespace App\Extensions\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository
{
    public function create(array $data = []): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data = [])
    {
        return $user->update($data);
    }

    public function getMany(): Collection
    {
        return User::all();
    }

    public function getManyPaginated(int $paginate): LengthAwarePaginator
    {
        return User::paginate($paginate);
    }

    public function getOneById(int $id): User
    {
        return User::find($id);
    }

    public function deleteOneById(int $id)
    {
        return $this->getOneById($id)->delete();
    }
}
