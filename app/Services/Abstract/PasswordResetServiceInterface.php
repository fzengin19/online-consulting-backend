<?php

namespace App\Services\Abstract;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkEmailRequest;
use App\Services\ServiceResponse;

interface PasswordResetServiceInterface
{
    public function sendResetLink(SendResetLinkEmailRequest $request): ServiceResponse;
    public function reset(ResetPasswordRequest $request): ServiceResponse;
}
