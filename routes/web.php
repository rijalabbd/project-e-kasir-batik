<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ProductController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk mencetak struk
Route::get('/receipt/print/{transactionId}', [ReceiptController::class, 'print'])->name('receipt.print');

// Rute untuk mengelola produk
Route::resource('products', ProductController::class);
