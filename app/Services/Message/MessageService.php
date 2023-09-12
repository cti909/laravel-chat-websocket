<?php

namespace App\Services\Message;

use App\Http\Filters\BaseFilter;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Responses\BaseHTTPResponse;
use App\Repositories\Message\IMessageRepository;
use App\Repositories\User\IUserRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\User;

class MessageService extends BaseService implements IMessageService
{
    private static $messageRepository;
    private static $filter;
    /**
     * Construct
     */
    public function __construct(IMessageRepository $messageRepository)
    {
        self::$messageRepository = $messageRepository;
        self::$filter = new BaseFilter;
    }
    /**
     * Create message and create all user seen status 
     */
    public static function storeMessage(StoreMessageRequest $request)
    {
        if ($request->input("content") && $request->input("path")) {
            throw new \Exception("Both 'content' and 'path' cannot be empty.");
        }
        $requestData = [
            "content" => $request->input("content") ? $request->input("content") : null,
            "path" => $request->input("path") ? $request->input("path") : null,
            "is_deleted" => false,
            "sender_id" => $request->input("sender_id"),
            "conversation_id" => $request->input("conversation_id"),
        ];
        return self::$messageRepository->createMessageAndStatus($requestData);
    }
    /**
     * Create message and create all user seen status 
     */
    public static function userSeen(Request $request)
    {
        $requestData = [
            "user_id" => $request->input("content") ? $request->input("content") : null,
            "time" => $request->input("path") ? $request->input("path") : null, // ? message_id
            "is_seen" => true,
        ];
    }
    /**
     * Delete message
     */
    public static function deleteMessage(Request $request)
    {
        $requestData = [
            "send_id" => $request->input("content") ? $request->input("content") : null,
            "conversation_id" => $request->input("path") ? $request->input("path") : null, // ? message_id
            "is_deleted" => true,
        ];
    }
}
