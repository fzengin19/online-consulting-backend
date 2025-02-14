<?php

namespace App\Http\Controllers;

use App\Dtos\UpdateAvatarDto;
use App\Dtos\UpdateUserAddressDto;
use App\Dtos\UpdateUserProfileDto;
use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserAddressRequest;
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

        $response = $this->userService->updateAvatar(new UpdateAvatarDto($request->file('avatar')));

        return response()->json($response->data, $response->status);
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $response = $this->userService->updateProfile(new UpdateUserProfileDto($request->validated()));

        return response()->json($response->data, $response->status);
    }

    public function updateAddress(UpdateUserAddressRequest $request)
    {
        $response = $this->userService->updateAddress(new UpdateUserAddressDto($request->validated()));

        return response()->json($response->data, $response->status);
    }
}
