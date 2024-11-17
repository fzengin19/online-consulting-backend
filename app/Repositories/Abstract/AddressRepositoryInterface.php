<?php

namespace App\Repositories\Abstract;

interface AddressRepositoryInterface
{
    public function getByPlaceID(string $placeId);
    public function updateByPlaceID(int $placeId, array $data);
}
