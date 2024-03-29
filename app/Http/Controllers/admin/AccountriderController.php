<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\Product_master;
use App\Models\Vendors;
use App\Models\RiderAssignOrders;
use App\Models\RiderOrderStatement;
use App\Models\RiderPayoutDetail;
use App\Models\RiderTransactions;
use App\Models\Deliver_boy;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;
class AccountriderController extends Controller
{
    public function index()
    {
        return view('admin.account-rider.list');
    }

    
    public function get_data_table_of_order(Request $request)
    {
        
        if ($request->ajax()) {
      
        $data = Deliver_boy::select('rider_order_statements.*','deliver_boy.boy_id','deliver_boy.id as riderId','deliver_boy.id','deliver_boy.status','deliver_boy.name','riderbank_details.bank_name','riderbank_details.account_no','deliver_boy.pancard_number','riderbank_details.ifsc','riderbank_details.holder_name')->join('riderbank_details','deliver_boy.id','=','riderbank_details.rider_id')->join('rider_order_statements','deliver_boy.id','=','rider_order_statements.rider_id');
           
            

           $dateSedule = $request->datePicker;
        
           if(isset($dateSedule)){
           $packagetime = explode('/', $dateSedule);
           $start_time = $packagetime[0].' 00:00:00';
           $end_time = $packagetime[1].' 23:59:59';
           }

           
           if(!empty($start_time) && !empty($end_time)) {
            $data = $data->whereBetween('rider_order_statements.created_at', [$start_time, $end_time]);
           
           }
    
           
           $data = $data->get();
        //    echo '<pre>'; print_r($data);die;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($data){
                    if ($data->pay_status == 0) {
                        $btn = '<a class="btn btn-xs btn-danger" href="'. route("admin.account.rider.riderPaymentSuccess").'?id='.$data->riderId.'">Pay</a>';
                    }else{
                        $btn = '<a class="btn btn-xs btn-success" href="javascript:void(0);">Success</a>';
                    } 
                    return $btn;
                })
                ->addColumn('start_date', function($data){
                    $start_date = date('m-Y-d H:m:s', strtotime($data->start_date));
                     return $start_date;
                 }) 
                 ->addColumn('end_date', function($data){
                    $end_date = date('m-Y-d H:m:s', strtotime($data->end_date));
                     return $end_date;
                 }) 
                
                ->rawColumns(['status'])
                
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


    public function riderPaymentSuccess()
    {
        
        $id = $_GET['id'];
        $data = RiderOrderStatement::where(['rider_id'=> $id, 'pay_status'=> 0])->first();
        return view('admin.account-rider.paymentsuccess',compact('id','data'));
    }

    public function payRiderPayment(Request $request)
    {
        
        $data = ([
            'rider_id' => $request->id,
            'amount' => $request->amount,
            'bank_utr' => $request->bank_utr
        ]);
        $dataNew = ([
            'pay_status' => 1,
            'total_pay_amount' => $request->amount,
            'bank_utr_number' => $request->bank_utr,
            'payment_success_date' => date('d-m-Y H:m:s')
        ]);
        RiderOrderStatement::where(['rider_id'=> $request->id, 'pay_status'=> 0])->first()->update($dataNew);
        RiderPayoutDetail::create($data);
        $riderTransactions = new RiderTransactions;
        $riderTransactions->rider_id = $request->id;
        $riderTransactions->type = 'Payout';
        $riderTransactions->transaction_id = $request->bank_utr;
        $riderTransactions->amount = $request->amount;
        $riderTransactions->save();
        return redirect()->route('admin.account.rider.list')->with('message', 'Pay Amount '. $request->amount. ' to Rider Successfully');
    }
}
