<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SleepMiddleware;

Route::prefix('auth')->group(function () {
    // Kullanıcı bilgilerini getirme


    // Kayıt olma
    Route::post('register', [AuthController::class, 'register']);

    // Giriş yapma
    Route::post('login', [AuthController::class, 'login']);

    // Çıkış yapma
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // // Parola sıfırlama maili gönderme
    // Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail']);

    // // Parola sıfırlama koduyla birlikte yeni parola gönderme
    // Route::post('password/reset', [PasswordResetController::class, 'reset']);

    // // E-posta değiştirme isteği gönderme
    // Route::post('email/change-request', [EmailChangeController::class, 'sendChangeRequest'])->middleware('auth:sanctum');

    // // E-posta değiştirme
    // Route::post('email/change', [EmailChangeController::class, 'changeEmail'])->middleware('auth:sanctum');
});

Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {

    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    Route::post('update-profile-picture', [UserController::class, 'updateAvatar']);
});
