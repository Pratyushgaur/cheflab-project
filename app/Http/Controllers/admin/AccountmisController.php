<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\Product_master;
use App\Models\Vendors;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;
class AccountmisController extends Controller
{
    public function index()
    {
       
        return view('admin.mis.list');
    }

    
    public function get_data_table_of_order(Request $request)
    {
        
        if ($request->ajax()) {
        
           $data = Orders::join('order_commisions','orders.id','=','order_commisions.order_id')->join('vendors','orders.vendor_id','=','vendors.id')->join('users','orders.user_id','=','users.id')->select('orders.order_id','orders.transaction_id','orders.coupon_id','orders.preparation_time_from','orders.preparation_time_to','orders.customer_name','vendors.name as vendor_name','order_commisions.net_amount','order_commisions.vendor_commision','order_commisions.admin_commision','order_commisions.admin_amount');
           if($request->status != ''){
            $data = $data->where('payment_status','=',$request->status);
           }
           if($request->role != ''){
            $data = $data->where('vendors.vendor_type','=',$request->role);
           }
           if($request->vendor != ''){
            $data = $data->where('orders.vendor_id','=',$request->vendor);
           }

           $dateSedule = $request->datePicker;
        
           if(isset($dateSedule)){
           $packagetime = explode('/', $dateSedule);
           $start_time = $packagetime[0].' 00:00:00';
           $end_time = $packagetime[1].' 23:59:59';
           }

           if(!empty($start_time) && !empty($end_time)) {
            $data = $data->whereBetween('orders.created_at', [$start_time, $end_time]);
           }
    
           
           $data = $data->get();
        //    echo '<pre>'; print_r($data);die;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('wallet_cut', function($data){
                    $wallet_cut = 0;
                    return $wallet_cut;
                })


                ->rawColumns(['wallet_cut','action-js'])
                ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
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

            // echo '<pre>'; print_r($order);die;
            $vendor_id = $order->vendor_id;
            $user_id = $order->user_id;
            $orderProduct = OrderProduct::findOrFail($order_id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','primary_variant_name','product_price','type')->get();
            $vendor = Vendors::findOrFail($vendor_id);
            $users = User::findOrFail($user_id);
            
            return view('admin.order.view',compact('order','orderProduct','product','vendor','users'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    public function invoiceorder($order_id){
        $order = Orders::where('order_id',$order_id)->first();
        $vendor = Vendors::findOrFail($order->vendor_id);
        $users = User::findOrFail($order->user_id);
        $orderProduct = OrderProduct::findOrFail($order_id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','primary_variant_name','product_price','type')->get();
        return view('admin.order.invoice',compact('order','vendor','users','product'));
        // echo '<pre>'; print_r($order);die;
    }
    public function status_update(Request $request){
      
        $status = $request->status;
        $id = $request->id;
        $orders = Orders::where('id', '=',  $id)->first();
        $orders->order_status = $status;
        $orders->save();
       
        return ;
    }

    public function invoice($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $order_id =$id;
            $order = Orders::findOrFail($id);
            $vendor_id = $order->vendor_id;
            $orderProduct = OrderProduct::findOrFail($order_id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','primary_variant_name','product_price')->get();
            $vendor = Vendors::findOrFail($vendor_id);
            return view('admin.order.invoice',compact('order','orderProduct','product','vendor'));
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
