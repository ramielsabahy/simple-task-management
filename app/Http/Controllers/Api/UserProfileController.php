<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    private UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function profile()
    {
        $user = $this->service->profile();
        return customResponse(new UserResource($user));
    }
}
