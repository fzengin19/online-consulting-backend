<?php

namespace App\Services\Concrete;

use App\Dtos\LoginDto;
use App\Dtos\RegisterDto;
use App\Exceptions\DuplicateEmailException;
use App\Exceptions\InvalidCredentialsException;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\AuthServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterDto $registerDto): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($registerDto->email);
        if ($user) {
            throw new DuplicateEmailException();
        }
        $validatedData = $registerDto->toArray();
        $validatedData['slug'] = Str::slug($validatedData['name']) . '-' . uniqid(5);
        $user = $this->userRepository->create($validatedData);
        $token = $user->createToken('api-token')->plainTextToken;
        $user->load('address');
        return new ServiceResponse([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function login(LoginDto $loginDto): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($loginDto->email);
        if (!$user || !Hash::check($loginDto->password, $user->password)) {
            throw new InvalidCredentialsException('Invalid email or password.');
        }

        $token = $user->createToken('api-token')->plainTextToken;
        $user->load('address');
        return new ServiceResponse([
            'message' => 'Logged in successfully',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(): ServiceResponse
    {
        Auth::user()->currentAccessToken()->delete();
        return new ServiceResponse(['message' => 'Logged out successfully'], 200);
    }
}
