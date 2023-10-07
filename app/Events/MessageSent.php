<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\User;
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

    protected $id;
    protected $content;
    protected $path;
    protected $sender_id;
    protected $conversation_id;
    protected $created_at;
    protected $updated_at;
    /**
     * Create a new event instance.
     */
    public function __construct(mixed $data)
    {
        $this->id = $data->id;
        $this->content = $data->content;
        $this->path = $data->path;
        $this->sender_id = $data->sender_id;
        $this->conversation_id = $data->conversation_id;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
    }

    public function broadcastOn(): Channel
    {
        $conversation = Conversation::where('id', $this->conversation_id)->first();
        if ($conversation->type == "private") {
            return new PrivateChannel("chat.private." . $this->conversation_id);
        } else if ($conversation->type == "public") {
            return new PresenceChannel("chat.public." . $this->conversation_id);
        }
    }
    public function broadcastAs()
    {
        return "messageSent";
    }

    public function broadcastWith(): array
    {
        $sender = User::where('id', $this->sender_id)->first();
        return [
            'id' => $this->id,
            'content' => $this->content,
            'path' => $this->path,
            'sender_id' => $this->sender_id,
            'conversation_id' => $this->conversation_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sender' => [
                'id' => $sender->id,
                'name' => $sender->name,
                'email' => $sender->email,
                'avatar' => $sender->avatar
            ]
        ];
    }
}
