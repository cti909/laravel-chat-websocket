<?php

namespace App\Http\Controllers\APIs\v1;

use App\Events\MessageSent;
use App\Events\PrivateWebSocket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function test(Request $request)
    {
        $data = $request->input();
        dd($data);
        // event(new MessageSent($data->user, $data->message, $conversation, $type));
        // $user = auth()->user();
        // broadcast(new UserOffline($user))->toOthers();
    }
    public function demochat(Request $request)
    {
        $userId = $request->input("userId");
        $message = $request->input("message");
        broadcast(new PrivateWebSocket($userId, $message));
        // event(new PrivateWebSocket($userId, $message));
    }
}
