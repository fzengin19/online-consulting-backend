<?php

namespace App\Repositories\Abstract;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function findByEmail(string $email);
    public function find(int $id);
    public function updateAvatar(int $id, string $Avatar);
    public function updateProfile(int $id, array $data);
}
