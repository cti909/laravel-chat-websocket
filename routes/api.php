<?php

use App\Http\Controllers\APIs\v1\AuthController;
use App\Http\Controllers\APIs\v1\ChatController;
use App\Http\Controllers\APIs\v1\MessageController;
use App\Http\Controllers\APIs\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Auth
 */
Route::group(['prefix' => 'auth'], function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name("login");
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
/**
 * User
 */
Route::group(['prefix' => 'users'], function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('/{userId}', [UserController::class, 'show']);
    Route::middleware([
        'auth:api',
        'jwt.auth',
        // 'checkUserIdMatch',
    ])->group(function () {
        Route::put('/{userId}', [UserController::class, 'update']);
        Route::put('/{userId}/resetPassword', [UserController::class, 'resetPassword']);
        Route::put('/{userId}/lockUser', [UserController::class, 'lockUser']);
        // Route::delete('/{post_id}', [UserController::class, 'destroy']);

        Route::post('/actionFriendInvitation', [UserController::class, 'actionFriendInvitation']);
    });
});
/**
 * Message
 */
Route::group(['prefix' => 'messages', 'middleware' => ['auth:api', 'jwt.auth']], function () {
    Route::post('sendMessage', [MessageController::class, 'store']);
    // Route::put('/{userId}/resetPassword', [UserController::class, 'resetPassword']);
    // Route::put('/{userId}/lockUser', [UserController::class, 'lockUser']);
    // Route::delete('/{post_id}', [UserController::class, 'destroy']);
});

//
/**
 * Chat
 */
Route::group(['prefix' => 'chat'], function () {
    Route::post('/message', [ChatController::class, 'test']);
});
/**
 * Notification
 */
Route::group(['prefix' => 'notification'], function () {
    // Route::post('/notification', [NotificationController::class, 'test']);
});

Route::post('/chat', [ChatController::class, 'demochat']);
Broadcast::routes(['prefix' => '/api/broadcasting/auth', 'middleware' => ['auth:sanctum']]);
