<?php

namespace App\Services\Concrete;

use App\Dtos\UpdateAvatarDto;
use App\Dtos\UpdateUserAddressDto;
use App\Dtos\UpdateUserProfileDto;
use App\Http\Requests\User\UpdateUserAddressRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Repositories\Abstract\AddressRepositoryInterface;
use App\Repositories\Abstract\UserAddressRepositoryInterface;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Services\Abstract\UserServiceInterface;
use App\Services\ServiceResponse;
use Illuminate\Support\Facades\Auth;
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

    public function getUserProfile(): ServiceResponse
    {
        $user = Auth::user();
        $user->load('address');
        return new ServiceResponse(['user' => $user], 200);
    }

    public function updateAvatar(UpdateAvatarDto $updateAvatarDto): ServiceResponse
    {
        $user = Auth::user();

        $currentAvatar = $user->avatar;

        $name = $updateAvatarDto->avatar->getClientOriginalName();
      
        $newPath = $updateAvatarDto->avatar->storeAs('avatars', $name);

        $updated = $this->userRepository->update($user->id, ['avatar' => $newPath]);

        if ($currentAvatar) {
            Storage::delete($currentAvatar);
        }
        if ($updated) {
            return new ServiceResponse(['message' => 'Avatar updated successfully.'], 200);
        }

        return new ServiceResponse(['message' => 'Failed to update avatar.'], 500);
    }

    public function updateProfile(UpdateUserProfileDto $updateUserProfileDto): ServiceResponse
    {
        $user = Auth::user();

        $updatedUser = $this->userRepository->update($user->id, $updateUserProfileDto->toArray());
        if ($updatedUser) {
            $updatedUser->load('address');
            return new ServiceResponse(['message' => 'Profile data updated successfully.', 'user' => $updatedUser], 200);
        }

        return new ServiceResponse(['message' => 'Failed to update profile data.'], 500);
    }
    public function updateAddress(UpdateUserAddressDto $updateUserAddressDto): ServiceResponse
    {
        try {
            return DB::transaction(function () use ($updateUserAddressDto) {
                $user = Auth::user();
                $address = $this->addressRepository->updateOrCreateByPlaceId(
                    $updateUserAddressDto->place_id,
                    $updateUserAddressDto->toArray()
                );

                $this->userAddressRepository->updateOrCreateByUserId(
                    $user->id,
                    ['address_id' => $address->id]
                );

                return new ServiceResponse([
                    'message' => 'Address updated successfully.',
                    'user' => $user->refresh()->load('address')
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
