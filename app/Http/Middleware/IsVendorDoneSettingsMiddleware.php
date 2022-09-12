<?php

namespace App\Http\Middleware;

use App\Models\VendorOrderTime;
use Closure;
use Illuminate\Http\Request;

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
        
        $isOpningTimeDone = VendorOrderTime::where('vendor_id', session('*$%&%*id**$%#'))->count();
        
        // dd($isOpningTimeDone);
        if ($isOpningTimeDone)
            return $next($request);
        else
            //return redirect()->route('restaurant.globleseting.ordertime')->withErrors(['msg' => 'Complete Your Setup for get Order']);
           
            return redirect()->route('restaurant.require.ordertime')->withErrors(['msg' => 'Complete Your Setup for get Order']);
    }
}
