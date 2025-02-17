<?php

namespace App\Http\Controllers;

use App\Dtos\LoginDto;
use App\Dtos\RegisterDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Abstract\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;


    public function __construct(AuthServiceInterface $authServiceInterface)
    {
        $this->authService = $authServiceInterface;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register(new RegisterDto($request->validated()));
        return $result->toResponse();
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(new LoginDto($request->validated()));
        return $result->toResponse();
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout($request);
        return $result->toResponse();
    }
}
