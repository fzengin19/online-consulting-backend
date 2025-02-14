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
        $response = $this->authService->register(new RegisterDto($request->validated()));
        return response()->json($response->data, $response->status);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login(new LoginDto($request->validated()));
        return response()->json($response->data, $response->status);
    }

    public function logout(Request $request)
    {
        $response = $this->authService->logout($request);
        return response()->json($response->data, $response->status);
    }
}
