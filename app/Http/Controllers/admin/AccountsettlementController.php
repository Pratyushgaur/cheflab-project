<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\AdminMasters;
use App\Models\Product_master;
use App\Models\Vendor_order_statement;
use App\Models\Vendor_payout_detail;
use App\Models\Vendors;
use App\Models\OrderCommision;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;
use DB;
class AccountsettlementController extends Controller
{
    public function index()
    {

        return view('admin.account-vendor.list');
    }   

    

    public function get_data_table_of_order(Request $request)
    {
       
        if ($request->ajax()) {

          if($request->week == ''){
            $data = [];
          }else{
            $dates = explode('&',$request->week);
            $data = Vendors::select('vendor_order_statements.*','vendors.id as vendor_id','vendors.status','vendors.name','vendors.pancard_number')->join('vendor_order_statements','vendors.id','=','vendor_order_statements.vendor_id');
            $data = $data->where('vendor_order_statements.start_date', date('Y-m-d',strtotime($dates[0])));
            $data = $data->where('vendor_order_statements.end_date', date('Y-m-d',strtotime($dates[1])));
            $data = $data->get();
          }
            

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($data){
                    if ($data->pay_status == 0) {
                        $btn = '<a target="_blank" class="btn btn-xs btn-danger" href="'. route("admin.account.vendor.vendorPaymentSuccess").'?id='.$data->id.'">Pay</a>';
                    }else{
                        $btn = '<a href="#" class="btn btn-xs btn-success" >Success</a>';
                    } 
                    return $btn;
                })
                ->addColumn('name', function($data){
                   $name = ucwords($data->name);
                    return $name;
                }) 
                ->addColumn('total', function($data){
                   $total = $data->paid_amount - $data->vendor_cancel_deduction;
                    return $total;
                }) 
                ->addColumn('start_date', function($data){
                    $start_date = date('d-M-Y', strtotime($data->start_date));
                     return $start_date;
                 }) 
                 ->addColumn('end_date', function($data){
                    $end_date = date('d-M-Y', strtotime($data->end_date));
                     return $end_date;
                 })   
                   
                ->rawColumns(['status','name','total','start_date','end_date'])
                
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

    public function vendorPaymentSuccess()
    {
        
        $id = $_GET['id'];
        $data = Vendor_order_statement::where(['id'=> $id, 'pay_status'=> 0])->first();
        $bank = \App\Models\BankDetail::where('vendor_id','=',$data->vendor_id)->select('holder_name','account_no','ifsc','bank_name')->get();
        return view('admin.account-vendor.paymentsuccess',compact('id','data','bank'));
    }

    public function payVendorPayment(Request $request)
    {
      
        $data = ([
            'vendor_id' => $request->vendor_id,
            'amount' => $request->amount,
            'bank_utr' => $request->bank_utr,
            'vendor_order_statements' =>$request->id
        ]);
        
        $dataNew = ([
            'pay_status' => 1,
            'total_pay_amount' => $request->amount,
            'bank_utr_number' =>$request->bank_utr,
            'payment_success_date' => date('d-m-Y H:m:s')
        ]);
        Vendor_order_statement::where(['id'=> $request->id, 'pay_status'=> '0'])->update($dataNew);
        Vendor_payout_detail::create($data);
        return redirect()->route('admin.account.vendor.list')->with('message', 'Pay Amount '. $request->amount. ' to Vendor Successfully');
    }

    public function utr_number(Request $request)
    {
    
echo "hello";die;
    }

}
