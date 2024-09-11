<?php

namespace App\Services\Abstract;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Services\ServiceResponse;

interface UserServiceInterface
{
    public function updateAvatar(UpdateAvatarRequest $request): ServiceResponse;
    public function updateProfile(UpdateUserProfileRequest $request): ServiceResponse;
}
