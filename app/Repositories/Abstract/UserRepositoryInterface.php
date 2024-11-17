<?php

namespace App\Repositories\Abstract;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function findByEmail(string $email);
    public function find(int $id);
    public function updateById(int $id, array $data);
}
