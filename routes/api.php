<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/user', [UserController::class, 'user'])->middleware('auth:api');
    Route::post('/forgetpassword', [ForgetController::class, 'forget']);
    Route::post('/resetpassword', [ResetController::class, 'reset']);
});
// articles
Route::prefix('posts')->group(function () {
    // retrieves the 25 latest posts
    Route::get('/', [PostController::class, 'index']);
    // get the post by its id
    Route::get('/{id}', [PostController::class, 'show']);


    Route::middleware('auth:api')->group(function () {
        // Select role by using the CheckRole:role middleware
        // Example: CheckRole:admin
        // List of possible roles: admin, user, moderator, creator

        Route::middleware('CheckRole:creator')->group(function () {
            Route::post('/create', [PostController::class, 'store']);
        });
    });
});
//quick news
Route::prefix('quicknews')->group(function () {
    Route::get('/', [PostController::class, 'quickNewsIndex']);
    Route::middleware('auth:api, CheckRole:creator')->group(function () {
        Route::post('/create', [PostController::class, 'quickNewsStore']);
    });
});

/* Comments urls
 * this section needs refactoring
 */
Route::prefix('/posts')->group(function () {
    // get comments by post id
    Route::get('/{postId}/comments', [CommentController::class, 'show']);
    Route::get('/{postId}/comments/{parentCommentId}', [CommentController::class, 'showReplies']);
    Route::middleware('auth:api')->group(function () {
        Route::middleware('CheckRole:user')->group(function () {
            Route::post('/{postId}/comments', [CommentController::class, 'store']);
            Route::post('/{postId}/comments/{parentCommentId}/reply', [CommentController::class, 'storeReply']);
        });
    });

});
