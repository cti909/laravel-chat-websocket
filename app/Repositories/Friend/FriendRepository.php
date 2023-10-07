<?php

namespace App\Repositories\Friend;

use App\Http\Responses\BaseHTTPResponse;
use App\Http\Responses\BaseResponse;
use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Friendship;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

class FriendRepository extends BaseRepository implements IFriendRepository
{
    use BaseResponse;
    public function getModel()
    {
        return Friendship::class;
    }
    public function getAllFriend(mixed $data)
    {
        $friendInvitationList = Friendship::select('users.*')
            ->join('users', 'users.id', '=', 'receiver_id')
            ->where('sender_id', $data['sender_id'])
            ->where('status', $data['status'])
            ->where('users.name', 'like', $data['infor'])
            ->get();
        return $friendInvitationList;
    }
    public function getAllFriendInvitation(mixed $data)
    {
        $friendInvitationSend = Friendship::with('receiver')
            ->where('sender_id', $data['user_id'])
            ->where('status', 'pending')
            ->get();
        $friendInvitationReceive = Friendship::with('sender')
            ->where('receiver_id', $data['user_id'])
            ->where('status', 'pending')
            ->get();
        $reponseData = [
            'senderList' => $friendInvitationSend,
            'receiverList' => $friendInvitationReceive
        ];
        return $reponseData;
    }
    public function getFriendInvationById(mixed $friendshipId)
    {
        $friendInvitationList = Friendship::find($friendshipId);
        $friendList = User::where('id', '=', $friendInvitationList->receiver_id)->get();
        $responseData[] = [
            'invitation' => $friendInvitationList,
            'receiver_information' => $friendList,
        ];
        return $responseData;
    }
    public function sendFriendInvation(mixed $data)
    {
        $isFriendInvitation1 = Friendship::where([
            ['sender_id', '=', $data['sender_id']],
            ['receiver_id', '=', $data['receiver_id']]
        ])->get();

        $isFriendInvitation2 = Friendship::where([
            ['sender_id', '=', $data['receiver_id']],
            ['receiver_id', '=', $data['sender_id']]
        ])->get();

        if ($isFriendInvitation1->count() == 0 && $isFriendInvitation2->count() == 0) {
            $newFriend = $this->_model::create($data);
        } else {
            throw new \Exception('Friend Invation is exist', 400);
        }

        if ($newFriend) {
        }

        return $newFriend;
    }
    public function replyInvitation(mixed $data)
    {
        $friendship = Friendship::where([
            ['id', '=', $data['friendship_id']],
            ['status', '=', $data['status_old']]
        ])->first();

        if ($friendship) {
            $friendship->update(['status' => $data['status']]);
            // create conversation private
            $receiver = User::where('id', '=', $friendship->receiver_id)->first();
            $sender = User::where('id', '=', $friendship->sender_id)->first();
            $memberIdList = [$friendship->sender_id, $friendship->receiver_id];
            $conversation = Conversation::create([
                'name' => $receiver->name . " - " . $sender->name,
                'member_count' => 2,
                'type' => 'private',
            ]);
            for ($i = 0; $i < 2; $i++) {
                $member = ConversationUser::create([
                    'is_owner' => 1,
                    'member_id' => $memberIdList[$i],
                    'conversation_id' => $conversation->id,
                ]);
            }
            return $friendship;
        } else {
            throw new \Exception('Record not exist', 400);
        }
    }
    public function deleteFriendInvitation(mixed $data)
    {
        $friendship = Friendship::where([
            ['id', '=', $data['friendship_id']],
            ['status', '=', $data['status']]
        ])->first();
        if ($friendship) {
            $friendship->delete();
            return $friendship;
        } else {
            throw new \Exception('Record not exist', 400);
        }
    }
}
