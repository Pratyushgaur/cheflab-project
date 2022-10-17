<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\Product_master;
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
                    $btn = '<a href="'. route("admin.order.view",Crypt::encryptString($data->id)) .'"><i class="fa fa-eye"></i></a>';
                    
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
    public function vieworder($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $order_id =$id;
            $order = Orders::findOrFail($id);
            $vendor_id = $order->vendor_id;
            $orderProduct = OrderProduct::findOrFail($order_id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','primary_variant_name','product_price')->get();
            $vendor = Vendors::findOrFail($vendor_id);
            return view('admin.order.view',compact('order','orderProduct','product','vendor'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    public function get_data_table_of_product(Request $request,$id)
    {
        $product_id = $id;
        if ($request->ajax()) {
        
           //$data = Product_master::join('vendors','orders.vendor_id','=','vendors.id')->select('orders.id','orders.customer_name','orders.order_status','net_amount','payment_type','orders.created_at', 'vendors.name as vendor_name','vendors.vendor_type');
           $data = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','product_price','primary_variant_name')->get();
           return Datatables::of($data)
           ->addIndexColumn()
          

           ->addColumn('date', function($data){
               $date_with_format = date('d M Y',strtotime($data->created_at));
               return $date_with_format;
           })
          
           ->addColumn('product_name', function ($data) {
            $btn = ' <img src="' . asset('products') . '/' . $data->product_image . '" data-pretty="prettyPhoto" style="width:50px; height:30px;" alt="Trolltunga, Norway"> <div id="myModal" class="modal">
            <img class="modal-content" id="img01">
            </div>' . $data->product_name . '';
            return $btn;
        })

           ->rawColumns(['date'])
           ->rawColumns(['product_name']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
           ->make(true);
        }
    }
}
