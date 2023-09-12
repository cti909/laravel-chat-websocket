<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendInvite implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ownerId;
    public $targetId;
    public $status;

    public function __construct($ownerId, $targetId, $status)
    {
        $this->ownerId = $ownerId;
        $this->targetId = $targetId;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('notification.friendInvite.' . $this->ownerId);
    }

    public function broadcastAs()
    {
        return "friendInvite";
    }

    public function broadcastWith()
    {
        return [
            '0' => $this->ownerId,
            '1' => $this->status,
        ];
    }
}
