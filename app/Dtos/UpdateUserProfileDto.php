<?php 

namespace App\Dtos;

use App\Core\BaseDto;

class UpdateUserProfileDto extends BaseDto
{
    public string $name;
    public string $phone;
    public string $title;
   
}
