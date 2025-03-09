<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::name('users.')->prefix('users')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('store', [UserController::class, 'store'])->name('store');
    Route::delete('/destroy', [UserController::class, 'delete'])->name('destroy');
    Route::get('/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/update', [UserController::class, 'update'])->name('update');
});

Route::name('my.')->prefix('my')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});
