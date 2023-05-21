<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return User
     */
    public function login(array $data): User
    {
        return User::where('email', $data['email'])->first();

    }
}
