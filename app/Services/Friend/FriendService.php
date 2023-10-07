<?php

namespace App\Services\Friend;

use App\Http\Filters\BaseFilter;
use App\Http\Requests\Friend\DeleteFriendInvationRequest;
use App\Http\Requests\Friend\SendFriendInvationRequest;
use App\Http\Responses\BaseHTTPResponse;
use App\Repositories\Friend\IFriendRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class FriendService extends BaseService implements IFriendService
{
    private static $friendRepository;
    private static $filter;
    /**
     * Construct
     */
    public function __construct(IFriendRepository $friendRepository)
    {
        self::$friendRepository = $friendRepository;
        self::$filter = new BaseFilter;
    }

    public static function getAllFriend(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $data = [
            'sender_id' => $user->id,
            'status' => $request->input('status'),
            'infor' => '%' . $request->input('infor') . '%'
        ];
        return self::$friendRepository->getAllFriend($data);
    }
    // getAllFriend by receiver ?
    public static function getAllFriendInvitation(Request $request)
    {
        // pending
        $user = JWTAuth::parseToken()->authenticate();
        $data = [
            'user_id' => $user->id,
        ];
        return self::$friendRepository->getAllFriendInvitation($data);
    }
    public static function getFriendInvationById(int $friendshipId)
    {
        return self::$friendRepository->getFriendInvationById($friendshipId);
    }
    public static function sendFriendInvation(SendFriendInvationRequest $request)
    {
        if ($request->input('sender_id') == $request->input('receiver_id')) {
            throw new \Exception('You must send friend invation with other', 400);
        }
        $data = [
            'sender_id' => $request->input('sender_id'),
            'receiver_id' => $request->input('receiver_id'),
            'status' => 'pending'
        ];
        return self::$friendRepository->sendFriendInvation($data);
    }
    public static function acceptInvitation(int $friendshipId)
    {
        $data = [
            'friendship_id' => $friendshipId,
            'status_old' => 'pending',
            'status' => 'accept'
        ];
        return self::$friendRepository->replyInvitation($data);
    }
    public static function rejectInvitation(int $friendshipId)
    {
        $data = [
            'friendship_id' => $friendshipId,
            'status_old' => 'pending',
            'status' => 'reject'
        ];
        return self::$friendRepository->replyInvitation($data);
    }
    public static function unfriend(int $friendshipId)
    {
        $data = [
            'friendship_id' => $friendshipId,
            'status_old' => 'accept',
            'status' => 'reject'
        ];
        return self::$friendRepository->replyInvitation($data);
    }
    public static function deleteFriendInvitation(int $friendshipId)
    {
        // dd($request->input());
        $data = [
            'friendship_id' => $friendshipId,
            'status' => 'reject'
        ];
        return self::$friendRepository->deleteFriendInvitation($data);
    }
    public static function cancelFriendInvitation(int $friendshipId)
    {
        // dd($request->input());
        $data = [
            'friendship_id' => $friendshipId,
            'status' => 'pending'
        ];
        return self::$friendRepository->deleteFriendInvitation($data);
    }
}
