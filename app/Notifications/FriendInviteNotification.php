<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendInviteNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $user;
    protected $message;

    public function __construct(User $user, string $message = "")
    {
        $this->user = $user;
        $this->message = $user->name . " is invited friend!";
    }

    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'userId' => $this->user->id,
            'message' => $this->message,
        ]);
    }
}
