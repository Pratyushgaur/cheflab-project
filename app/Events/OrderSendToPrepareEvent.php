<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderSendToPrepareEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

//    public $order_id,$user_id,$vendor_id,$preparationTime;
    public $order,$preparationTime;
    /**
     * Create a new event instance.
     *
     * @return void
     */
//    public function __construct($order_id,$user_id,$vendor_id,$preparationTime)
    public function __construct(Order $order,$preparationTime)
    {
//        $this->order_id=$order_id;
//        $this->user_id=$user_id;
//        $this->vendor_id=$vendor_id;
        $this->order=$order;
        $this->preparationTime=$preparationTime;
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
