<?php

namespace App\Repositories\Message;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Message;
use App\Models\MessageUser;
use App\Repositories\BaseRepository;

class MessageRepository extends BaseRepository implements IMessageRepository
{
    public function getModel()
    {
        return Message::class;
    }
    public function createMessageAndStatus(mixed $data)
    {
        $message = Message::create($data);

        $memberIdList = ConversationUser::select('member_id')
            ->where('conversation_id', $data["conversation_id"])
            ->get();
        // dd(count($memberIdList));
        for ($i = 0; $i < count($memberIdList); $i++) {
            if ($memberIdList[$i]->member_id != $data['sender_id'])
                MessageUser::create([
                    "is_seen" => false,
                    "user_id" => $memberIdList[$i]->member_id,
                    "message_id" => $message->id
                ]);
        }
        return $message;
    }
    public function seenMessage(mixed $data)
    {
        $userSeenList = MessageUser::select('message_users.*')
            ->join('messages', 'messages.id', '=', 'message_users.message_id')
            ->where('user_id', '=', $data['user_id'])
            ->where('messages.conversation_id', '=', $data['conversation_id'])
            ->where('message_users.is_seen', '=', false)
            ->get();
        foreach ($userSeenList as $userSeen) {
            $userSeen->is_seen = 1; // true
            $userSeen->save();
            // $userSeen->update(['is_seen',true]);
        }
        // dd($userSeen);
        return $userSeenList;
    }
}
