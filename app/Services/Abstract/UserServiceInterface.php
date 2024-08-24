<?php

namespace App\Services\Abstract;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Services\ServiceResponse;

interface UserServiceInterface
{
    public function updateAvatar(UpdateAvatarRequest $request): ServiceResponse;
}
