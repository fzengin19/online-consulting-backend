<?php

namespace App\Http\Controllers;

use App\Dtos\ResetPasswordDto;
use App\Dtos\SendPasswordResetLinkDto;
use App\Services\Abstract\PasswordResetServiceInterface;
use App\Http\Requests\Auth\SendResetLinkEmailRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

class PasswordResetController extends Controller
{
    private $passwordResetService;

    public function __construct(PasswordResetServiceInterface $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    public function sendResetLinkEmail(SendResetLinkEmailRequest $request)
    {
        $result = $this->passwordResetService->sendResetLink(new SendPasswordResetLinkDto($request->validated()));

        return $result->toResponse();
    }

    public function reset(ResetPasswordRequest $request)
    {
        $result = $this->passwordResetService->reset(new ResetPasswordDto($request->only('email', 'password', 'password_confirmation', 'token')));

        return $result->toResponse();
    }
}
