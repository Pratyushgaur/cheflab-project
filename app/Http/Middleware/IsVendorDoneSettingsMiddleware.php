<?php

namespace App\Http\Middleware;

use App\Models\VendorOrderTime;
use App\Models\vendors;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsVendorDoneSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd('here');

        $isOpningTimeDone = VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->count();

        if (!$isOpningTimeDone)
            return redirect()->route('restaurant.require.ordertime')->withErrors(['msg' => 'Complete Your Order Accept Time Schedule for get Order']);

        $location_setting = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('lat')
            ->WhereNotNull('long')
            ->exists();

        if (!$location_setting)
            return redirect()->route('restaurant.globleseting.frist_vendor_location')->withErrors(['msg' => 'Drop Your Pickup Location']);

        $bannerAndLogo = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('banner_image')
            ->WhereNotNull('image')
            ->exists();
        if (!$bannerAndLogo)
        return redirect()->route('restaurant.globleseting.first_vendor_logo')->withErrors(['msg' => 'Please Setup Banner Or Logo']);


        return $next($request);
    }
}
