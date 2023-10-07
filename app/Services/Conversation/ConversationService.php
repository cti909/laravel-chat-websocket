<?php

namespace App\Services\Conversation;

use App\Http\Filters\BaseFilter;
use App\Http\Requests\Conversation\AddMemberRequest;
use App\Http\Requests\Conversation\KickMemberRequest;
use App\Http\Requests\Conversation\StoreConversationRequest;
use App\Http\Requests\Conversation\UpdateConversationRequest;
use App\Http\Responses\BaseHTTPResponse;
use App\Repositories\Conversation\IConversationRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\User;

class ConversationService extends BaseService implements IConversationService
{
    private static $conversationRepository;
    private static $filter;
    /**
     * Construct
     */
    public function __construct(IConversationRepository $conversationRepository)
    {
        self::$conversationRepository = $conversationRepository;
        self::$filter = new BaseFilter;
    }
    public static function createConversation(StoreConversationRequest $request)
    {
        $data = [
            "name" => $request->input('name'),
            "member_count" => $request->input('member_count'),
            "type" => $request->input('type'),
            "user_list" => $request->input('user_list')
        ];
        return self::$conversationRepository->createConversation($data);
    }
    public static function getAllConversation(Request $request)
    {
        $data = [
            "member_id" => $request->input('member_id'),
            "type" => $request->input('type')
        ];
        return self::$conversationRepository->getAllConversation($data);
    }
    public static function getAllConversationHasMessage(Request $request)
    {
        $data = [
            "member_id" => $request->input('member_id')
        ];
        return self::$conversationRepository->getAllConversationHasMessage($data);
    }
    public static function getConversation(Request $request, int $conversationId)
    {
        return self::$conversationRepository->getConversation($conversationId);
    }
    public static function getConversationPrivate(Request $request)
    {
        dd("asd");
        return self::$conversationRepository->getConversationPrivate("as");
    }
    public static function getAllMessageConversation(Request $request, int $conversationId)
    {
        return self::$conversationRepository->getAllMessageConversation($conversationId);
    }
    public static function updateConversation(UpdateConversationRequest $request, int $conversationId)
    {
        $data = [
            'name' => $request->input('name')
        ];
        return self::$conversationRepository->updateConversation($data, $conversationId);
    }
    public static function addMember(AddMemberRequest $request, int $conversationId)
    {
        $data = [
            'member_id' => $request->input('member_id')
        ];
        return self::$conversationRepository->addMember($data, $conversationId);
    }
    public static function kickMember(KickMemberRequest $request, int $conversationId)
    {
        $data = [
            'member_id' => $request->input('member_id'),
            'owner_id' => $request->input('owner_id')
        ];
        return self::$conversationRepository->kickMember($data, $conversationId);
    }
    public static function leaveConversation(Request $request, int $conversationId)
    {
        $data = [
            'member_id' => $request->input('member_id')
        ];
        return self::$conversationRepository->leaveConversation($data, $conversationId);
    }
    public static function deleteConversation(Request $request, int $conversationId)
    {
        $data = [
            'owner_id' => $request->input('owner_id')
        ];
        return self::$conversationRepository->deleteConversation($data, $conversationId);
    }
}
