<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Session;
class isVendor
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
        dd(Auth::guard('vendor')->user()->toArray());
        if (session()->has('*$%&%*id**$%#')  && Auth::guard('vendor')->user()) {
             return $next($request);
        }else{
           
            Auth::guard('vendor')->logout();
            //Session::flush();
             return redirect()->route('vendor.login');
        }
    }
}
