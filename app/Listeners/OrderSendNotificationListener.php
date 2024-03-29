<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Events\OrderSendToPrepareEvent;
use App\Models\User;
use App\Models\Vendors;
use App\Notifications\OrderCreateNotification;

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
     * @param \App\Events\OrderCreateEvent $event
     * @return void
     */
    public function handle(OrderCreateEvent $event)
    {
        //order_status ===>'pending' to 'confirmed'
        \App\Models\OrderActionLogs::create(['orderid'=> $event->order_obj->id,'action' => 'Order Confirmed After 30 Sec']);

        $event->order_obj->order_status = 'confirmed';
        $event->order_obj->deliver_otp = rand(1000,9999);  
        $event->order_obj->save();

        //send notification
        $customer = User::find($event->user_id);
        $vendor   = Vendors::find($event->vendor_id);
        $vendor->notify(new OrderCreateNotification($event->order_id, $customer->name,
            'New Order',
            "You have received new Order #" . $event->order_id . ' from ' . $customer->name,
            $event->clickUrl,
            $vendor->fcm_token
        ));
        $token []= $vendor->fcm_token;
        $res = sendNotification('New Order',"You have received new Order #" . $event->order_id . ' from ' . $customer->name,$token,['msg_type' => 'info','link' => $event->clickUrl]);
        $tokensApp = \App\Models\VendorAppTokens::where('vendor_id','=',$event->vendor_id)->pluck('token');
        if(!empty($tokensApp)){
                $res = sendVendorAppNotification('New Order',"You have received new Order #" . $event->order_id . ' from ' . $customer->name,$tokensApp,null);
        }

        //automatice send for prepration
        //order_status ===>'confirmed' to 'preparing'
        if ($vendor->is_auto_send_for_prepare) {
            //$products                                = get_order_preparation_time($event->order_obj->id);
            $auto_accept_prepration_time                                = $vendor->auto_accept_prepration_time;
            $event->order_obj->order_status          = 'preparing';
            $event->order_obj->preparation_time_from = mysql_date_time();
            $event->order_obj->preparation_time_to   = mysql_add_time($event->order_obj->preparation_time_from, $auto_accept_prepration_time);
            $event->order_obj->save();
            \App\Models\OrderActionLogs::create(['orderid'=> $event->order_obj->id,'action' => 'Order Auto Accept By Vendor']);
            
            event(new OrderSendToPrepareEvent($event->order_obj, $auto_accept_prepration_time));
            $event->order_obj->save();
        }
    }
}
