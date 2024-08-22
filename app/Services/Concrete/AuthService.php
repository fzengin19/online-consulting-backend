<?php

namespace App\Services\Concrete;

use App\Exceptions\DuplicateEmailException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\AuthServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthService implements AuthServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($request->email);
        if ($user) {
            throw new DuplicateEmailException();
        }
        $user = $this->userRepository->create($request->validated());
        $token = $user->createToken('api-token')->plainTextToken;
        return new ServiceResponse([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginRequest $request): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($request->email);
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new InvalidCredentialsException('Invalid email or password.');
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return new ServiceResponse([
            'message' => 'Logged in successfully',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request): ServiceResponse
    {
        Auth::user()->currentAccessToken()->delete();
        return new ServiceResponse(['message' => 'Logged out successfully'], 200);
    }
}
