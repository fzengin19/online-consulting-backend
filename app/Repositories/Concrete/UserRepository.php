<?php

namespace App\Repositories\Concrete;

use App\Core\Concrete\BaseRepository;
use App\Models\User;
use App\Repositories\Abstract\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct()
    {
        parent::__construct(new User());
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }


}
