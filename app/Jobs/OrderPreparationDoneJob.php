<?php

namespace App\Jobs;

use App\Models\Deliver_boy;
use App\Models\Order;
use App\Models\Vendors;
use App\Notifications\RequestSendToDeliveryBoyNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderPreparationDoneJob implements ShouldQueue
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
        $vendor=Vendors::find($this->order->vendor_id);
        $delivery_boy_ids=get_delivery_boy_near_me($vendor->lat, $vendor->lng);
        $delivery_boy=Deliver_boy::whereIn('id',$delivery_boy_ids)->get();
        foreach ($delivery_boy as $k=>$boy)
            $boy->notify(new RequestSendToDeliveryBoyNotification(
                "New Delivery Request",
                "Vendor address:".$vendor->address.' Deliver to :'.$this->order->delivery_address,
                $vendor->name,
                $boy->fcm_token,'',''));

        $vendor->notify(new RequestSendToDeliveryBoyNotification(
            "Resquest send to delivery boy for order #".$this->order->id,
            "!wait till delivery boy accept your request",
            $vendor->name,
            $vendor->fcm_token,'',''));

//send request to delivery boy
    }
}
