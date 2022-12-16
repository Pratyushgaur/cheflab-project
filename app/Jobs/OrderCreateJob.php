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

    public $order_obj;
//    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order_obj)
    {
        $this->$order_obj = $order_obj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        event(new \App\Events\OrderCreateEvent($this->order_obj, $this->order_obj->id, $this->order_obj->user_id, $this->order_obj->vendor_id));

    }
}
