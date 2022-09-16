<?php

namespace App\Listeners;

use App\Events\IsAllSettingDoneEvent;
use App\Models\Order_time;
use App\Models\VendorOrderTime;
use App\Models\vendors;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class IsAllSettingsDoneListener
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
     * @param  \App\Events\IsAllSettingDoneEvent  $event
     * @return void
     */
    public function handle(IsAllSettingDoneEvent $event)
    {
        // dd("here");
        // check vendor order time
        $exist= VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->exists();
        //check other settingd

        // check vendor location
        $exist_location= vendors::where('id', Auth::guard('vendor')->user()->id)
        ->whereNotNull('lat')
        ->whereNotNull('long')
        ->exists();
        //
        $bannerAndLogo = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('banner_image')
            ->WhereNotNull('image')
            ->exists();

        if($exist && $exist_location && $bannerAndLogo)
        {
            vendors::where('id',Auth::guard('vendor')->user()->id)->update(['is_all_setting_done'=>1]);
        }
    }
}
