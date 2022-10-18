<?php

namespace App\Listeners;

use App\Events\CreateSlotBookingEvent;
use App\Models\Superadmin;
use App\Notifications\CreateSlotBookingToAdminNotification;

class CreateSlotBookingNotificationListener
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
    public function handle(CreateSlotBookingEvent $event)
    {
        $link=route('admin.slotebook.list');

        $msg=\Auth::guard('vendor')->user()->name . " requested banner promotion";
        $subscribers = Superadmin::get();
        foreach ($subscribers as $k => $admin)
            $admin->notify(new CreateSlotBookingToAdminNotification($msg,\Auth::guard('vendor')->user()->name,$link)); //With new post


    }
}
