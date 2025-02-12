<?php

namespace App\Services\Concrete;

use App\Http\Requests\User\UpdateAvatarRequest;
use App\Http\Requests\User\UpdateUserAddressRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Repositories\Abstract\AddressRepositoryInterface;
use App\Repositories\Abstract\UserAddressRepositoryInterface;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\UserServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;
    protected AddressRepositoryInterface $addressRepository;
    protected UserAddressRepositoryInterface $userAddressRepository;

    public function __construct(UserRepositoryInterface $userRepository, AddressRepositoryInterface $addressRepository, UserAddressRepositoryInterface $userAddressRepository)
    {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
        $this->userAddressRepository = $userAddressRepository;
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

        $updatedUser = $this->userRepository->updateById($user->id, $request->validated());
        if ($updatedUser) {
            $updatedUser->load('address');
            return new ServiceResponse(['message' => 'Profile data updated successfully.', 'user' => $updatedUser], 200);
        }

        return new ServiceResponse(['message' => 'Failed to update profile data.'], 500);
    }
    public function updateAddress(UpdateUserAddressRequest $request): ServiceResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $user = $request->user();

                $address = $this->addressRepository->updateOrCreateByPlaceId(
                    $request->place_id,
                    $request->validated()
                );

                $this->userAddressRepository->updateOrCreateByUserId(
                    $user->id,
                    ['address_id' => $address->id]
                );

                return new ServiceResponse([
                    'message' => 'Address updated successfully.',
                    'user' => $user->load('address')
                ], 200);
            });
        } catch (\Exception $e) {

            Log::error('Address update failed: ' . $e->getMessage());

            return new ServiceResponse([
                'message' => 'Failed to update address. Please try again.'
            ], 500);
        }
    }
}
