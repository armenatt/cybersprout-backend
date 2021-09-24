<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user', [UserController::class, 'user'])->middleware('auth:api');
    Route::post('/forgetpassword', [ForgetController::class, 'forget']);
    Route::post('/resetpassword', [ResetController::class, 'reset']);
});

Route::prefix('posts')->group(function () {
    // The route below retrieves the 25 latest posts
    Route::get('/get', [PostController::class, 'index']);
    Route::get();


    Route::middleware('auth:api')->group(function () {
// Select role by using the CheckRole:role middleware
// Example: CheckRole:admin
// List of possible roles: admin, user, moderator, creator

        Route::middleware('CheckRole:creator')->group(function () {
            Route::post('/create', [PostController::class, 'store']);
        });
    });

});
