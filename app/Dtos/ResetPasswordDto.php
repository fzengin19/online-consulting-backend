<?php 

namespace App\Dtos;

use App\Core\BaseDto;

class ResetPasswordDto extends BaseDto
{
    public string $token;
    public string $email;
    public string $password;
    public string $password_confirmation;
   
}