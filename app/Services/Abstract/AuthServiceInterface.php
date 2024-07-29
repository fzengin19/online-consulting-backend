<?php

namespace App\Services\Abstract;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\ServiceResponse;

interface AuthServiceInterface
{
    public function register(RegisterRequest $requet): ServiceResponse;

    public function login(LoginRequest $requet): ServiceResponse;
}
