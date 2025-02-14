<?php

namespace App\Repositories\Abstract;

use App\Core\Abstract\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    public function findByEmail(string $email);
}
