<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\Exceptions\ApiBadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RequestLogin;
use App\Services\UserService;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Login api
     *
     * @param  RequestLogin  $request
     * @return array
     */
    public function login(RequestLogin $request): array
    {
        try {
            return $this->userService->login($request);
        } catch (\Exception) {
            throw new ApiBadRequestException();
        }
    }

    /**
     * Logout api
     *
     * @return array
     */
    public function logout(): array
    {
        try {
            return $this->userService->logout();
        } catch (\Exception) {
            throw new ApiBadRequestException();
        }
    }
}
