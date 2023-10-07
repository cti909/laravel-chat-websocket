<?php

use App\Models\ConversationUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/



// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat', function ($user) {
    return $user;
});

Broadcast::channel('chat.private.{conversationId}', function ($user, $conversationId) {
    $conversationUser = ConversationUser::where('member_id', '=', $user->id)
        ->where('conversation_id', '=', $conversationId)
        ->first();

    return $conversationUser ? true : false;
});

Broadcast::channel('chat.public.{conversationId}', function ($user, $conversationId) {
    // return (int) $user->id === (int) $conversationId;
    return true;
});

// Broadcast::channel('chat.conversation.{conversationId}', function ($user, $conversationId) {
//     return (int) $user->id === (int) $conversationId;
// });

Broadcast::channel('notification.friendInvite.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
