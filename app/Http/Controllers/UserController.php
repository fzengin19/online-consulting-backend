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

    public function getProfile()
    {
        $result = $this->userService->getUserProfile();
        return $result->toResponse();
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $result = $this->userService->updateAvatar(new UpdateAvatarDto($request->file('avatar')));
        
        return $result->toResponse();
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $result = $this->userService->updateProfile(new UpdateUserProfileDto($request->validated()));
        
        return $result->toResponse();
    }

    public function updateAddress(UpdateUserAddressRequest $request)
    {
        $result = $this->userService->updateAddress(new UpdateUserAddressDto($request->validated()));

        return $result->toResponse();
    }
}
