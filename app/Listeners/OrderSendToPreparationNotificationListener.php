<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Events\OrderSendToPrepareEvent;
use App\Jobs\OrderPreparationDoneJob;
use App\Jobs\DriveAssignOrderJob;
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
        $customer = User::find($event->order->user_id);
        $vendor = Vendors::find($event->order->vendor_id);

        $customer->notify(new OrderSendToPreparationNotification($event->order->id,$vendor->name,'Send for preparation',"Your Order #" .$event->order->id." send for preparation.It will be preparared in $event->preparationTime minutes",$customer->fcm_token));
//we dont need to send firbase notification to vendor so we dont pass fcm_token
        $vendor->notify(new OrderSendToPreparationNotification($event->order->id,$customer->name,'Send for preparation',"You have send Order #".$event->order->id." for preparation.",''));
//dd( $event->preparationTime);
        DriveAssignOrderJob::dispatch();
        //OrderPreparationDoneJob::dispatch($event->order)->delay(now()->addMinutes((int) $event->preparationTime));
    }
}
