<?php

use App\Http\Controllers\BrandController;
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
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::delete('/destroy', [CategoryController::class, 'delete'])->name('destroy');
        Route::get('/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update', [CategoryController::class, 'update'])->name('update');
    });

    Route::name('brands.')->prefix('brands')->group(function () {
        Route::get('', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('store', [BrandController::class, 'store'])->name('store');
        Route::delete('/destroy', [BrandController::class, 'delete'])->name('destroy');
        Route::get('/edit', [BrandController::class, 'edit'])->name('edit');
        Route::put('/update', [BrandController::class, 'update'])->name('update');
    });
});
