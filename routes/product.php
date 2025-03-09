<?php

use App\Http\Controllers\ProductController;
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

Route::name('products.')->prefix('products')->group(function () {
    Route::get('', [ProductController::class, 'index'])->name('index');
    Route::get('/show', [ProductController::class, 'profile'])->name('show');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::delete('/destroy', [ProductController::class, 'delete'])->name('destroy');
    Route::get('/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/update', [ProductController::class, 'update'])->name('update');
});
