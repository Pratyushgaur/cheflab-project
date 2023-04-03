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
        if(!empty($customer)){
            if($customer->fcm_token!=''){
                $data = orderDetailForUser($event->order->id);
                sendUserAppNotification('Order Accepted',"Your food is under preparation now",$customer->fcm_token,array('type'=>1,'data'=>$data));
            }
        }
        $vendor->notify(new OrderSendToPreparationNotification($event->order->id,$customer->name,'Send for preparation',"You have send Order #".$event->order->id." for preparation.",''));
        DriveAssignOrderJob::dispatch($event->order);
        //OrderPreparationDoneJob::dispatch($event->order)->delay(now()->addMinutes((int) $event->preparationTime));
    }
}
