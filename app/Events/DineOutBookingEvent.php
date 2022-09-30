<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DineOutBookingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking_id,$user_id,$vendor_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($booking_id,$user_id,$vendor_id)
    {
        $this->booking_id=$booking_id;
        $this->user_id=$user_id;
        $this->vendor_id=$vendor_id;
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
