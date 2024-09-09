<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Services\Abstract\UserServiceInterface;

class UserController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userService = $userServiceInterface;
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $response = $this->userService->updateAvatar($request);

        return response()->json($response->data, $response->status);
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $response = $this->userService->updateProfile($request);

        return response()->json($response->data, $response->status);
    }
}
