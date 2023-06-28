<?php

namespace App\Http\Middleware;

use App\Models\BankDetail;
use App\Models\VendorOrderTime;
use App\Models\vendors;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAppVendorDoneSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isOpningTimeDone = VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->count();

        if (!$isOpningTimeDone)
            redirect()->route('app.vendor.login')->withErrors([ 'msg' => 'Complete Your Order Accept Time Schedule for get Order' ]);



        $location_setting = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('lat')->where('lat','!=','')
            ->WhereNotNull('long')->where('long','!=','')
            ->exists();

        if (!$location_setting)
            redirect()->route('app.vendor.login')->withErrors([ 'msg' => 'Plaase complete your Location setup' ]);


        $bannerAndLogo = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('banner_image')->where('banner_image','!=','')
            ->WhereNotNull('image')->where('image','!=','')
            ->exists();
        if (!$bannerAndLogo)
            redirect()->route('app.vendor.login')->withErrors([ 'msg' => 'Plaase complete your Banner setup' ]);



        return $next($request);
    }
}
