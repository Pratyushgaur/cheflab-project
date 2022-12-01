<?php

namespace App\Console\Commands;

use App\Models\vendors;
use App\Notifications\VendorGoesOnlineNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use VendorOffline;

class RestaurantSetOnline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'restaurant_set_online:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this cron is set online; that restaurant goes offline by selecting the option to automatically goes online';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vendor_ids = \App\Models\VendorOffline::where('resume_date', date('Y-m-d 00:00:00'))
        ->where('is_action_taken', 0)->pluck('vendor_id', 'vendor_id')->toArray();

        Vendors::whereIn('id', $vendor_ids)->update(['is_online' => 1]);
        //start loges
        $vendor_ids= \App\Models\VendorOffline::where('resume_date',date('Y-m-d 00:00:00'))->pluck('vendor_id');
        Log::channel('vendor_change_status')->info('\n\n--------------------'.mysql_date_time().'Vendors goes online--------------------\n');
        Log::channel('vendor_change_status')->info($vendor_ids);
        Log::channel('vendor_change_status')->info('\n--------------------'.mysql_date_time().'END--------------------\n');
        //log end


        \App\Models\VendorOffline::where('resume_date', date('Y-m-d 00:00:00'))
            ->where('is_action_taken', 0)
            ->update(['is_action_taken' => 1]);
            Log::info("Successfully, cron is running");

            foreach ($vendor_ids as $k=>$vendor_id){
                $vendor=Vendors::find($vendor_id);

                $vendor->notify(new VendorGoesOnlineNotification("System automatic generated MSG",
                    'You restaurant Goes Online',
                    "System automatic generated message. onwards you will be able to get orders.",
                    "" ,
                    $vendor->fcm_token
                ));
            }

        return 0;
    }
}
