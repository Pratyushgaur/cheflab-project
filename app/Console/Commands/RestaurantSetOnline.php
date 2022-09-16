<?php

namespace App\Console\Commands;

use App\Models\vendors;
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
        $vendor_ids = VendorOffline::where('resume_date', date('Y-m-d H:i:s'))
        ->where('is_action_taken', 0)->pluck('vendor_id', 'vendor_id')->toArray();
        vendors::whereIn('id', $vendor_ids)->update(['is_online' => 1]);
        VendorOffline::where('resume_date', date('Y-m-d H:i:s'))
            ->where('is_action_taken', 0)
            ->update(['is_action_taken' => 1]);
            Log::info("Successfully, cron is running");

        return 0;
    }
}
