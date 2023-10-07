<?php

namespace App\Services\Friend;

use App\Http\Requests\Friend\DeleteFriendInvationRequest;
use App\Http\Requests\Friend\SendFriendInvationRequest;
use Illuminate\Http\Request;

interface IFriendService
{
    public static function getAllFriend(Request $request);
    public static function getAllFriendInvitation(Request $request);
    public static function getFriendInvationById(int $friendshipId);
    public static function sendFriendInvation(SendFriendInvationRequest $request);
    public static function acceptInvitation(int $friendshipId);
    public static function rejectInvitation(int $friendshipId);
    public static function unfriend(int $friendshipId);
    public static function deleteFriendInvitation(int $friendshipId);
    public static function cancelFriendInvitation(int $friendshipId);
}
