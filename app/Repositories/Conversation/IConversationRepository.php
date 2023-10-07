<?php

namespace App\Repositories\Conversation;

use App\Repositories\IBaseRepository;

interface IConversationRepository extends IBaseRepository
{
    public function createConversation(mixed $data);
    public function getAllConversation(mixed $data);
    public function getAllConversationHasMessage(mixed $data);
    public function getConversation(int $data);
    public function getConversationPrivate(mixed $data);
    public function getAllMessageConversation(int $data);
    public function updateConversation(mixed $data, int $conversationId);
    public function addMember(mixed $data, int $conversationId);
    public function kickMember(mixed $data, int $conversationId);
    public function leaveConversation(mixed $data, int $conversationId);
    public function deleteConversation(mixed $data, int $conversationId);
}
