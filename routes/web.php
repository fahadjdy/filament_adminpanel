<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductPdfController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products/brochure', [ProductPdfController::class, 'generate'])
    ->name('products.brochure');
