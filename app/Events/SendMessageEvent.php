<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $body;
    public $user_id;
    public $name_send;
    public $user_receive;

    /**
     * Create a new event instance.
     */
    public function __construct($body, $user_id, $name_send, $user_receive)
    {
        $this->body = $body;
        $this->user_id = $user_id;
        $this->name_send = $name_send;
        $this->user_receive = $user_receive;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('send-message'),
        ];
    }

    public function broadcastAs()
    {
        return 'message-event';
    }

}