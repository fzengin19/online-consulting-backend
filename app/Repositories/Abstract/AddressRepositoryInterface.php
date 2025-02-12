<?php

namespace App\Repositories\Abstract;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function updateOrCreateByPlaceId(string $placeId, array $attributes): Address;

}
