<?php namespace Tests;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait UserFactory {
    protected User $user;

    protected function userFactory($attributes = [], ?Model $parent = null): User
    {
        return $this->user ?? $this->user = User::factory()->create($attributes, $parent);
    }
}
