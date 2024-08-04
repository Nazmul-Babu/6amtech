<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('throttle:60,1')->group(function () {
    Route::post('login', [ApiController::class, 'login']);
    Route::post('posts', [ApiController::class, 'posts']);
    Route::post('send-notification', [ApiController::class, 'sendNotification']);
});


