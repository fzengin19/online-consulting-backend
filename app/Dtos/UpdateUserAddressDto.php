<?php 

namespace App\Dtos;

use App\Core\BaseDto;

class UpdateUserAddressDto extends BaseDto
{
    public string $name;
    public float $latitude;
    public float $longitude;
    public string $place_id;
   
}
