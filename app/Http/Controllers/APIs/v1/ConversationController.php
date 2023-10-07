<?php

namespace App\Http\Controllers\APIs\v1;

use App\Constants\MessageConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Conversation\AddMemberRequest;
use App\Http\Requests\Conversation\KickMemberRequest;
use App\Http\Requests\Conversation\StoreConversationRequest;
use App\Http\Requests\Conversation\UpdateConversationRequest;
use App\Http\Responses\BaseResponse;
use App\Repositories\Conversation\ConversationRepository;
use App\Services\Conversation\ConversationService;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    use BaseResponse;

    public function __construct()
    {
        new ConversationService(new ConversationRepository());
    }
    public function createConversation(StoreConversationRequest $request)
    {
        try {
            $data = ConversationService::createConversation($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$CREATE_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$CREATE_CONVERSATION_FAILED
            );
        }
    }
    /**
     * Get all conversation
     */
    public function getAllConversation(Request $request)
    {
        try {
            $data = ConversationService::getAllConversation($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_CONVERSATION_FAILED
            );
        }
    }
    /**
     * Get all conversation have message
     */
    public function getAllConversationHasMessage(Request $request)
    {
        try {
            $data = ConversationService::getAllConversationHasMessage($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_CONVERSATION_FAILED
            );
        }
    }

    public function getConversation(Request $request, int $conversationId)
    {
        try {
            $data = ConversationService::getConversation($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_DETAIL_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_DETAIL_CONVERSATION_FAILED
            );
        }
    }
    public function getConversationPrivate(Request $request)
    {
        try {
            dd("asads");
            $data = ConversationService::getConversationPrivate($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_DETAIL_CONVERSATION_PRIVATE_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_DETAIL_CONVERSATION_PRIVATE_FAILED
            );
        }
    }
    public function getAllMessageConversation(Request $request, int $conversationId)
    {
        try {
            $data = ConversationService::getAllMessageConversation($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_ALL_MESSAGES_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_ALL_MESSAGES_CONVERSATION_FAILED
            );
        }
    }
    public function updateConversation(UpdateConversationRequest $request, int $conversationId)
    {
        try {
            $data = ConversationService::updateConversation($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$UPDATE_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$UPDATE_CONVERSATION_FAILED
            );
        }
    }
    public function addMember(AddMemberRequest $request, int $conversationId)
    {
        try {
            $data = ConversationService::addMember($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$ADD_MEMBER_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$ADD_MEMBER_CONVERSATION_FAILED
            );
        }
    }
    public function kickMember(KickMemberRequest $request, int $conversationId)
    {
        try {
            $data = ConversationService::kickMember($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$KICK_MEMBER_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$KICK_MEMBER_CONVERSATION_FAILED
            );
        }
    }
    public function leaveConversation(Request $request, int $conversationId)
    {
        try {
            $data = ConversationService::leaveConversation($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$LEAVE_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$LEAVE_CONVERSATION_FAILED
            );
        }
    }
    public function deleteConversation(Request $request, int $conversationId)
    {
        try {
            $data = ConversationService::deleteConversation($request, $conversationId);
            return $this->success(
                $request,
                $data,
                MessageConstant::$DELETE_CONVERSATION_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$DELETE_CONVERSATION_FAILED
            );
        }
    }
}
