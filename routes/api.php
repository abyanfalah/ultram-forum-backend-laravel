<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\PostReactionController;
use App\Http\Controllers\ThreadReactionController;

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

Route::middleware(['auth:sanctum'])->get('/userdata', function (Request $request) {
    return $request
        ->user()
        ->withFollowDetails();
});

Route::middleware(['auth:sanctum'])->get('/you-are-authenticated', function (Request $request) {
    return 'you are authenticated';
});

Route::middleware(['auth:sanctum'])->prefix('/token/test')->group(function () {
    Route::get('/', function () {
        return 'GET token ok';
    });

    Route::post('/', function () {
        return 'POST token ok';
    });
});


Route::middleware(['auth:sanctum'])->group(function () {

    // user
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        // Route::get('/{user}', [UserController::class, 'show']);
        Route::get('/{username}', [UserController::class, 'showByUsername']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    // thread
    Route::prefix('thread')->group(function () {
        Route::get('/', [ThreadController::class, 'index']);
        Route::get('/{thread}', [ThreadController::class, 'show']);
        Route::post('/', [ThreadController::class, 'store']);
        Route::put('/{thread}', [ThreadController::class, 'update']);
        Route::delete('/{thread}', [ThreadController::class, 'destroy']);

        Route::get('/user/{user}', [ThreadController::class, 'showByUser']);
    });

    // post
    Route::prefix('post')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::get('/{post}', [PostController::class, 'show']);
        Route::post('/', [PostController::class, 'store']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);

        Route::get('/user/{user}', [PostController::class, 'showByUser']);

        Route::get('/thread/{thread}/parent', [PostController::class, 'showParentByThread']);
        Route::get('/thread/{thread}', [PostController::class, 'showByThread']);
    });

    // category
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{category}', [CategoryController::class, 'show']);
        // Route::post('/', [CategoryController::class, 'store'])->middleware('role:superAdmin');
        // Route::put('/{category}', [CategoryController::class, 'update']);
        // Route::delete('/{category}', [CategoryController::class, 'destroy']);
    });

    // reaction
    Route::prefix('react')->group(function () {
        Route::get('/thread/{thread}', [ThreadReactionController::class, 'showByThread']);
        Route::post('/thread', [ThreadReactionController::class, 'store']);

        Route::get('/post/{post}', [PostReactionController::class, 'showByPost']);
        Route::post('/post', [PostReactionController::class, 'store']);
    });

    // follow
    Route::prefix('follow')->group(function () {
        Route::post('/', [FollowerController::class, 'store']);
    });

    // conversation
    Route::prefix('conversation')->group(function () {
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{conversation}', [ConversationController::class, 'show']);
        Route::post('/', [ConversationController::class, 'store']);
    });

    // message
    Route::prefix('message')->group(function () {
        Route::get('/{conversation}', [MessageController::class, 'index']);
        // Route::get('/{message}', [MessageController::class, 'show']);
        Route::post('/', [MessageController::class, 'store']);
    });
});
