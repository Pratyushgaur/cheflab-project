<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class isVendorLoginAuth
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
        
        if (Auth::guard('vendor')->check()) {
            if (Auth::guard('vendor')->user()->vendor_type == 'restaurant') {
                return redirect()->route('restaurant.dashboard'); 
            } elseif(Auth::guard('vendor')->user()->vendor_type == 'chef') {
               return redirect()->route('chef.dashboard');
            }
            
            //return redirect()->route('vendor.dashboard');

       }else{
           
             return $next($request);
       }
    }
}
