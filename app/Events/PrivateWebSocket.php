<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateWebSocket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel // kenh ket noi - 2
    {
        return new PrivateChannel('chat.channel.' . $this->user);
    }

    public function broadcastAs() // ten event - 1
    {
        return "privateMessage";
    }

    public function broadcastWith(): array // dl tra ve - 3
    {
        return [
            'mess' => $this->message,
        ];
    }
}
