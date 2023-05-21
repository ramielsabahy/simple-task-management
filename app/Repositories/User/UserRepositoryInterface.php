<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function register(array $data) : User;

    /**
     * @param array $data
     * @return User
     */
    public function login(array $data) : User;
}
