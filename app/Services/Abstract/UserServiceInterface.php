<?php

namespace App\Services\Abstract;

use App\Dtos\UpdateAvatarDto;
use App\Dtos\UpdateUserAddressDto;
use App\Dtos\UpdateUserProfileDto;
use App\Services\ServiceResponse;

interface UserServiceInterface
{
    public function updateAvatar(UpdateAvatarDto $updateAvatarDto): ServiceResponse;
    public function updateProfile(UpdateUserProfileDto $updateUserProfileDto): ServiceResponse;
    public function updateAddress(UpdateUserAddressDto $updateUserAddressDto): ServiceResponse;
    public function getUserProfile(): ServiceResponse;
}
