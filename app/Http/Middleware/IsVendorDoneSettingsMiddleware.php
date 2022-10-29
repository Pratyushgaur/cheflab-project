<?php

namespace App\Http\Middleware;

use App\Models\BankDetail;
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
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isOpningTimeDone = VendorOrderTime::where('vendor_id', Auth::guard('vendor')->user()->id)->count();

        if (!$isOpningTimeDone)
            if (Auth::guard('vendor')->user()->vendor_type == 'chef') {
                return redirect()->route('chef.require.ordertime')->withErrors([ 'msg' => 'Complete Your Order Accept Time Schedule for get Order' ]);
            } elseif (Auth::guard('vendor')->user()->vendor_type == 'restaurant') {
                return redirect()->route('restaurant.require.ordertime')->withErrors([ 'msg' => 'Complete Your Order Accept Time Schedule for get Order' ]);
            }


        $location_setting = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('lat')->where('lat','!=','')
            ->WhereNotNull('long')->where('long','!=','')
            ->exists();

        if (!$location_setting)
            return redirect()->route('restaurant.globleseting.frist_vendor_location')->withErrors([ 'msg' => 'Drop Your Pickup Location' ]);

        $bannerAndLogo = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('banner_image')->where('banner_image','!=','')
            ->WhereNotNull('image')->where('image','!=','')
            ->exists();
        if (!$bannerAndLogo)
            return redirect()->route('restaurant.globleseting.first_vendor_logo')->withErrors([ 'msg' => 'Please Setup Banner Or Logo' ]);



        $alldoc = vendors::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('aadhar_number')->where('aadhar_number','!=','')
            ->WhereNotNull('aadhar_card_image')->where('aadhar_card_image','!=','')
            ->WhereNotNull('pancard_number')->where('pancard_number','!=','')
            ->WhereNotNull('pancard_image')->where('pancard_image','!=','')
            ->exists();
        $bankdetails = BankDetail::where('id', Auth::guard('vendor')->user()->id)
            ->whereNotNull('holder_name')->where('holder_name','!=','')
            ->WhereNotNull('account_no')->where('account_no','!=','')
            ->WhereNotNull('ifsc')->where('ifsc','!=','')
            ->WhereNotNull('bank_name')->where('bank_name','!=','')
            ->WhereNotNull('cancel_check')->where('cancel_check','!=','')
            ->exists();
        if (!$alldoc || !$bankdetails)
            return redirect()->route('restaurant.globleseting.first_bank_details')->withErrors([ 'msg' => 'Please provide bank details and required documents' ]);


        return $next($request);
    }
}
