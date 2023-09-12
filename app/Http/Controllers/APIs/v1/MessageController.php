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
    // // Lay danh sach tin nhan cua 1 chanel
    // public function getMessages(Request $request, $channel_id)
    // {

    //     return Message::where("channel_id", $channel_id)->with('user.details')->get();
    // }

    public function store(StoreMessageRequest $request)
    {
        try {
            $data = MessageService::storeMessage($request);
            return $this->success(
                $request,
                $data,
                MessageConstant::$GET_LIST_USERS_SUCCESS,
            );
        } catch (\Throwable $th) {
            return $this->error(
                $request,
                $th,
                MessageConstant::$GET_LIST_USERS_SUCCESS
            );
        }


        // $userId = $request->input("userId");
        // $message = $request->input("message");
        // broadcast(new PrivateWebSocket($userId, $message));

        // $message = auth()->user()->messages()->create([
        //     'message' => $request->message,
        //     'channel_id' => $request->channel_id
        // ]);
        // $user = User::where('id', auth()->user()->id)->with('details')->first();

        // broadcast(new MessageSent($user, $message, $request->channel_id, $request->channel_type));
    }
    // public function directMessage(Request $request)
    // {
    //     $sender = auth()->user()->id;
    //     $receiver = $request->receiver;


    //     $channelIsFound = Channel::where('type', 'dm')->whereHas('users', function ($q) use ($sender) {
    //         $q->where('user_id', $sender);
    //     })->whereHas('users', function ($q) use ($receiver) {
    //         $q->where('user_id', $receiver);
    //     })->first();
    //     error_log("CHANNEL FOUND");
    //     error_log($channelIsFound);
    //     if (!empty($channelIsFound)) {
    //         $channel = $channelIsFound;
    //         return response()->json($channel);
    //     } else {
    //         $channel = new Channel;
    //         $channel->name = "dm";
    //         $channel->type = "dm";
    //         $channel->save();
    //         $channel->users()->attach($sender);
    //         $channel->users()->attach($receiver);
    //         return response()->json($channel);
    //     }
    // }
}
