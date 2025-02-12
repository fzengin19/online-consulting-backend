<?php

namespace App\Repositories\Abstract;

use App\Models\UserAddress;

interface UserAddressRepositoryInterface
{
    public function updateOrCreateByUserId(int $userId, array $values): UserAddress;
}
