<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $response = $this->passwordResetService->sendResetLink($request);
        return response()->json($response->data, $response->status);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $response = $this->passwordResetService->reset($request);
        return response()->json($response->data, $response->status);
    }
}
