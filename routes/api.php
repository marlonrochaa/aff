<?php

use App\Http\Controllers\PostbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::match(['get', 'post'], '/postback', function (Request $request) {
//     Log::info(json_encode($request->all()));
// });

Route::match(['get', 'post'],'/postback', [PostbackController::class, 'handle']);

