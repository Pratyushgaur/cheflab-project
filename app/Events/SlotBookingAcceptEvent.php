<?php

namespace App\Events;

use App\Models\SloteBook;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SlotBookingAcceptEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $SloteBook;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($SloteBook)
    {
        $this->SloteBook=$SloteBook;
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
