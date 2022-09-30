<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Vendors;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;
class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.list');
    }
    public function get_data_table_of_order(Request $request)
    {
        if ($request->ajax()) {
        
           $data = Orders::join('vendors','orders.vendor_id','=','vendors.id')->select('orders.id','orders.customer_name','orders.order_status','net_amount','payment_type','orders.created_at', 'vendors.name as vendor_name','vendors.vendor_type');
           if($request->status != ''){
            $data = $data->where('payment_status','=',$request->status);
           }
           if($request->role != ''){
            $data = $data->where('vendors.vendor_type','=',$request->role);
           }
           if($request->vendor != ''){
            $data = $data->where('orders.vendor_id','=',$request->vendor);
           }
           
           $data = $data->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("restaurant.coupon.edit",Crypt::encryptString($data->id)) .'"><i class="fa fa-eye"></i></a>';
                    
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                // ->addColumn('status', function($data){
                //     if ($data->status == 1) {
                //         $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round couponOff" data-id="' . $data->id . '"></span></label>';
                //     } elseif($data->status == 0) {
                //         $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round  couponON" data-id="' . $data->id . '""></span></label>';
                //     }
                //     return $btn;
                // })
                // ->addColumn('discount_type', function($data){
                //     if ($data->discount_type) {
                //         $btn = ''.$data->discount.'<i class="fa fa-percent fa-sm"></i>';
                //     } else {
                //         $btn = ''.$data->discount.'<i class="fas fa-rupee-sign fa-sm"></i>';
                //     }    
                //     return $btn;
                // })
              


                ->rawColumns(['date','action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }

    public function getVendorByRole(Request $request)
    {
        return Vendors::where('vendor_type','=',$request->role)->select('id','name')->get();
    }
}
