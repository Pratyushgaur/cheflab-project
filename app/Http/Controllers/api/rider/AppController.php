<?php

namespace App\Http\Controllers\api\rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\RiderAssignOrders;
use App\Models\OrderProduct;
use App\Models\Deliver_boy;
use App\Models\DeliveryBoyTokens;
use App\Models\DriverWorkingLogs;
use Carbon\Carbon;
use App\jobs\UserOrderNotification;
use Illuminate\Support\Facades\DB;
use PDOException;
use Throwable;
use URL;
use Validator;
use App\Notifications\UserOrderAcceptNotification;
class AppController extends Controller
{
    public function home(Request $request)
    {

    // $pi80 = M_PI / 180;
    // $lat1 = floatval(22.9535588) * $pi80;
    // $lng1 = floatval(76.0328445) * $pi80;
    // $lat2 = floatval(22.761070) * $pi80;
    // $lng2 = floatval(75.914160) * $pi80;

    // $r = 6372.797; // earth radius
    // $dlat = $lat2 - $lat1;
    // $dlng = $lng2 - $lng1;
    // $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    // $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    // $km = $r * $c;

    // echo "Distance: ". round($km*1.3);
    // die;
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }

            //$order = RiderAssignOrders::where(['rider_id' =>$request->user_id])->orWhere(['rider_id' =>$request->user_id,'action' =>'1'])->whereNotIn('action', ['pending', 'cancelled_by_customer_before_confirmed']);->orderBy('rider_assign_orders.id','desc')->limit(1);
            $order = RiderAssignOrders::where(['rider_id' =>$request->user_id])->whereNotIn('action', ['2', '5'])->orderBy('rider_assign_orders.id','desc')->limit(1);
            $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
            $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
            $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.order_status','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id','rider_assign_orders.id as rider_assign_order_id','otp');
           
            if ($order->first()->action == '0') {
                $order = $order->first();
                $order->expected_earninig = 50;
                $order->trip_distance = 7;
            } else {
                $order = $order->addSelect('vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount');
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $order->products = OrderProduct::where('order_id','=',$order->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_product_variants.variant_name','products.type')->get();
            }
            $data = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['orders'=>$order,'profile'=>$data]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $data = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'));
            if($data->exists()){
                $data = $data->first();   
                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => $data
    
                ], 200);  
            }else{
                return response()->json([
                    'status'   => false,
                    'error'  => 'No User Found'
    
                ], 500);
            }
                       
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function register_token(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id',
                    'token'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            if(!DeliveryBoyTokens::where(['rider_id'=>$request->user_id,'token'=>$request->token])->exists())
            {
                $DeliveryBoyTokens = new DeliveryBoyTokens;
                $DeliveryBoyTokens->rider_id = $request->user_id;
                $DeliveryBoyTokens->token = $request->token;
                $DeliveryBoyTokens->saveOrFail();
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Token Register Successfully'

            ], 200);  
                       
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    public function orderStatus(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'order_row_id' => 'required|numeric|exists:orders,id',
                    'user_id' => 'required|numeric|exists:deliver_boy,id',
                    'rider_assign_order_id'=>'required|exists:rider_assign_orders,id',
                    'status'   => 'required',
                    'distance' => [
                        'required_if:status,==,1'
                    ],
                    'earning' => [
                        'required_if:status,==,1' 
                    ],
                    'cancel_reason' =>[
                        'required_if:status,==,2'
                    ],
                    'otp' =>[
                        'required_if:status,==,4'
                    ]
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            
            $profile = Deliver_boy::where('id','=',$request->user_id)->select('id','name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            RiderAssignOrders::where('id','=',$request->rider_assign_order_id)->update(['action'=>$request->status]);
            $order = [];
            if ($request->status == '1') {
                RiderAssignOrders::where('id','=',$request->rider_assign_order_id)->update(['distance'=>$request->distance,'earning'=>$request->earning]);
                $order = RiderAssignOrders::where('rider_assign_orders.id','=',$request->rider_assign_order_id);
                $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
                $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
                $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id','rider_assign_orders.id as rider_assign_order_id','otp');
                $order = $order->addSelect('vendors.mobile as vendor_mobile','orders.order_status','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount');
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $order->products = OrderProduct::where('order_id','=',$order->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_product_variants.variant_name','products.type')->get();
                RiderAssignOrders::where('order_id','=',$request->order_row_id)->update(['distance'=>$request->distance,'earning'=>$request->earning]);
                $orderdata = Order::where('id','=',$request->order_row_id);
                $orderdata->update(['accepted_driver_id'=>$request->user_id]);
                $user = \App\Models\User::where('id','=',$orderdata->first()->user_id)->first();
                if($user->fcm_token != ''){
                    //sendUserAppNotification('Order Assigned to Delivery Patner',"Your Order has been Assigned to Delivery Boy",$user->fcm_token,array('type'=>2,'data'=>array('data'=>$profile)));
                    $data = orderDetailForUser($request->order_row_id);
                    \App\Jobs\UserOrderNotification::dispatch('Order Assigned to Delivery Patner','Your Order has been Assigned to Delivery Boy',$user->fcm_token,2,$data);
                }
                
                
            }elseif($request->status == '2'){
                RiderAssignOrders::where('id','=',$request->rider_assign_order_id)->update(['cancel_reason'=>$request->cancel_reason]);
            }elseif($request->status == '3'){
                Order::where('id','=',$request->order_row_id);
                $orderdata->update(['order_status'=>'completed','delivered_time'=>mysql_date_time()]);
                $user = \App\Models\User::where('id','=',$orderdata->first()->user_id)->first()->fcm_token;
                if($user->fcm_token != ''){
                    //sendUserAppNotification('Order Delivered Successfully',"Your Order has been Delivered Successfully",$user->fcm_token,array('type'=>5,'data'=>array('data'=>array())));
                    $data = orderDetailForUser($request->order_row_id);
                    \App\Jobs\UserOrderNotification::dispatch('Order Delivered Successfully','Your Order has been Delivered Successfully',$user->fcm_token,5,$data);
                }
            }
            
            
            return response()->json([
                'status'   => true,
                'message'  => 'Status Updated Successfully',
                'order'    => $order,
                'profile'  => $profile

            ], 200);    
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function pickupOtpCheck(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'order_row_id' => 'required|numeric|exists:orders,id',
                    'rider_assign_order_id'=>'required|exists:rider_assign_orders,id',
                    'otp'=>'required',
                    'user_id' => 'required|numeric|exists:deliver_boy,id'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            

            $order = RiderAssignOrders::where('id','=',$request->rider_assign_order_id)->first();
            if(empty($order)){
                return response()->json([
                    'status' => false,
                    'error'  =>'No Order found'

                ], 401);
            }
            if($order->otp == $request->otp){
                RiderAssignOrders::where('id','=',$order->id)->update(['action'=>'4']);
                $orderdata = Order::where('id','=',$request->order_row_id);
                $orderdata->update(['order_status'=>'dispatched','pickup_time'=>mysql_date_time()]);
                $user = \App\Models\User::where('id','=',$orderdata->first()->user_id)->select('fcm_token')->first();
                if(!empty($user)){
                    if($user->fcm_token != ''){
                        //xsendUserAppNotification('Order dispated from restaurant ',"Your Order has been Dispatched",$user->fcm_token,array('type'=>4,'data'=>array('data'=>array())));
                        $data = orderDetailForUser($request->order_row_id);
                        \App\Jobs\UserOrderNotification::dispatch('Order dispated from restauran','Your Order has been Dispatched',$user->fcm_token,4,$data);
                    }
                }
                
                $order = RiderAssignOrders::where('rider_assign_orders.id','=',$request->rider_assign_order_id);
                $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
                $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
                $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.order_status','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id','rider_assign_orders.id as rider_assign_order_id','otp');
                $order = $order->addSelect('vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount');
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $order->products = OrderProduct::where('order_id','=',$order->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_product_variants.variant_name','products.type')->get();
                //
                
                return response()->json([
                    'status'   => true,
                    'message'  => 'Status Updated Successfully',
                    'order' =>$order
                ], 200); 
            }else{
                return response()->json([
                    'status' => false,
                    'error'  =>'Invalid OTP'

                ], 401);
            }

              
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function change_status(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id',
                    'status'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            Deliver_boy::where('id','=',$request->user_id)->update(['is_online'=>$request->status]);
            $DriverWorkingLogs = new DriverWorkingLogs;
            $DriverWorkingLogs->rider_id = $request->user_id;
            $DriverWorkingLogs->status = $request->status;
            $DriverWorkingLogs->saveOrFail();
            return response()->json([
                'status'   => true,
                'message'  => 'Status Updated Successfully'

            ], 200);    
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    
    public function analytics(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id',
                    'report_for'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $RiderAssignOrders = new RiderAssignOrders ;
            if($request->report_for == 'today'){
                $RiderAssignOrders = $RiderAssignOrders->whereBetween(
                    'created_at' ,[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                );
            }
            if($request->report_for == 'week'){
                $RiderAssignOrders = $RiderAssignOrders->whereBetween(
                    'created_at' ,[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                );
            }
            if($request->report_for == 'month'){
                $RiderAssignOrders = $RiderAssignOrders->where('created_at','>=' ,Carbon::now()->subDays(30));
            }
            
            $RiderAssignOrders = $RiderAssignOrders->where(['action'=>'3','rider_id'=>$request->user_id])->select(\DB::raw('IFNULL(SUM(earning),0) as earning'),\DB::raw('IFNULL(COUNT(id),0) as order_count'))->first();
            //[now()->subdays(30), now()->subday()]
            
            //
            $period = \Carbon\CarbonPeriod::create(Carbon::now()->subDays(6), Carbon::now());
            $chart = [];
            foreach ($period as $date) {
                $dayData  =  RiderAssignOrders::whereDate('created_at',$date)->select(\DB::raw('IFNULL(SUM(earning),0) as earning'))->first();
                $dayData->day = $date->format('D');
                $chart[] = $dayData;
                    
            }
            $profile = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'));
            return response()->json([
                'status'   => true,
                'message'  => 'data Get Successfully',
                'reports' => $RiderAssignOrders,
                'chart' =>$chart,
                'profile'=>$profile

            ], 200);    
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function updateLatLng(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id',
                    'lat' => 'required',
                    'lng'   => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            Deliver_boy::where('id','=',$request->user_id)->update(['lat'=>$request->lat,'lng'=>$request->lng]);

            return response()->json([
                'status'   => true,
                'message'  => 'Lat Lng Updated'

            ], 200);    
            
           
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    // public function orderHistory(Request $request)
    // {
    //     try {
    //         $validateUser = Validator::make(
    //             $request->all(),
    //             [
    //                 'user_id' => 'required|numeric|exists:deliver_boy,id',
    //                 'status'   => 'required'
    //             ]
    //         );
    //         if ($validateUser->fails()) {
    //             $error = $validateUser->errors();
    //             return response()->json([
    //                 'status' => false,
    //                 'error'  => $validateUser->errors()->all()

    //             ], 401);
    //         }
            
    //         $order = RiderAssignOrders::where(['rider_id' =>$request->user_id]);
    //         if($request->status == 'completed'){
    //             $order = $order->where('action','=','3');
    //         }
    //         if($request->status == 'cancel'){
    //             $order = $order->where('action','=','2');
    //         }
    //         return $order->get();
    //         $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
    //         $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
    //         $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id');
    //         $order = $order->addSelect('vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount',);
    //         $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
    //         $order = $order->get();

    //         // ->orWhere(['rider_id' =>$request->user_id,'action' =>'1'])->orderBy('rider_assign_orders.id','desc')->limit(1);
    //         // $order = $order->join('orders','rider_assign_orders.order_id','=','orders.id');
    //         // $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
    //         // $order = $order->select('vendors.name as vendor_name','vendors.address as vendor_address','orders.customer_name','orders.delivery_address',DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'),'action','orders.id as order_row_id','orders.order_id');
           
    //         // if ($order->first()->action == '0') {
    //         //     $order = $order->first();
    //         //     $order->expected_earninig = 50;
    //         //     $order->trip_distance = 7;
    //         // } else {
    //         //     $order = $order->addSelect('vendors.mobile as vendor_mobile','vendors.lat as vendor_lat','vendors.long as vendor_lng','orders.lat as customer_lat','orders.long as customer_lng','orders.mobile_number as customer_mobile','net_amount',);
    //         //     $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
    //         //     $order = $order->first();
    //         //     $order->products = OrderProduct::where('order_id','=',$order->order_row_id)->join('products','order_products.product_id','=','products.id')->leftJoin('order_product_variants','order_products.id','=','order_product_variants.order_product_id')->select('order_products.product_name','order_product_variants.variant_name','products.type')->get();
    //         // }
    //         $profile = Deliver_boy::where('id','=',$request->user_id)->select('name','email','username','mobile','is_online',\DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'));
    //         return response()->json([
    //             'status'   => true,
    //             'message'  => 'data Get Successfully',
    //             'reports' => $RiderAssignOrders,
    //             'chart' =>$chart,
    //             'profile' =>$profile

    //         ], 200);    
            
           
    //     } catch (Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error'  => $th->getMessage()
    //         ], 500);
    //     }
    // }
}
