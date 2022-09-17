<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class isChefRestaurant
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
        if (Auth::guard('chef')->user() && Auth::guard('chef')->user()->vendor_type == 'chef') {
            return $next($request);
       }else{
           Auth::logout();
           Session::flush();
           return redirect()->route('vendor.login')->with('error','You can not access This Route');
       }
    }
}
