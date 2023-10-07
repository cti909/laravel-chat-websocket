<?php

namespace App\Http\Controllers\APIs\v1;

use App\Constants\MessageConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Responses\BaseResponse;
use App\Repositories\Message\MessageRepository;
use App\Services\Message\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use BaseResponse;

    public function __construct()
    {
        new MessageService(new MessageRepository());
    }

    public function createMessage(StoreMessageRequest $request)
    {
        try {
            $data = MessageService::createMessage($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$CREATE_MESSAGE_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$CREATE_MESSAGE_FAILED
            );
        }
    }
    public function seenMessage(Request $request)
    {
        try {
            $data = MessageService::seenMessage($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$SEEN_MESSAGE_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$SEEN_MESSAGE_FAILED
            );
        }
    }
    public function removeMessage(Request $request, int $messageId)
    {
        try {
            $data = MessageService::removeMessage($messageId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$REMOVE_MESSAGE_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$REMOVE_MESSAGE_FAILED
            );
        }
    }
    public function restoreMessage(Request $request, int $messageId)
    {
        try {
            $data = MessageService::restoreMessage($messageId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$RESTORE_MESSAGE_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$RESTORE_MESSAGE_FAILED
            );
        }
    }
    public function deleteMessage(Request $request, int $messageId)
    {
        try {
            $data = MessageService::deleteMessage($messageId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$RESTORE_MESSAGE_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$RESTORE_MESSAGE_FAILED
            );
        }
    }
}
