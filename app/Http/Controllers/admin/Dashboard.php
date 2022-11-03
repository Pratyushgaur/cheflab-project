<?php

namespace App\Http\Controllers\admin;

use App\Models\MangaoStaticUseradmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendors;
use App\Models\Deliver_boy;
use App\Models\Orders;
use Illuminate\Support\Facades\Gate;
use App\Models\Notification;
use Auth;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo $password = Hash::make('123456');
        
        // $response = Gate::inspect('isSuperAdmin');
        
        // Gate::authorize('isSuperAdmin');
 
        // if (Gate::allows('isSuperAdmin')) {

        //    echo "you are admin";

        // } else {

        //     echo "you are not admin";

        // }

        // return $response;
        // if (Gate::denies('isSuperAdmin')) {
        //         abort(403);
        //     }

        // die();
        $wordlist = Orders::where('payment_status', '=','paid')->get();
        $deliveryorder = $wordlist->count();
        $re_avtive = Orders::where('order_status', '=','restaurant')->where('status', '=','1')->get();
        $active_resto = $re_avtive->count();
        $delivery = Deliver_boy::all();
        $delivery_boy = $delivery->count();
        $chef = Vendors::where('vendor_type', '=','chef')->get();
        $chef = $chef->count();
        return view('admin.dashbord.dash', compact('deliveryorder','active_resto','delivery_boy','chef'));
    }
}
