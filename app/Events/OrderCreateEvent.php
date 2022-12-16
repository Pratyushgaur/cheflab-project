<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class OrderCreateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;


    public $order_obj, $order_id, $user_id, $vendor_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order_obj, $order_id, $user_id, $vendor_id)
    {
        $this->order_obj = $order_obj;
        $this->order_id  = $order_id;
        $this->user_id   = $user_id;
        $this->vendor_id = $vendor_id;
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
