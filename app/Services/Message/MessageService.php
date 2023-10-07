<?php

namespace App\Services\Message;

use App\Events\MessageSent;
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
    public static function createMessage(StoreMessageRequest $request)
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
        $data = self::$messageRepository->createMessageAndStatus($requestData);
        broadcast(new MessageSent($data));
        return $data;
    }
    public static function seenMessage(Request $request)
    {
        $requestData = [
            "user_id" => $request->input("user_id"),
            "conversation_id" => $request->input("conversation_id"),
        ];
        return self::$messageRepository->seenMessage($requestData);
    }
    public static function removeMessage(int $messageId)
    {
        $requestData = [
            'is_deleted' => true
        ];
        return self::$messageRepository->update($requestData, $messageId);
    }
    public static function restoreMessage(int $messageId)
    {
        $requestData = [
            'is_deleted' => false
        ];
        return self::$messageRepository->update($requestData, $messageId);
    }
    public static function deleteMessage(int $messageId)
    {
        return self::$messageRepository->destroy($messageId);
    }
}
