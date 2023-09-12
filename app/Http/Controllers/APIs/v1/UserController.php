<?php

namespace App\Http\Controllers\APIs\v1;

use App\Constants\MessageConstant;
use App\Events\FriendInvite;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\User\LockUserRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\BaseHTTPResponse;
use App\Http\Responses\BaseResponse;
use App\Models\User;
use App\Notifications\FriendInviteNotification;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use BaseResponse;
    public function __construct()
    {
        new UserService(new UserRepository());
    }
    public function index(Request $request)
    {
        try {
            $data = UserService::getUserList($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_USERS_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_USERS_SUCCESS
            );
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, mixed $id)
    {
        try {
            $data = UserService::getUserById($id);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_DETAIL_USER_SUCCESS
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_DETAIL_USER_FAILED
            );
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, mixed $id)
    {
        try {
            $user = User::findOrFail($id);
            // if (Auth::user()->id != $comment->creator_id)
            //     throw new Exception("User doesn't have permission to edit");
            $update_data = UserService::updateUser($request, $id);
            $data = UserService::getUserList($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$UPDATE_USER_SUCCESS
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$UPDATE_USER_FAILED,
                400,
                'Bad Request'
            );
        }
    }

    public function resetPassword(ResetPasswordRequest $request, mixed $id)
    {
        try {
            $user = User::findOrFail($id);
            // if (Auth::user()->id != $comment->creator_id)
            //     throw new Exception("User doesn't have permission to edit");
            $update_data = UserService::resetPassword($request, $id);
            $data = UserService::getUserList($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$RESET_PASSWORD_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$RESET_PASSWORD_FAILDED,
                400,
                'Bad Request'
            );
        }
    }
    public function lockUser(LockUserRequest $request, mixed $id)
    {
        try {
            $user = User::findOrFail($id);
            $update_data = UserService::lockUser($request, $id);
            $data = UserService::getUserList($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$LOCK_USER_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$LOCK_USER_FAILED,
                400,
                'Bad Request'
            );
        }
    }
    public function actionFriendInvitation(Request $request)
    {
        try {
            $ownerId = $request->input("owner_id");
            $targetId = $request->input("target_id");
            $status = $request->input("status");
            $update_data = UserService::actionFriendInvitation($request);
            broadcast(new FriendInvite($ownerId, $targetId, $status));
            return $this->success(
                $request,
                $update_data,
                MessageConstant::$UPDATE_USER_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$UPDATE_USER_FAILED,
                400,
                'Bad Request'
            );
        }
    }
    public function isOnline(Request $request, $user_id)
    {
        $user['id'] = $user_id;
        Cache::put('user-is-online-' . $user_id, $user_id, 3600);
        broadcast(new UserOnline($user));
    }
    public function listOnlineUsers($users)
    {


        //TODO
        // Use userId to get all users in friends list
        // run Cache::get('user-is-online-'.$friendId) in a loop
        // store results in an array
        // send results in response
        error_log('IN LISTONLINEUSERS FUNCTION');

        foreach ($users as $channel) {
            $userId = $channel->users[0]->id;
            $userData = $channel->users[0];
            error_log(Cache::get('user-is-online-' . $userId));
            if (Cache::has('user-is-online-' . $userId)) {
                $channel->users[0]->is_online = 1;
            } else {
                $channel->users[0]->is_online = 0;
            }
        }

        return $users;
    }
    public function isOffline(Request $request, $user_id)
    {
        $user['id'] = $user_id;
        error_log("IN ISOFFLINE");
        Cache::forget('user-is-online-' . $user_id);
        broadcast(new UserOffline($user));
    }
}
