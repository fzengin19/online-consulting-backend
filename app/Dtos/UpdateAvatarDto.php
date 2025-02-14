<?php 

namespace App\Dtos;

use App\Core\BaseDto;
use Illuminate\Http\UploadedFile;

class UpdateAvatarDto extends BaseDto
{
    public UploadedFile $avatar;

    public function __construct(UploadedFile $avatar)
    {
        $this->avatar = $avatar;
    }
   
}
