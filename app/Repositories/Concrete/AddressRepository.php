<?php

namespace App\Repositories\Concrete;

use App\Models\Address;
use App\Models\User;
use App\Repositories\Abstract\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    public function updateOrCreateByPlaceId(string $placeId, array $attributes): Address
    {
        return Address::updateOrCreate(['place_id' => $placeId], $attributes);
    }

}
