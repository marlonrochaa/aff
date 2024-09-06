<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/tax', [App\Http\Controllers\TaxFiscalController::class, 'getTax'])->name('get.tax');