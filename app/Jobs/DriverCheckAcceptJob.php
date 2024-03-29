<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\RiderAssignOrders;
use App\Models\DeliveryBoyTokens;
use App\Models\Order;


class DriverCheckAcceptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $riderAssignId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($riderAssignId)
    {
        $this->riderAssignId = $riderAssignId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $assigndata = RiderAssignOrders::where('id','=',$this->riderAssignId);
        
        if($assigndata->exists()){
            $assigndata = $assigndata->first();
            if($assigndata->action == '0'){
                RiderAssignOrders::where('id','=',$this->riderAssignId)->update(['action'=>'2','cancel_reason'=>'Time Out Rejection','is_rejected' => '2']);
                \App\Models\OrderActionLogs::create(['orderid'=> $assigndata->order_id,'action' => 'Order Auto Reject to rider','rider_id' =>$assigndata->rider_id]);
                $orderData = Order::where('id', '=', $assigndata->order_id)->first();
                if(!empty($orderData)){
                    \App\Jobs\DriveAssignOrderJob::dispatch($orderData);
                }
                $token = DeliveryBoyTokens::where('rider_id','=',$assigndata->rider_id)->orderBy('id','desc')->get()->pluck('token');
                if(!empty($token)){
                    $assigndata->message = 'Time Up ! Order is Rejected';
                    $title = 'Time Up ! Order is Rejected. ';
                    $body = "Due to Deley accept Your Order #$orderData->order_id is rejected  By You Automatically";
                    $res = sendNotification($title,$body,$token,array('type'=>4,'data'=>$assigndata),'notify_sound');
                }
            }else{
                var_dump('order accepted');
            }
        }else{
            var_dump('No Rider assign data  Found ');
        }
    }
}
