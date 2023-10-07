<?php

namespace App\Http\Controllers\APIs\v1;

use App\Constants\MessageConstant;
use App\Events\FriendInvite;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\User\LockUserRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
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
     * save
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = UserService::createUser($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$CREATE_USER_SUCCESS,
                201,
                BaseHTTPResponse::$HTTP[201]
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$CREATE_USER_FAILED
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
            $data = UserService::updateUser($request, $id);
            // $data = UserService::getUserList($request);
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
    public function destroy(Request $request, mixed $id)
    {
        try {
            $data = UserService::deleteUser($id);
            return $this->success(
                $request,
                $data,
                MessageConstant::$DELETE_USER_SUCCESS
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$DELETE_USER_FAILED,
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
            // $data = UserService::getUserList($request);
            return $this->success(
                $request,
                null,
                MessageConstant::$RESET_PASSWORD_SUCCESS,
                204,
                BaseHTTPResponse::$HTTP[204]
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
            $data = UserService::lockUser($request, $id);
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
}
