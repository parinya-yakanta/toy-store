<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->prefix('auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginStore'])->name('login.store');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('forgot', [AuthController::class, 'forgotStore'])->name('forgot.store');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
    Route::post('reset-password', [AuthController::class, 'resetPasswordStore'])->name('reset.password.store');
});
