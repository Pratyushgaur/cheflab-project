<?php

namespace App\Events;

use App\Models\TableServiceBooking;
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

    public $TableServiceBooking,$user_id,$vendor_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TableServiceBooking $TableServiceBooking,$user_id,$vendor_id)
    {
        $this->TableServiceBooking=$TableServiceBooking;
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
