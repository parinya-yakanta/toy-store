<?php

use App\Http\Controllers\CategoryController;
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

Route::name('masters.')->prefix('masters')->group(function () {
    Route::name('categories.')->prefix('categories')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
    });

    Route::name('brands.')->prefix('brands')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
    });
});
