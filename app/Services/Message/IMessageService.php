<?php

namespace App\Services\Message;

use App\Http\Requests\Message\StoreMessageRequest;
use Illuminate\Http\Request;

interface IMessageService
{
    public static function createMessage(StoreMessageRequest $request);
    public static function seenMessage(Request $request);
    public static function removeMessage(int $messageId);
    public static function deleteMessage(int $messageId);
}
