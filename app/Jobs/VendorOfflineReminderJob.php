<?php

namespace App\Jobs;

use App\Models\Vendors;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VendorOfflineReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $vendor_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($vendor_id)
    {
        $this->vendor_id = $vendor_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vendor = Vendors::find($this->vendor_id);
        if ($vendor->is_online == 0) {
            //send sms to vendors


        }
        echo "DONE";

    }
}
