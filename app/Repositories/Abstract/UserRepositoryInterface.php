<?php

namespace App\Repositories\Concrete;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function findByEmail(string $email);
}
