<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'place_id',
    ];

    public function users()
    {
        return $this->hasManyThrough(User::class, UserAddress::class, 'address_id', 'id', 'id', 'user_id');
    }
}
