<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Repositories\User\UserRepository;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $userService;


    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) : JsonResponse
    {
        $user = $this->userService->login($request->only('email','password'));
        if ($user)
            return customResponse([
                'user'  => new UserResource($user),
                'token' => $user->createToken($user->name)->plainTextToken
            ], "Logged in successfully", 200);
        return customResponse((object)[], "Credentials didn't match", 200);
    }

    /**
     * @param RegisterRequest $request
     * @param UserService $loginService
     * @return JsonResponse
     */
    public function register(RegisterRequest $request) : JsonResponse
    {
        $user = $this->userService->register($request->only('email','password','name'));
        return customResponse([
            'user'  => new UserResource($user),
        ], "Logged in successfully", 200);
    }
}
