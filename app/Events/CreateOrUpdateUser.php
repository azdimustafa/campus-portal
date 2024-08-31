<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateOrUpdateUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email;
    public $name;
    public $from;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email, $name, $from)
    {
        $this->email = $email;
        $this->name = $name;
        $this->from = $from;
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
