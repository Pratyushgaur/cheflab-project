<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Models\User;
use App\Models\vendors;
use App\Notifications\OrderCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
     * @param  \App\Events\OrderCreateEvent  $event
     * @return void
     */
    public function handle(OrderCreateEvent $event)
    {
        $customer = User::find($event->user_id);
        $customer->notify(new OrderCreateNotification("Your have placed a Order #" .$event->order_id));

        $vendor = vendors::find($event->vendor_id);
        $vendor->notify(new OrderCreateNotification("You have received new Order #".$event->order_id));
    }
}
