<?php

namespace App\Services\Concrete;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Concrete\UserRepositoryInterface;
use App\Services\Abstract\AuthServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return new ServiceResponse([
            'message' => 'Logged in successfully',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function register(RegisterRequest $request): ServiceResponse
    {
        $user = $this->userRepository->create($request->validated());

        // Kullanıcı kaydını başarılı şekilde tamamladık, response döndürüyoruz
        return new ServiceResponse([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }
}
