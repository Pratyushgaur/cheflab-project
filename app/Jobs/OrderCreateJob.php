<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreateJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, InteractsWithQueue;

    //public $user;
    public $order_id;
    public $url;
    //public $user_id;
    //public $vendor_id;

//    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order,$url)
    {
        // $this->order_id = $user->id;
        // $this->user_id = $user->user_id;
        // $this->vendor_id = $user->vendor_id;
        // $this->$user = $user;
        $this->order_id = $order->id;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Order $order_obj)
    {
        $orderdata = Order::where('id','=',$this->order_id)->first();
        if($orderdata->order_status != 'cancelled_by_customer_before_confirmed'){
            event(new \App\Events\OrderCreateEvent($orderdata, $orderdata->id, $orderdata->user_id, $orderdata->vendor_id,$this->url));
        }
        

    }
}
