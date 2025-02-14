<?php

namespace App\Services\Abstract;

use App\Dtos\LoginDto;
use App\Dtos\RegisterDto;
use App\Services\ServiceResponse;

interface AuthServiceInterface
{
    public function register(RegisterDto $registerDto): ServiceResponse;
    public function login(LoginDto $registerDto): ServiceResponse;
    public function logout(): ServiceResponse;
}
