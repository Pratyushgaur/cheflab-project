<?php

namespace App\Listeners;
use App\Events\OrderCancelDriverEmitEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCancelDriverEmitListener
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
     * @param  \App\Events\OrderCancelDriverEmitEvent  $event
     * @return void
     */
    public function handle(OrderCancelDriverEmitEvent $event)
    {
        $id = $event->order->id;
        $token = \App\Models\DeliveryBoyTokens::where('rider_id','=',$event->driver_id)->orderBy('id','desc')->get()->pluck('token');
        if(!empty($token)){
            $riderAssign =  \App\Models\RiderAssignOrders::where('rider_assign_orders.order_id','=',$id)->where('rider_id','=',$event->driver_id);
            $riderAssign->update(['action'=>'5']);
            $riderAssign = $riderAssign->join('orders','rider_assign_orders.order_id','=','orders.id');
            $riderAssign = $riderAssign->join('vendors','orders.vendor_id','=','vendors.id');
            $riderAssign = $riderAssign->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.order_status','orders.customer_name','orders.delivery_address',\DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id','rider_assign_orders.id as rider_assign_order_id');
            $riderAssign = $riderAssign->first();
            if(!empty($riderAssign)){
                $riderAssign->expected_earninig = 50;
                $riderAssign->trip_distance = 7;
                $title = 'Order Cancelled';
                $body = "Order Cancelled";
                $res = sendNotification($title,$body,$token,array('type'=>3,'data'=>$riderAssign),'notify_sound');
            }
            return true;
            
            
        }
    }
}
