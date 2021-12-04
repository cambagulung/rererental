<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Extensions\Services\Auth\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UserCreateRequest;
use App\Http\Requests\Api\V1\User\UserUpdateRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        //
    }

    public function index()
    {
        return UserResource::collection($this->userService->getManyPaginated(24));
    }

    public function create(UserCreateRequest $request)
    {
        $data = $request->only('name', 'email', 'password');

        return new UserResource($this->userService->create($data));
    }

    public function view(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        $data = $request->only('name', 'email', 'password');

        $this->userService->update($user, $data);
    }

    public function destroy(User $user)
    {
        $user->delete();
    }
}
