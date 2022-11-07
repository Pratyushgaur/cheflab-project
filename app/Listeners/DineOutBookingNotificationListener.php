<?php

namespace App\Listeners;

use App\Events\DineOutBookingEvent;
use App\Models\User;
use App\Models\vendors;
use App\Notifications\DineOutBookingNotification;

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
     * @param \App\Events\OrderCreateEvent $event
     * @return void
     */
    public function handle(DineOutBookingEvent $event)
    {
        $customer = User::find($event->user_id);
        $vendor   = Vendors::find($event->vendor_id);

        $customer->notify(new DineOutBookingNotification('Dine-out Booking', "Your booking request send to restaurant.Please wait for acceptance.Booking ID #" . $event->TableServiceBooking->id,
            $vendor->name, '', $customer->fcm_token));

        $vendor->notify(new DineOutBookingNotification('Dine-out Booking received',
            "You have received Dine-Out Booking #" . $event->TableServiceBooking->id
            . ' <br>no of guest : ' . $event->TableServiceBooking->booked_no_guest
            . '<br>from  : ' . front_end_time($event->TableServiceBooking->booked_slot_time_from)
            . '<br>to   : ' . front_end_time($event->TableServiceBooking->booked_slot_time_to),
            $customer->name, route('restaurant.dineout.index'), $vendor->fcm_token));
    }
}
