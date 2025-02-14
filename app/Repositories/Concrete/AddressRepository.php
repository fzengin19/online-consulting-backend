<?php

namespace App\Repositories\Concrete;

use App\Core\Concrete\BaseRepository;
use App\Models\Address;
use App\Models\User;
use App\Repositories\Abstract\AddressRepositoryInterface;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface  
{
    public function __construct()
    {
        parent::__construct(new Address());
    }

    public function updateOrCreateByPlaceId(string $placeId, array $attributes): Address
    {
        return Address::updateOrCreate(['place_id' => $placeId], $attributes);
    }

}
