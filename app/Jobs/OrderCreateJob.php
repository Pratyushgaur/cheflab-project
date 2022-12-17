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
    //public $user_id;
    //public $vendor_id;

//    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        // $this->order_id = $user->id;
        // $this->user_id = $user->user_id;
        // $this->vendor_id = $user->vendor_id;
        // $this->$user = $user;
        $this->order_id = $order->id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    
        $orderdata = Order::where('id','=',$this->order_id)->first(); 
        event(new \App\Events\OrderCreateEvent($orderdata, $orderdata->id, $orderdata->user_id, $orderdata->vendor_id));

    }
}
