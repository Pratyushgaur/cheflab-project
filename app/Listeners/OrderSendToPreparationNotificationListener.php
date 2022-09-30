<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Events\OrderSendToPrepareEvent;
use App\Models\User;
use App\Models\vendors;
use App\Notifications\OrderCreateNotification;
use App\Notifications\OrderSendToPreparationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderSendToPreparationNotificationListener
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
    public function handle(OrderSendToPrepareEvent $event)
    {
        $customer = User::find($event->user_id);
        $customer->notify(new OrderSendToPreparationNotification("Your Order #" .$event->order_id." send for preparation.It will be preparared in $event->preparationTime minutes"));

        $vendor = vendors::find($event->vendor_id);
        $vendor->notify(new OrderSendToPreparationNotification("You have send Order #".$event->order_id." for preparation."));
    }
}
