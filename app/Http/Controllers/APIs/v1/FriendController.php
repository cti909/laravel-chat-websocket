<?php

namespace App\Http\Controllers\APIs\v1;

use App\Constants\MessageConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Friend\DeleteFriendInvationRequest;
use App\Http\Requests\Friend\SendFriendInvationRequest;
use App\Http\Requests\Friend\StoreFriendRequest;
use App\Http\Responses\BaseResponse;
use App\Repositories\Friend\FriendRepository;
use App\Services\Friend\FriendService;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    use BaseResponse;

    public function __construct()
    {
        new FriendService(new FriendRepository());
    }
    public function getAllFriend(Request $request)
    {
        try {
            $data = FriendService::getAllFriend($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_FRIENDS_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_FRIENDS_FAILED
            );
        }
    }
    public function getAllFriendInvitation(Request $request)
    {
        try {
            $data = FriendService::getAllFriendInvitation($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_FRIENDS_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_FRIENDS_FAILED
            );
        }
    }
    public function getFriendInvitation(Request $request, int $friendshipId)
    {
        try {
            $data = FriendService::getFriendInvationById($friendshipId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_FRIENDS_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_FRIENDS_FAILED
            );
        }
    }
    public function sendFriendInvitation(SendFriendInvationRequest $request)
    {
        try {
            $data = FriendService::sendFriendInvation($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$SEND_FRIEND_INVATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$SEND_FRIEND_INVATION_FAILED
            );
        }
    }
    /**
     * accept friend invation
     */
    public function acceptInvitation(Request $request, mixed $friendshipId)
    {
        try {
            $data = FriendService::acceptInvitation($friendshipId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$ACCEPT_FRIEND_INVATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$ACCEPT_FRIEND_INVATION_FAILED
            );
        }
    }
    /**
     * reject friend invation
     */
    public function rejectInvitation(Request $request, mixed $friendshipId)
    {
        try {
            $data = FriendService::rejectInvitation($friendshipId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$REJECT_FRIEND_INVATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$REJECT_FRIEND_INVATION_FAILED
            );
        }
    }
    /**
     * unfriend
     */
    public function unfriend(Request $request, mixed $friendshipId)
    {
        try {
            $data = FriendService::unfriend($friendshipId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$REJECT_FRIEND_INVATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$REJECT_FRIEND_INVATION_FAILED
            );
        }
    }
    /**
     * delete friend invation with status reject
     */
    public function deleteFriendInvitation(Request $request, mixed $friendshipId)
    {
        try {
            $data = FriendService::deleteFriendInvitation($friendshipId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$DELETE_FRIEND_INVATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$DELETE_FRIEND_INVATION_FAILED
            );
        }
    }
    /**
     * delete friend invation with status pending
     */
    public function cancelFriendInvitation(Request $request, mixed $friendshipId)
    {
        try {
            $data = FriendService::cancelFriendInvitation($friendshipId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$CANCEL_FRIEND_INVATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$CANCEL_FRIEND_INVATION_FAILED
            );
        }
    }
}
