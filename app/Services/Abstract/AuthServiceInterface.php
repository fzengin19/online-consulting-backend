<?php

namespace App\Services\Abstract;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\ServiceResponse;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(RegisterRequest $requet): ServiceResponse;

    public function login(LoginRequest $requet): ServiceResponse;
    public function logout(Request $requet): ServiceResponse;
}
