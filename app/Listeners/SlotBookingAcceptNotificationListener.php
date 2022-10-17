<?php

namespace App\Listeners;

use App\Events\SlotBookingAcceptEvent;
use App\Models\Vendors;
use App\Notifications\SlotBookingAcceptNotification;

class SlotBookingAcceptNotificationListener
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
    public function handle(SlotBookingAcceptEvent $event)
    {
        $link = route('transection.request');
        $msg  = "Your slot request accepted for banner promotion."
            . "<table>
                <tr><td>price </td><td>" . front_end_currency($event->SloteBook->price) . "</td></tr>
                <tr><td>From </td><td>" . front_end_date($event->SloteBook->from_date) . "</td></tr>
                <tr><td>To </td><td>" . front_end_date($event->SloteBook->to_date) . "</td></tr>
                <tr><td>Time Slot </td><td>" . front_end_time($event->SloteBook->from_time) . "-" . front_end_time($event->SloteBook->to_time) . "</td></tr>
            </table>"
            . "<a href='$link'>Please make payment</a>";

        $vender = Vendors::find($event->SloteBook->vendor_id);
        $vender->notify(new SlotBookingAcceptNotification($msg, \Auth::guard('admin')->user()->name, $link)); //With new post

    }
}
