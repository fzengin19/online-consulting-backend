<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SleepMiddleware;
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

    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::put('update-address', [UserController::class, 'updateAddress']);
    Route::post('update-avatar', [UserController::class, 'updateAvatar']);
})->middleware(SleepMiddleware::class);


// routes/api.php

Route::get('/images/{fileName}', function (Request $request, $fileName) {
    $path = storage_path('app/images/' . $fileName);

    if (!Storage::exists($path)) {
        return response()->json(['message' => 'File not found'], 404);
    }

    return response()->file($path);
});

