<?php

namespace App\Repositories\Abstract;

use App\Core\Abstract\BaseRepositoryInterface;
use App\Models\Address;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function updateOrCreateByPlaceId(string $placeId, array $attributes): Address;

}
