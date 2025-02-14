<?php 

namespace App\Dtos;

use App\Core\BaseDto;

class SendPasswordResetLinkDto extends BaseDto
{
    public string $email;
   
}
