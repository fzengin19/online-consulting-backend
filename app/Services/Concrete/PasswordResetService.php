<?php

namespace App\Services\Concrete;

use App\Dtos\ResetPasswordDto;
use App\Dtos\SendPasswordResetLinkDto;
use App\Http\Requests\Auth\ResetPasswordRequest;
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

    public function sendResetLink(SendPasswordResetLinkDto $sendPasswordResetLinkDto): ServiceResponse
    {
        $user = $this->userRepository->findByEmail($sendPasswordResetLinkDto->email);
        if (!$user) {
            return new ServiceResponse(['message' => 'User not found.'], 404);
        }

        $response = Password::broker()->sendResetLink([
            'email' => $sendPasswordResetLinkDto->email
        ]);
        
        return $response == Password::RESET_LINK_SENT
            ? new ServiceResponse(['message' => 'Reset link sent to your email.'], 200)
            : new ServiceResponse(['message' => 'Unable to send reset link.'], 500);
    }

    public function reset(ResetPasswordDto $resetPasswordDto): ServiceResponse
    {

        $response = Password::broker()->reset( 
            $resetPasswordDto->toArray(),
            function ($user, $password) {
                $password = Hash::make($password);
                $this->userRepository->update($user->id, ['password' => $password]);
                $user->refresh();
                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
            ? new ServiceResponse(['message' => 'Password has been reset!'], 200)
            : new ServiceResponse(['message' => 'Unable to reset password'], 500);
    }
}
