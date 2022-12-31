<?php

namespace App\Listeners;
use App\Events\OrderReadyToDispatchEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderReadyToDispatchListener
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
     * @param  \App\Events\OrderReadyToDispatchEvent  $event
     * @return void
     */
    public function handle(OrderReadyToDispatchEvent $event)
    {
        $id = $event->order_id;
        \App\Models\RiderAssignOrders::where('order_id','=',$id)->where('rider_id','=',$event->driver_id)->update(['otp'=>rand(1000,9999)]);
            $token = \App\Models\DeliveryBoyTokens::where('rider_id','=',$event->driver_id)->orderBy('id','desc')->get()->pluck('token');
            if(!empty($token)){
                $riderAssign =  \App\Models\RiderAssignOrders::where('rider_assign_orders.order_id','=',$id)->where('rider_id','=',$event->driver_id);
                $riderAssign = $riderAssign->join('orders','rider_assign_orders.order_id','=','orders.id');
                $riderAssign = $riderAssign->join('vendors','orders.vendor_id','=','vendors.id');
                $riderAssign = $riderAssign->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.order_status','orders.customer_name','orders.delivery_address',\DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id','rider_assign_orders.id as rider_assign_order_id');
                $riderAssign = $riderAssign->first();
                if(!empty($riderAssign)){
                    $riderAssign->expected_earninig = 50;
                    $riderAssign->trip_distance = 7;
                    $title = 'Restaurant Order Ready to Dispatch';
                    $body = "Restaurant Order Ready to Dispatch";
                    $res = sendNotification($title,$body,$token,array('type'=>2,'data'=>$riderAssign),'notify_sound');
                }
                
                
            }
    }
}
