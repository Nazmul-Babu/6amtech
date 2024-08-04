<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackendAuthController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\BackendAuthCheckMiddleware;
use App\Http\Middleware\IpWhitelistMiddleware;
use App\Http\Middleware\UserAuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(UserAuthenticationMiddleware::class)->group(function () {
    Route::get('user-with-posts', [UserController::class, 'UserWithPosts'])->name('user.With.posts');
    Route::post('create-post', [PostController::class, 'create_post']);
    Route::post('create-comment', [PostController::class, 'create_comment']);
    Route::get('filtering-post-by-tag', [PostController::class, 'filtering_post_by_tag']);
    //creating post with tag 
});
Route::prefix('backend')->group(function () {
    Route::get('login', [BackendAuthController::class, 'login']);
    Route::get('logout', [BackendAuthController::class, 'logout']);
    // route name prefix 
    Route::name('admin.')->group(function () {
        Route::middleware([BackendAuthCheckMiddleware::class . ':admin',IpWhitelistMiddleware::class])->group(function () { // concate a role
            Route::get('/delete-post/{id}', [AdminController::class, 'delete_post']);
        });
    });
    Route::middleware([BackendAuthCheckMiddleware::class . ':operator',IpWhitelistMiddleware::class])->group(function () { // concate a role
        // route name prefix 
        Route::name('operator.')->group(function () {
            Route::get('/approve-post/{id}', [OperatorController::class, 'approve_post']);
             // handle csv file 
            Route::match(['get','post'],'user-upload',[OperatorController::class,'user_upload'])->name('user.upload');
        });
    });
});