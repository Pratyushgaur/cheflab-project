<?php

namespace App\Listeners;
use App\Events\AdminLoginHistoryEvent;
use App\Models\Superadminloginlogs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdminLoginHistoryListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(AdminLoginHistoryEvent $event)
    {
        Superadminloginlogs::insert(['ipAddress'=>$event->ipAddress]);
    }
}
