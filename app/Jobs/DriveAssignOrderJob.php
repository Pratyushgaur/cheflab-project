<?php

namespace App\Jobs;

use App\Models\Deliver_boy;
use App\Models\Order;
use App\Models\Vendors;
use App\Models\RiderAssignOrders;
use App\Models\DeliveryBoyTokens;
use App\Notifications\RequestSendToDeliveryBoyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DriveAssignOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $orderObj)
    {
        $this->order = $orderObj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        updateDriverLatLngFromFcm();
        
        $vendor=Vendors::find($this->order->vendor_id);
        $delivery_boy = orderAssignToDeliveryBoy($vendor->lat, $vendor->long,$this->order);
        //$delivery_boy=get_delivery_boy_near_me($vendor->lat, $vendor->lng,$this->order);
        if(!empty($delivery_boy)){
            $charges = calculateRiderCharge($delivery_boy->distance,$vendor->lat,$vendor->long,$this->order->lat,$this->order->long);
            // this for checking rider already assign or not
            if(!RiderAssignOrders::where('order_id',$this->order->id)->whereIn('action',["0","1","3","4"])->exists()){
                $riderAssign = new RiderAssignOrders(array('rider_id' => $delivery_boy->id, 'order_id' => $this->order->id,'earning'=>$charges['charges'],'distance'=>$charges['resToUserDistance'],'total_ride_distance'=>$charges['totalDistance']));
                $riderAssign->saveOrFail();
                $riderAssignId = $riderAssign->id;
                \App\Models\OrderActionLogs::create(['orderid'=> $this->order->id,'action' => 'Order Assign to Rider','rider_id' =>$delivery_boy->id]);
                
                //$riderAssign = RiderAssignOrders::where(['id' =>$request->user_id,'action' =>'0'])->orWhere(['rider_id' =>$request->user_id,'action' =>'1'])->orderBy('rider_assign_orders.id','desc')->limit(1);

                $token = DeliveryBoyTokens::where('rider_id','=',$delivery_boy->id)->orderBy('id','desc')->get()->pluck('token');
                if(!empty($token)){
                    $riderAssign = $riderAssign->join('orders','rider_assign_orders.order_id','=','orders.id');
                    $riderAssign = $riderAssign->join('vendors','orders.vendor_id','=','vendors.id');
                    $riderAssign = $riderAssign->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.order_status','orders.customer_name','orders.delivery_address',\DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id','rider_assign_orders.id as rider_assign_order_id','otp');
                    $riderAssign = $riderAssign->first();
                    $riderAssign->expected_earninig = $charges['charges'];
                    $riderAssign->trip_distance = $charges['resToUserDistance'];
                    //
                    $title = 'New Delivery Request';
                    $body = "Vendor address:".$vendor->address.' Deliver to :'.$this->order->delivery_address;
                    $res = sendNotification($title,$body,$token,array('type'=>1,'data'=>$riderAssign),'notify_sound');
                    \App\Models\OrderActionLogs::create(['orderid'=> $this->order->id,'action' => 'Notification Send to Rider','rider_id' =>$delivery_boy->id]);
                    
                }
                \App\Jobs\DriverCheckAcceptJob::dispatch($riderAssignId)->delay(now()->addSeconds(120));

            }
            


        }else{
            $noRiderAssignOrders = new \App\Models\NoRiderAssignOrders;
            $noRiderAssignOrders->order_id  = $this->order->id;
            $noRiderAssignOrders->status = '0';
            $noRiderAssignOrders->save();
            \App\Models\OrderActionLogs::create(['orderid'=> $this->order->id,'action' => 'No Rider found entry goes to no rider assign']);

        }



//send request to delivery boy
    }
}
