<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function getSubscribedChannels(Request $request)
    {
        $user = auth()->user()->id;
        $channels = Channel::whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user);
        })->join('details', 'channels.id', '=', 'details.channel_id')
            ->join('users', 'users.id', '=', 'details.owner_id')
            ->join('user_details', 'user_id', '=', 'details.owner_id')
            ->select('channels.id', 'channels.type', 'details.name', 'users.name as owner', 'details.desc', 'details.type', 'details.visible', 'details.owner_id as owner_id', 'user_details.avatar as owner_avatar')->get();

        return response()->json($channels);
    }
    public function getAllChannels(Request $request)
    {
        $user = auth()->user()->id;
        $channels = Channel::where('channels.type', 'channel')->join('details', 'channels.id', '=', 'details.channel_id')->join('users', 'users.id', '=', 'details.owner_id')
            ->select('channels.id', 'channels.type', 'details.name', 'users.name as owner', 'details.desc', 'details.type', 'details.visible', 'details.owner_id')->distinct()->get();

        return response()->json($channels);
    }
    public function createChannel(Request $request)
    {

        $user = auth()->user()->id;

        $channel = new Channel;
        $channel->type = "channel";
        $channel->name = "channel";
        $channel->save();
        $channelId = $channel->id;
        $channel->users()->attach($user);

        $detail = new Details;
        $detail->name = $request->channelName;
        $detail->desc = $request->description;
        $detail->visible = $request->visible;
        $detail->type = $request->type;
        $detail->owner_id = $user;
        $detail->channel_id = $channelId;
        $detail->image = "nothing";
        $detail->save();

        $createdChannel = Channel::where('channels.id', $channelId)
            ->join('details', 'channels.id', '=', 'details.channel_id')
            ->select('channels.id', 'details.name', 'details.owner_id as owner_id')->first();

        return response()->json($createdChannel);
    }
}
