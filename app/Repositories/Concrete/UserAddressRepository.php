<?php

namespace App\Repositories\Concrete;

use App\Core\Concrete\BaseRepository;
use App\Models\UserAddress;
use App\Repositories\Abstract\UserAddressRepositoryInterface;

class UserAddressRepository extends BaseRepository implements UserAddressRepositoryInterface
{

    public function __construct()
    {
        parent::__construct(new UserAddress());
    }

    public function updateOrCreateByUserId(int $userId, array $values): UserAddress
    {
        return UserAddress::updateOrCreate(['user_id' => $userId], $values);
    }

}
