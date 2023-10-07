<?php

namespace App\Services\Conversation;

use App\Http\Requests\Conversation\AddMemberRequest;
use App\Http\Requests\Conversation\KickMemberRequest;
use App\Http\Requests\Conversation\StoreConversationRequest;
use App\Http\Requests\Conversation\UpdateConversationRequest;
use Illuminate\Http\Request;

interface IConversationService
{
    public static function createConversation(StoreConversationRequest $request);
    public static function getAllConversation(Request $request);
    public static function getAllConversationHasMessage(Request $request);
    public static function getConversation(Request $request, int $conversationId);
    public static function getConversationPrivate(Request $request);
    public static function getAllMessageConversation(Request $request, int $conversationId);
    public static function updateConversation(UpdateConversationRequest $request, int $conversationId);
    public static function addMember(AddMemberRequest $request, int $conversationId);
    public static function kickMember(KickMemberRequest $request, int $conversationId);
    public static function leaveConversation(Request $request, int $conversationId);
    public static function deleteConversation(Request $request, int $conversationId);
}
