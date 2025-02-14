<?php

namespace App\Repositories\Abstract;

use App\Core\Abstract\BaseRepositoryInterface;
use App\Models\UserAddress;

interface UserAddressRepositoryInterface extends BaseRepositoryInterface
{
    public function updateOrCreateByUserId(int $userId, array $values): UserAddress;
}
