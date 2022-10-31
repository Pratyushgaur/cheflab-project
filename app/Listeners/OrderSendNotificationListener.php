<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Models\User;
use App\Models\vendors;
use App\Notifications\OrderCreateNotification;

class OrderSendNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderCreateEvent $event
     * @return void
     */
    public function handle(OrderCreateEvent $event)
    {
        $customer = User::find($event->user_id);
        $vendor   = vendors::find($event->vendor_id);

//        $customer->notify(new OrderCreateNotification($event->order_id, $vendor->name,
//                'The order has been placed ',
//                "Your have placed a Order #" . $event->order_id,
//                '',
//                $customer->fcm_token));

        $vendor->notify(new OrderCreateNotification($event->order_id, $customer->name,
            'New Order',
            "You have received new Order #" . $event->order_id . ' from ' . $customer->name,
            route('restaurant.order.view', $event->order_id) ,
            $vendor->fcm_token
        ));
    }
}
