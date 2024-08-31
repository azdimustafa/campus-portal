<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginLog
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $type;
    public $status;
    public $ipAddress;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $type, $status, $ipAddress, $message = null)
    {
        $this->email = $email;
        $this->type = $type;
        $this->status = $status;
        $this->ipAddress = $ipAddress;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
