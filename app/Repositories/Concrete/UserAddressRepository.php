<?php

namespace App\Repositories\Concrete;

use App\Models\Address;
use App\Models\User;
use App\Models\UserAddress;
use App\Repositories\Abstract\UserAddressRepositoryInterface;

class UserAddressRepository implements UserAddressRepositoryInterface
{
    public function updateOrCreateByUserId(int $userId, array $values): UserAddress
    {
        return UserAddress::updateOrCreate(['user_id' => $userId], $values);
    }

}
