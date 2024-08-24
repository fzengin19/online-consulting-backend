<?php

namespace App\Services\Concrete;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\UserServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function updateAvatar(UpdateAvatarRequest $request): ServiceResponse
    {
        $user = $request->user();

        $currentAvatar = $user->avatar;

        $newPath = $request->file('avatar')->store('avatars');

        $updated = $this->userRepository->updateAvatar($user->id, $newPath);

        if ($currentAvatar) {
            Storage::delete($currentAvatar);
        }
        if ($updated) {
            return new ServiceResponse(['message' => 'Avatar updated successfully.'], 200);
        }

        return new ServiceResponse(['message' => 'Failed to update avatar.'], 500);
    }
}
