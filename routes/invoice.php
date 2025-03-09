<?php

use App\Http\Controllers\InvoiceController;
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

Route::name('invoices.')->prefix('invoices')->group(function () {
    Route::get('', [InvoiceController::class, 'index'])->name('index');
    Route::get('/show', [InvoiceController::class, 'show'])->name('show');
    Route::get('/create', [InvoiceController::class, 'create'])->name('create');
    Route::get('/create-invoice', [InvoiceController::class, 'createInvoice'])->name('create-invoice');
    Route::put('/update', [InvoiceController::class, 'update'])->name('update');
    Route::get('/pdf-download', [InvoiceController::class, 'preview'])->name('pdf-download');
});
