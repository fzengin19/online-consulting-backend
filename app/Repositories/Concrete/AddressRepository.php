<?php

namespace App\Repositories\Concrete;

use App\Models\Address;
use App\Models\User;
use App\Repositories\Abstract\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    public function getByPlaceId(string $placeId)
    {
        return Address::where('place_id', $placeId)->first();
    }

    public function updateByPlaceID(int $placeId, array $data)
    {
        return Address::where('place_id', $placeId)->update($data);
    }
}
