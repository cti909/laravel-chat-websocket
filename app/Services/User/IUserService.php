<?php

namespace App\Services\User;

use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Http\Request;

interface IUserService
{
    public static function getUserList(Request $request);
    public static function getUserById($id);
    public static function createUser(StoreUserRequest $request);
    public static function updateUser(UpdateUserRequest $request, $id);
    public static function resetPassword(ResetPasswordRequest $request, $id);
    public static function lockUser(Request $request, mixed $id);
    public static function actionFriendInvitation(Request $request);
}
