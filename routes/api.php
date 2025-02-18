<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

Route::prefix('auth')->group(function () {

    Route::post('register', [AuthController::class, 'register']);

    Route::post('login', [AuthController::class, 'login']);

    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail']);

    Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.reset');

    // Route::post('email/change-request', [EmailChangeController::class, 'sendChangeRequest'])->middleware('auth:sanctum');

    // Route::post('email/change', [EmailChangeController::class, 'changeEmail'])->middleware('auth:sanctum');
});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {

    Route::get('profile', [UserController::class, 'getProfile']);
    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::put('update-address', [UserController::class, 'updateAddress']);
    Route::post('update-avatar', [UserController::class, 'updateAvatar']);
});


// routes/api.php

Route::get('/profile-image/{fileName}', function (Request $request, $fileName) {
    $filePath = 'avatars/' . $fileName;

    if (!Storage::exists($filePath)) {
        return response()->json(['message' => 'File not found'], 404);
    }

    // Cache süresi (örn: 10 dakika)
    $cacheKey = 'signed_url_' . $fileName;
    $temporaryUrl = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($filePath) {
        return Storage::disk('s3')->temporaryUrl($filePath, now()->addMinutes(10));
    });

    return redirect($temporaryUrl,302);
})->name('profile-image');
