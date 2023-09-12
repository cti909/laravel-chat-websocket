<?php

namespace App\Repositories\Message;

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
            MessageUser::create([
                "is_seen" => false,
                "user_id" => $memberIdList[$i]->member_id,
                "message_id" => $message->id
            ]);
        }
    }
}
