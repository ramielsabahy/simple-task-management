<?php

namespace App\Services;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(protected UserRepository $repository)
    {
    }


    /**
     * @param $data
     * @return array
     * @throws ValidationException
     */
    public function login($data) : User|null
    {
        $user = $this->repository->login($data);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    /**
     * @param $data
     * @return array
     */
    public function register($data) : User
    {
        $user = $this->repository->register($data);
        return $user;
    }

    public function profile() : User
    {
        return request()->user();
    }

//    public function
}
