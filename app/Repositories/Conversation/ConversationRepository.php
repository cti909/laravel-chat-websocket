<?php

namespace App\Repositories\Conversation;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Message;
use App\Repositories\BaseRepository;

class ConversationRepository extends BaseRepository implements IConversationRepository
{
    public function getModel()
    {
        return Conversation::class;
    }
    public function createConversation(mixed $data)
    {
        // dd($data);
        $conversation = Conversation::create([
            'name' => $data['name'],
            'member_count' => $data['member_count'],
            'type' => $data['type'],
        ]);
        // dd(count($data['user_list']));
        $memberList = [];
        for ($i = 0; $i < count($data['user_list']); $i++) {
            $member = ConversationUser::create([
                'is_owner' => $data['user_list'][$i]['is_owner'],
                'member_id' => $data['user_list'][$i]['member_id'],
                'conversation_id' => $conversation->id,
            ]);
            array_push($memberList, $member);
        }
        // $conversationDetail = [
        //     'conversation' => $conversation,
        //     'member' => $memberList
        // ];
        return $conversation;
    }
    public function getAllConversation(mixed $data)
    {
        // dd($data);
        $conversation = Conversation::select('conversations.*')
            ->join('conversation_users', 'conversations.id', '=', 'conversation_users.conversation_id')
            ->where('conversation_users.member_id', $data['member_id'])
            ->where('conversations.type', $data['type'])
            ->get();
        return $conversation;
    }
    public function getAllConversationHasMessage(mixed $data)
    {
        $conversation = Conversation::select('conversations.*')
            ->join('conversation_users', 'conversations.id', '=', 'conversation_users.conversation_id')
            ->join('messages', 'conversations.id', '=', 'messages.conversation_id')
            ->where('conversation_users.member_id', $data['member_id'])
            ->distinct()
            ->get();
        return $conversation;
    }
    public function getConversation(int $conversationId)
    {
        // dd($data);
        $conversation = Conversation::where('id', '=', $conversationId)
            ->get();
        $member = ConversationUser::with('member')
            ->where('conversation_id', $conversationId)
            ->get();
        $messages = Message::with('sender')
            ->where('conversation_id', $conversationId)
            ->get();
        $conversationDetail = [
            'conversation' => $conversation,
            'user_list' => $member,
            'message_list' => $messages
        ];
        return $conversationDetail;
    }
    public function getConversationPrivate(mixed $data)
    {
        dd($data);
        // $conversation = Conversation::where('id', '=', $conversationId)
        //     ->get();
        // $member = ConversationUser::with('member')
        //     ->where('conversation_id', $conversationId)
        //     ->get();
        // $messages = Message::with('sender')
        //     ->where('conversation_id', $conversationId)
        //     ->get();
        // $conversationDetail = [
        //     'conversation' => $conversation,
        //     'user_list' => $member,
        //     'message_list' => $messages
        // ];
        // return $conversationDetail;
    }
    public function getAllMessageConversation(int $conversationId)
    {
        $conversation = Conversation::with('messages')
            ->where('conversations.id', $conversationId)
            ->get();
        return $conversation;
    }
    public function updateConversation(mixed $data, int $conversationId)
    {
        $conversation = Conversation::find($conversationId);
        $conversation->update($data);
        return $conversation;
    }
    public function addMember(mixed $data, int $conversationId)
    {
        $isConversationUser = ConversationUser::where([
            ['member_id', '=', $data['member_id']],
            ['conversation_id', '=', $conversationId]
        ])->get();
        if ($isConversationUser->count() == 0) {
            $conversationDetail = ConversationUser::create([
                'is_owner' => 0,
                'member_id' => $data['member_id'],
                'conversation_id' => $conversationId
            ]);
            $conversation = Conversation::find($conversationId);
            $conversation->update(['member_count' => $conversation->member_count + 1]);
        } else {
            throw new \Exception('Member is exist in conversation', 400);
        }
        return $conversationDetail;
    }
    public function kickMember(mixed $data, int $conversationId)
    {
        $conversationOwner = ConversationUser::where('conversation_id', '=', $conversationId)
            ->where('member_id', $data['owner_id'])
            ->first();

        if ($conversationOwner->is_owner == 0)
            throw new \Exception('You are not creator this group', 400);

        $conversationUser = ConversationUser::where('conversation_id', '=', $conversationId)
            ->where('member_id', $data['member_id'])
            ->first();
        $conversationUser->delete();
        $conversation = Conversation::find($conversationId);
        $conversation->update(['member_count' => $conversation->member_count - 1]);
        return $conversationUser;
    }
    public function leaveConversation(mixed $data, int $conversationId)
    {
        $conversationUser = ConversationUser::where('conversation_id', '=', $conversationId)
            ->where('member_id', $data['member_id'])
            ->first();
        $conversationUser->delete();
        $conversation = Conversation::find($conversationId);
        $conversation->update(['member_count' => $conversation->member_count - 1]);
        return $conversationUser;
    }
    public function deleteConversation(mixed $data, int $conversationId)
    {
        $conversationOwner = ConversationUser::where('conversation_id', '=', $conversationId)
            ->where('member_id', $data['owner_id'])
            ->first();
        if ($conversationOwner->is_owner == 0)
            throw new \Exception('You are not creator this group', 400);
        $conversationUser = Conversation::where('id', '=', $conversationId)
            ->first();
        $conversationUser->delete();
        return $conversationUser;
    }
}
