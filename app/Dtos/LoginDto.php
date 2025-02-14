<?php 

namespace App\Dtos;

use App\Core\BaseDto;

class LoginDto extends BaseDto
{
    public string $email;
    public string $password;
   
}
