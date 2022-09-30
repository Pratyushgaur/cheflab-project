<?php

namespace App\Listeners;

use App\Events\DineOutBookingEvent;
use App\Events\OrderCreateEvent;
use App\Models\User;
use App\Models\vendors;
use App\Notifications\DineOutBookingNotification;
use App\Notifications\OrderCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DineOutBookingNotificationListener
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
    public function handle(DineOutBookingEvent $event)
    {
        $customer = User::find($event->user_id);
        $customer->notify(new DineOutBookingNotification("Your booking request send to restaurant.Please wait for acceptance.Booking ID #" .$event->booking_id));

        $vendor = vendors::find($event->vendor_id);
        $vendor->notify(new DineOutBookingNotification("You have received Dine-Out Booking #".$event->booking_id));
    }
}
