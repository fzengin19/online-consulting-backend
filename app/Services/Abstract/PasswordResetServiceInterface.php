<?php

namespace App\Services\Abstract;

use App\Dtos\ResetPasswordDto;
use App\Dtos\SendPasswordResetLinkDto;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkEmailRequest;
use App\Services\ServiceResponse;

interface PasswordResetServiceInterface
{
    public function sendResetLink(SendPasswordResetLinkDto $sendPasswordResetLinkDto): ServiceResponse;
    public function reset(ResetPasswordDto $resetPasswordDto): ServiceResponse;
}
