<?php

namespace App\Listeners;

use App\Events\SlotBookingAcceptEvent;
use App\Events\SlotBookingRejectEvent;
use App\Models\Vendors;
use App\Notifications\SlotBookingAcceptNotification;
use App\Notifications\SlotBookingRejectNotification;

class SlotBookingRejectNotificationListener
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
    public function handle(SlotBookingRejectEvent $event)
    {
        $link = route('restaurant.promotion.list');
        $msg  = "Your slot request rejected for banner promotion."
            . "<table>
                <tr><td>Rejection Reason </td><td>".($event->SloteBook->comment_reason) . "</td></tr>
                <tr><td>price </td><td>" . front_end_currency($event->SloteBook->price) . "</td></tr>
                <tr><td>From </td><td>" . front_end_date($event->SloteBook->from_date) . "</td></tr>
                <tr><td>To </td><td>" . front_end_date($event->SloteBook->to_date) . "</td></tr>
                <tr><td>Time Slot </td><td>" . front_end_time($event->SloteBook->from_time) . "-" . front_end_time($event->SloteBook->to_time) . "</td></tr>
            </table>";

        $vender = Vendors::find($event->SloteBook->vendor_id);
        $vender->notify(new SlotBookingRejectNotification($msg, \Auth::guard('admin')->user()->name, $link)); //With new post

    }
}
