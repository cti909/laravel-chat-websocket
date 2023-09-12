<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $userId;
    protected $message;
    protected $conversationId;
    protected $type;
    /**
     * Create a new event instance.
     */
    public function __construct(int $userId, string $message, int $conversationId, string $type)
    {
        $this->userId = $userId;
        $this->message = $message;
        $this->conversationId = $conversationId;
        $this->type = $type;
    }

    public function broadcastOn(): Channel
    {
        if ($this->type === "private") {
            return new PrivateChannel("chat.private." . $this->conversationId);
        } else if ($this->type === "public") {
            return new PresenceChannel("chat.public." . $this->conversationId);
        }
    }
    public function broadcastAs()
    {
        return "messageSent";
    }

    public function broadcastWith(): array
    {
        return [
            'userId' => $this->userId,
            'mess' => $this->message,
        ];
    }
}
