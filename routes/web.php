<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(UserAuthenticationMiddleware::class)->group(function(){
 Route::get('user-with-posts',[UserController::class,'UserWithPosts'])->name('user.With.posts');
 //creating post with tag 
});
