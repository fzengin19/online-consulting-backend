<?php

namespace App\Services\Concrete;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\SendResetLinkEmailRequest;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\PasswordResetServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetService implements PasswordResetServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendResetLink(SendResetLinkEmailRequest $request): ServiceResponse
    {

        $response = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? new ServiceResponse(['message' => 'Reset link sent to your email.'], 200)
            : new ServiceResponse(['message' => 'Unable to send reset link.'], 500);
    }

    public function reset(ResetPasswordRequest $request): ServiceResponse
    {


        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $this->userRepository->updateById($user->id, ['password' => $user->password]);

                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
            ? new ServiceResponse(['message' => 'Password has been reset!'], 200)
            : new ServiceResponse(['message' => 'Unable to reset password'], 500);
    }
}
