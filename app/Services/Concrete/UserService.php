<?php

namespace App\Services\Concrete;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserAddressRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Models\Address;
use App\Models\UserAddress;
use App\Repositories\Abstract\AddressRepositoryInterface;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\UserServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;
    protected AddressRepositoryInterface $addressRepository;

    public function __construct(UserRepositoryInterface $userRepository, AddressRepositoryInterface $addressRepository)
    {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }


    public function updateAvatar(UpdateAvatarRequest $request): ServiceResponse
    {
        $user = $request->user();

        $currentAvatar = $user->avatar;

        $newPath = $request->file('avatar')->store('avatars');

        $updated = $this->userRepository->updateById($user->id, ['avatar' => $newPath]);

        if ($currentAvatar) {
            Storage::delete($currentAvatar);
        }
        if ($updated) {
            return new ServiceResponse(['message' => 'Avatar updated successfully.'], 200);
        }

        return new ServiceResponse(['message' => 'Failed to update avatar.'], 500);
    }

    public function updateProfile(UpdateUserProfileRequest $request): ServiceResponse
    {
        $user = $request->user();
        // sleep(1);
        $updatedUser = $this->userRepository->updateById($user->id, $request->validated());
        if ($updatedUser) {
            $updatedUser->load('address');
            return new ServiceResponse(['message' => 'Profile data updated successfully.', 'user' => $updatedUser], 200);
        }

        return new ServiceResponse(['message' => 'Failed to update profile data.'], 500);
    }
    public function updateAddress(UpdateUserAddressRequest $request): ServiceResponse
    {
        $user = $request->user();

        $Address = $this->addressRepository->getByPlaceID($request->place_id);

        if ($Address) {
            $Address->update($request->validated());
        } else {
            $Address = Address::create($request->validated());
        }

        $UserAddress = UserAddress::updateOrCreate(
            ['user_id' => $user->id],
            ['address_id' => $Address->id]
        );

        return new ServiceResponse([
            'message' => 'Address updated successfully.',
            'user' => $user->load('address')
        ], 200);
    }
}
