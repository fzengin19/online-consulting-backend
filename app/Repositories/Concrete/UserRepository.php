<?php

namespace App\Repositories\Concrete;

use App\Models\User;
use App\Repositories\Abstract\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function find(int $id)
    {
        return User::find($id);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function updateAvatar(int $id, string $Avatar)
    {
        return User::where('id', $id)->update([
            'avatar' => $Avatar,
        ]);
    }

    public function updateProfile(int $id, array $data)
    {
        $updated = User::where('id', $id)->update($data);

        return User::find($id);
    }
}
