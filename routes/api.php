<?php

use App\Http\Controllers\APIs\v1\AuthController;
use App\Http\Controllers\APIs\v1\ChatController;
use App\Http\Controllers\APIs\v1\ConversationController;
use App\Http\Controllers\APIs\v1\FriendController;
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
        Route::post('', [UserController::class, 'store']);
        Route::patch('/{userId}', [UserController::class, 'update']);
        Route::delete('/{userId}', [UserController::class, 'destroy']);
        Route::patch('/{userId}/resetPassword', [UserController::class, 'resetPassword']);
        Route::patch('/{userId}/lockUser', [UserController::class, 'lockUser']);
        Route::post('/actionFriendInvitation', [UserController::class, 'actionFriendInvitation']);
    });
});
/**
 * Friend
 */
Route::group(['prefix' => 'friends', 'middleware' => ['auth:api', 'jwt.auth']], function () {
    Route::get('/all', [FriendController::class, 'getAllFriend']);
    Route::get('', [FriendController::class, 'getAllFriendInvitation']);
    Route::get('/{friendshipId}', [FriendController::class, 'getFriendInvitation']);
    Route::post('', [FriendController::class, 'sendFriendInvitation']);
    Route::patch('/{friendshipId}/accept', [FriendController::class, 'acceptInvitation']);
    Route::patch('/{friendshipId}/reject', [FriendController::class, 'rejectInvitation']);
    Route::patch('/{friendshipId}/unfriend', [FriendController::class, 'unfriend']);
    Route::delete('/{friendshipId}', [FriendController::class, 'deleteFriendInvitation']); // reject
    Route::delete('/{friendshipId}/cancel', [FriendController::class, 'cancelFriendInvitation']); // pending
});
/**
 * Conversation
 */
Route::group(['prefix' => 'conversations', 'middleware' => ['auth:api', 'jwt.auth']], function () {
    Route::post('', [ConversationController::class, 'createConversation']);
    Route::get('', [ConversationController::class, 'getAllConversation']);
    Route::get('/all', [ConversationController::class, 'getAllConversationHasMessage']);
    Route::get('/{conversationId}', [ConversationController::class, 'getConversation']);
    Route::get('/detailMa', [ConversationController::class, 'getConversationPrivate']);
    Route::get('/{conversationId}/messages', [ConversationController::class, 'getAllMessageConversation']);
    Route::patch('/{conversationId}', [ConversationController::class, 'updateConversation']);
    Route::patch('/{conversationId}/addMember', [ConversationController::class, 'addMember']);
    Route::patch('/{conversationId}/kickMember', [ConversationController::class, 'kickMember']);
    // Route::patch('/{conversationId}/join', [ConversationController::class, 'joinConvesation']);
    Route::patch('/{conversationId}/leave', [ConversationController::class, 'leaveConversation']);
    Route::delete('/{conversationId}', [ConversationController::class, 'deleteConversation']);
});

/**
 * Message
 */
Route::group(['prefix' => 'messages', 'middleware' => ['auth:api', 'jwt.auth']], function () {
    Route::post('', [MessageController::class, 'createMessage']);
    // Route::get('', [MessageController::class, 'getAllMessage']); // ?
    // Route::get('/{messageId}', [MessageController::class, 'getMessage']); // ?
    // Route::patch('/{messageId}', [MessageController::class, 'updateMessage']);
    Route::patch('/seen', [MessageController::class, 'seenMessage']);
    Route::patch('/{messageId}/remove', [MessageController::class, 'removeMessage']);
    Route::patch('/{messageId}/restore', [MessageController::class, 'restoreMessage']);
    Route::delete('/{messageId}', [MessageController::class, 'deleteMessage']);
});
/**
 * Notifications
 */
Route::group(['prefix' => 'notifications', 'middleware' => ['auth:api', 'jwt.auth']], function () {
    Route::post('', [NotificationController::class, 'createNotification']);
    // Route::get('', [NotificationController::class, 'getAllNotification']);
    // Route::get('/{notificationId}', [NotificationController::class, 'getNotification']);
    // Route::delete('/{notificationId}', [NotificationController::class, 'deleteNotification']);
});

//----------------test--------
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
// Broadcast::routes(['prefix' => '/api/broadcasting/auth', 'middleware' => ['auth:sanctum']]);
