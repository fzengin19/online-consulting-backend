<?php 

namespace App\Dtos;

use App\Core\BaseDto;

class RegisterDto extends BaseDto
{
    public string $name;
    public string $email;
    public string $password;
   
}
