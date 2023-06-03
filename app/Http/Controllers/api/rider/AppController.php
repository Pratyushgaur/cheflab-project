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
use App\Models\RiderOrderStatement;
use App\Models\Driver_total_working_perday;
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
            $data = Deliver_boy::where('id', '=', $request->user_id)->select('name', 'email', 'username', 'mobile', 'is_online', \DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            //$order = RiderAssignOrders::where(['rider_id' =>$request->user_id])->orWhere(['rider_id' =>$request->user_id,'action' =>'1'])->whereNotIn('action', ['pending', 'cancelled_by_customer_before_confirmed']);->orderBy('rider_assign_orders.id','desc')->limit(1);
            $order = RiderAssignOrders::where(['rider_id' => $request->user_id])->whereNotIn('action', ['2', '5', '3', '6'])->orderBy('rider_assign_orders.id', 'desc')->limit(1);
            $order = $order->join('orders', 'rider_assign_orders.order_id', '=', 'orders.id');
            $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
            $order = $order->select('vendors.name as vendor_name', 'vendors.address as vendor_address', 'orders.order_status', 'orders.customer_name', 'orders.delivery_address', DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'), 'action', 'distance', 'earning', 'orders.id as order_row_id', 'orders.order_id', 'rider_assign_orders.id as rider_assign_order_id', 'otp');
            if ($order->exists()) {
                if ($order->first()->action == '0') {
                    $order = $order->first();
                    $order->expected_earninig = $order->earning;
                    $order->trip_distance = $order->distance;
                    $busy = false;
                } else {
                    $order = $order->addSelect('vendors.mobile as vendor_mobile', 'vendors.lat as vendor_lat', 'vendors.long as vendor_lng', 'orders.lat as customer_lat', 'orders.long as customer_lng', 'orders.mobile_number as customer_mobile', 'net_amount', 'avoid_ring_bell', 'leave_at_door', 'avoid_calling', 'direction_to_reach', 'direction_instruction');
                    $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                    $order = $order->first();
                    $products = OrderProduct::where('order_id', '=', $order->order_row_id)->join('products', 'order_products.product_id', '=', 'products.id')->leftJoin('order_product_variants', 'order_products.id', '=', 'order_product_variants.order_product_id')->select('order_products.product_name', 'order_products.product_qty', 'order_product_variants.variant_name', 'products.type', 'order_products.id as order_product_row_id', 'products.customizable')->get();
                    foreach ($products as $key => $value) {
                        if ($value->customizable == 'false') {
                            $products[$key]->variant_name = '';
                        }
                        $addons = \App\Models\OrderProductAddon::where('order_product_id', '=', $value->order_product_row_id)->select('addon_name', 'addon_price', 'addon_qty')->get();
                        $products[$key]->addons = $addons;
                    }
                    $order->products = $products;
                    $busy = true;
                }

                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => ['orders' => $order, 'busy' => $busy, 'profile' => $data]

                ], 200);
            } else {
                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => ['orders' => null, 'busy' => false, 'profile' => $data]

                ], 200);
            }
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

            $data = Deliver_boy::where('id', '=', $request->user_id);
            $data =     $data->select(
                'name',
                'email',
                'username',
                'mobile',
                'is_online',
                'address',
                'licence_number',
                'rc_number',
                'leader_contact_no',
                'status',
                \DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'),
                \DB::Raw('IFNULL( CONCAT("' . asset('dliver-boy-documents') . '/", licence_image), null ) as licence_image'),
                \DB::Raw('IFNULL( CONCAT("' . asset('dliver-boy-documents') . '/", rc_image), null ) as rc_image'),
                \DB::Raw('IFNULL( CONCAT("' . asset('dliver-boy-documents') . '/", insurance_image), null ) as insurance_image'),
                \DB::Raw('IFNULL( CONCAT("' . asset('dliver-boy-documents') . '/", pancard_image), null ) as pancard_image')
            );
            if ($data->exists()) {
                $data = $data->first();
                return response()->json([
                    'status'   => true,
                    'message'  => 'Data Get Successfully',
                    'response' => $data

                ], 200);
            } else {
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
            // if (!DeliveryBoyTokens::where(['rider_id' => $request->user_id, 'token' => $request->token])->exists()) {
            //     // DeliveryBoyTokens::where('rider_id','!=',$request->user_id)->where('token','=',$request->token)->delete();
            //     // DeliveryBoyTokens::where('rider_id','=',$request->user_id)->delete();
                
                
            // }
            if(DeliveryBoyTokens::where('rider_id', '=',$request->user_id)->exists()){
                DeliveryBoyTokens::where('rider_id','=',$request->user_id)->update(['token'=>$request->token]);
            }else{
                $DeliveryBoyTokens = new DeliveryBoyTokens;
                $DeliveryBoyTokens->rider_id = $request->user_id;
                $DeliveryBoyTokens->token = $request->token;
                $DeliveryBoyTokens->saveOrFail();
            }
             DeliveryBoyTokens::where('rider_id','!=',$request->user_id)->where('token','=',$request->token)->delete();
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
                    'rider_assign_order_id' => 'required|exists:rider_assign_orders,id',
                    'status'   => 'required',
                    'distance' => [
                        'required_if:status,==,1'
                    ],
                    'earning' => [
                        'required_if:status,==,1'
                    ],
                    'cancel_reason' => [
                        'required_if:status,==,2'
                    ],
                    'otp' => [
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

            $profile = Deliver_boy::where('id', '=', $request->user_id)->select('id', 'name', 'email', 'username', 'mobile', 'is_online', \DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'), 'status')->first();
            if ($profile->status == "0") {
                return response()->json([
                    'status'   => true,
                    'active_user' => $profile->status,
                    'message'  => 'Account Deactive'

                ], 200);
            }
            $asing = RiderAssignOrders::where('id', '=', $request->rider_assign_order_id);
            if ($request->status == '1' || $request->status == '2') {
                if ($asing->first()->action == '0') {
                    $asing->update(['action' => $request->status]);
                } else {
                    return response()->json([
                        'status' => false,
                        'active_user' => $profile->status,
                        'error'  => 'You Can Not Process With This Order'
                    ], 500);
                }
            } else {
                $asing->update(['action' => $request->status]);
            }

            $order = [];
            if ($request->status == '1') {
                $otp = rand(1000, 9999);
                RiderAssignOrders::where('id', '=', $request->rider_assign_order_id)->update(['distance' => $request->distance, 'earning' => $request->earning, 'otp' => $otp]);
                $order = RiderAssignOrders::where('rider_assign_orders.id', '=', $request->rider_assign_order_id);
                $order = $order->join('orders', 'rider_assign_orders.order_id', '=', 'orders.id');
                $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
                $order = $order->select('vendors.name as vendor_name', 'vendors.address as vendor_address', 'orders.customer_name', 'orders.delivery_address', DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'), 'action', 'orders.id as order_row_id', 'orders.order_id', 'rider_assign_orders.id as rider_assign_order_id', 'otp');
                $order = $order->addSelect('vendors.mobile as vendor_mobile', 'orders.order_status', 'vendors.lat as vendor_lat', 'vendors.long as vendor_lng', 'orders.lat as customer_lat', 'orders.long as customer_lng', 'orders.mobile_number as customer_mobile', 'net_amount');
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $products = OrderProduct::where('order_id', '=', $order->order_row_id)->join('products', 'order_products.product_id', '=', 'products.id')->leftJoin('order_product_variants', 'order_products.id', '=', 'order_product_variants.order_product_id')->select('order_products.product_name', 'order_products.product_qty', 'order_product_variants.variant_name', 'products.type', 'order_products.id as order_product_row_id')->get();
                foreach ($products as $key => $value) {
                    $addons = \App\Models\OrderProductAddon::where('order_product_id', '=', $value->order_product_row_id)->select('addon_name', 'addon_price', 'addon_qty')->get();
                    $products[$key]->addons = $addons;
                }
                $order->products = $products;
                RiderAssignOrders::where('order_id', '=', $request->order_row_id)->update(['distance' => $request->distance, 'earning' => $request->earning]);
                \App\Models\OrderActionLogs::create(['orderid'=> $request->order_row_id,'action' => 'Rider Accepted Order' ,'rider_id'=>$request->user_id]);
                $orderdata = Order::where('id', '=', $request->order_row_id);
                $orderdata->update(['accepted_driver_id' => $request->user_id]);
                $user = \App\Models\User::where('id', '=', $orderdata->first()->user_id)->first();
                if ($user->fcm_token != '') {
                    //sendUserAppNotification('Order Assigned to Delivery Patner',"Your Order has been Assigned to Delivery Boy",$user->fcm_token,array('type'=>2,'data'=>array('data'=>$profile)));
                    $data = orderDetailForUser($request->order_row_id);
                    \App\Jobs\UserOrderNotification::dispatch('Delivery partner assigned', 'Our Delivery Partner is on their way to the restaurant.', $user->fcm_token, 2, $data);
                }
            } elseif ($request->status == '2') {
                RiderAssignOrders::where('id', '=', $request->rider_assign_order_id)->update(['cancel_reason' => $request->cancel_reason,'is_rejected' => '1']);
                \App\Models\OrderActionLogs::create(['orderid'=> $request->order_row_id,'action' => 'Rider Rejected Order' ,'rider_id'=>$request->user_id]);
                $orderData = Order::where('id', '=', $request->order_row_id)->first();
                \App\Jobs\DriveAssignOrderJob::dispatch($orderData);
            }


            return response()->json([
                'status'   => true,
                'active_user' => $profile->status,
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
                    'rider_assign_order_id' => 'required|exists:rider_assign_orders,id',
                    'otp' => 'required',
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

            $otp = Order::where('id', '=', $request->order_row_id)->select('pickup_otp')->first();
            $order = RiderAssignOrders::where('id', '=', $request->rider_assign_order_id)->first();
            if (empty($order)) {
                return response()->json([
                    'status' => false,
                    'error'  => 'No Order found'

                ], 401);
            }

            if ($otp->pickup_otp == $request->otp) {
                RiderAssignOrders::where('id', '=', $order->id)->update(['action' => '4']);
                \App\Models\OrderActionLogs::create(['orderid'=> $request->order_row_id,'action' => 'Rider Pickup Order' ,'rider_id'=>$request->user_id]);
                $orderdata = Order::where('id', '=', $request->order_row_id);
                $orderdata->update(['order_status' => 'dispatched', 'pickup_time' => mysql_date_time()]);
                orderDeliverd($request->order_row_id);
                $user = \App\Models\User::where('id', '=', $orderdata->first()->user_id)->select('fcm_token')->first();
                if (count($user) > 0) {
                    if ($user->fcm_token != '') {
                        //xsendUserAppNotification('Order dispated from restaurant ',"Your Order has been Dispatched",$user->fcm_token,array('type'=>4,'data'=>array('data'=>array())));
                        $data = orderDetailForUser($request->order_row_id);
                        var_dump($data);
                        \App\Jobs\UserOrderNotification::dispatch('Out for delivery', 'Delivery Partner is on their way. They will reach you shortly.', $user->fcm_token, 4, $data);
                    }
                }

                $order = RiderAssignOrders::where('rider_assign_orders.id', '=', $request->rider_assign_order_id);
                $order = $order->join('orders', 'rider_assign_orders.order_id', '=', 'orders.id');
                $order = $order->join('vendors', 'orders.vendor_id', '=', 'vendors.id');
                $order = $order->select('vendors.name as vendor_name', 'vendors.address as vendor_address', 'orders.order_status', 'orders.customer_name', 'orders.delivery_address', DB::raw('if(rider_assign_orders.action = "1", "accepted", "pending")  as rider_status'), 'action', 'orders.id as order_row_id', 'orders.order_id', 'rider_assign_orders.id as rider_assign_order_id', 'otp');
                $order = $order->addSelect('vendors.mobile as vendor_mobile', 'vendors.lat as vendor_lat', 'vendors.long as vendor_lng', 'orders.lat as customer_lat', 'orders.long as customer_lng', 'orders.mobile_number as customer_mobile', 'net_amount');
                $order = $order->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id');
                $order = $order->first();
                $products = OrderProduct::where('order_id', '=', $order->order_row_id)->join('products', 'order_products.product_id', '=', 'products.id')->leftJoin('order_product_variants', 'order_products.id', '=', 'order_product_variants.order_product_id')->select('order_products.product_name', 'order_products.product_qty', 'order_product_variants.variant_name', 'products.type', 'order_products.id as order_product_row_id')->get();
                foreach ($products as $key => $value) {
                    $addons = \App\Models\OrderProductAddon::where('order_product_id', '=', $value->order_product_row_id)->select('addon_name', 'addon_price', 'addon_qty')->get();
                    $products[$key]->addons = $addons;
                }
                $order->products = $products;
                return response()->json([
                    'status'   => true,
                    'message'  => 'Status Updated Successfully',
                    'order' => $order
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error'  => 'Invalid OTP'

                ], 401);
            }
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function deliverOtpCheck(Request $request)
    {

        // $logs = \App\Models\DriverWorkingLogs::where('rider_id',1)->whereMonth('created_at', \Carbon\Carbon::now()->month)->get();
        // var_dump($logs->toArray());
        // die;


        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'order_row_id' => 'required|numeric|exists:orders,id',
                    'rider_assign_order_id' => 'required|exists:rider_assign_orders,id',
                    'otp' => 'required',
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

            DB::beginTransaction();
            $order = Order::where('id', '=', $request->order_row_id)->select('deliver_otp')->first();
            if (empty($order)) {
                return response()->json([
                    'status' => false,
                    'error'  => 'No Order found'

                ], 401);
            }
            if ($order->deliver_otp == $request->otp) {
                $orderdata = Order::where('id', '=', $request->order_row_id);
                $orderdata->update(['order_status' => 'completed', 'delivered_time' => mysql_date_time()]);
                $riderAssing = RiderAssignOrders::where('id', '=', $request->rider_assign_order_id);
                $riderAssing->update(['action' => '3']);
                \App\Models\OrderActionLogs::create(['orderid'=> $request->order_row_id,'action' => 'Rider Deliverd Order' ,'rider_id'=>$request->user_id]);
                $earningData = $riderAssing->select('earning', 'rider_id')->first();
                $this->genarateIncentive($earningData->rider_id, $request->rider_assign_order_id);
                $user = \App\Models\User::where('id', '=', $orderdata->first()->user_id)->select('fcm_token', 'referby')->first();
                $totalOrders = Order::where('user_id', '=', $orderdata->first()->user_id)->where('order_status', '=', 'completed')->count();
                if ($user->referby != '' && $totalOrders == 1) {
                    $refUser = \App\Models\User::where('id', '=', $user->referby)->select('id', \DB::raw('IFNULL(wallet_amount,0) as wallet_amount'))->first();
                    if (!empty($refUser)) {
                        $amount = \App\Models\AdminMasters::where('id', '=', 1)->select('refer_amount')->first();
                        \App\Models\User::where('id', '=', $refUser->id)->update(['wallet_amount' => $refUser->wallet_amount + $amount->refer_amount]);
                        $UserWalletTransactions = new \App\Models\UserWalletTransactions;
                        $UserWalletTransactions->user_id = $refUser->id;
                        $UserWalletTransactions->amount = $amount->refer_amount;
                        $UserWalletTransactions->narration = "Referral Bonus";
                        $UserWalletTransactions->save();
                    }
                }
                if ($user->fcm_token != '') {
                    //sendUserAppNotification('Order Delivered Successfully',"Your Order has been Delivered Successfully",$user->fcm_token,array('type'=>5,'data'=>array('data'=>array())));
                    $data = orderDetailForUser($request->order_row_id);
                    \App\Jobs\UserOrderNotification::dispatch('Order delivered', 'Enjoy your Meal :)', $user->fcm_token, 5, $data);
                }

                //
                DB::commit();
                return response()->json([
                    'status'   => true,
                    'message'  => 'Status Updated Successfully',
                    'earning'  => $earningData->earning
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error'  => 'Invalid OTP'

                ], 401);
            }
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    function genarateIncentive($riderId, $rider_assign_order_id)
    {

        $rider = \App\Models\Deliver_boy::where('id', '=', $riderId)->select('ratings')->first();
        $incentive = 0;
        if ($rider->ratings >= 4.3 && $rider->ratings <= 4.7) {
            $now = \Carbon\Carbon::now();
            $deliverySetting =  \App\Models\DeliveryboySetting::first();
            $thisWeekOrders = RiderAssignOrders::whereBetween("created_at", [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])->where('action', '=', '3')->where('rider_id', '=', $riderId)->count();
            $thisWeekRejectedOrders = RiderAssignOrders::whereBetween("created_at", [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])->where('action', '=', '2')->where('rider_id', '=', $riderId)->count();
            if ($thisWeekRejectedOrders < $deliverySetting->no_of_order_cancel) {
                if ($thisWeekOrders >= 50 && $thisWeekOrders < 75) {
                    $incentive = $deliverySetting->fifteen_order_incentive_4;
                } elseif ($thisWeekOrders >= 75 && $thisWeekOrders < 100) {
                    $incentive = $deliverySetting->sentientfive_order_incentive_4;
                } elseif ($thisWeekOrders >= 100) {
                    $incentive = $deliverySetting->hundred_order_incentive_4;
                }
            }
        } elseif ($rider->ratings >= 4.8 && $rider->ratings <= 5.0) {
            $now = \Carbon\Carbon::now();
            $deliverySetting =  \App\Models\DeliveryboySetting::first();
            $thisWeekOrders = RiderAssignOrders::whereBetween("created_at", [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])->where('action', '=', '3')->where('rider_id', '=', $riderId)->count();
            $thisWeekRejectedOrders = RiderAssignOrders::whereBetween("created_at", [$now->startOfWeek()->format('Y-m-d'), $now->endOfWeek()->format('Y-m-d')])->where('action', '=', '2')->where('rider_id', '=', $riderId)->count();
            if ($thisWeekRejectedOrders < $deliverySetting->no_of_order_cancel) {
                if ($thisWeekOrders >= 50 && $thisWeekOrders < 75) {
                    $incentive = $deliverySetting->fifteen_order_incentive_5;
                } elseif ($thisWeekOrders >= 75 && $thisWeekOrders < 100) {
                    $incentive = $deliverySetting->sentientfive_order_incentive_5;
                } elseif ($thisWeekOrders >= 100) {
                    $incentive = $deliverySetting->hundred_order_incentive_5;
                }
            }
        }


        $riderOrder = RiderAssignOrders::where(['id' => $rider_assign_order_id])->first();
        $net_receivables = $riderOrder->earning;
        $current_start_date = \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');
        $current_end_date = \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d');
        $statementData = RiderOrderStatement::where(['rider_id' => $riderOrder->rider_id, 'start_date' => $current_start_date, 'end_date' => $current_end_date])->first();
        if ($statementData) {
            $total = ($statementData->paid_amount + $net_receivables);
            $updateData = ([
                'paid_amount' => $total
            ]);
            RiderOrderStatement::where(['rider_id' => $riderOrder->rider_id, 'start_date' => $current_start_date, 'end_date' => $current_end_date])->first()->update($updateData);
        } else {
            $createData = array(
                'rider_id' => $riderOrder->rider_id,
                'paid_amount' => $net_receivables,
                'start_date' => $current_start_date,
                'end_date' => $current_end_date
            );

            RiderOrderStatement::create($createData);
        }

        if ($incentive > 0) {
            $RiderIncentives = new \App\Models\RiderIncentives;
            $RiderIncentives->rider_id = $riderId;
            $RiderIncentives->amount     = $incentive;
            $RiderIncentives->save();
        }
    }

    public function change_status(Request $request)
    {
        // echo 'hello';die;
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
            $old = Deliver_boy::where('id', '=', $request->user_id)->select('is_online', 'status')->first();
            if ($old->status == '0') {
                return response()->json(['status' => false, 'error'  => 'You Can Not Change Your Status'], 500);
            }
            if ($old->is_online != $request->status) {
                Deliver_boy::where('id', '=', $request->user_id)->update(['is_online' => $request->status]);
                $DriverWorkingLogs = new DriverWorkingLogs;
                $DriverWorkingLogs->rider_id = $request->user_id;
                $DriverWorkingLogs->status = $request->status;
                $DriverWorkingLogs->saveOrFail();

                $workingLogsData_old = DriverWorkingLogs::where(['rider_id' => $request->user_id, 'status' => '1', 'working_hr' => 0])->first();

                $workingLogsData_new = DriverWorkingLogs::where(['rider_id' => $request->user_id, 'status' => '0', 'working_hr' => 0])->first();

                if ($workingLogsData_new) {
                    $day1 = $workingLogsData_old->created_at;
                    $day_1 = strtotime($day1);
                    $day2 = $workingLogsData_new->created_at;
                    $day_2 = strtotime($day2);
                    $hr = ($day_2 - $day_1);

                    DriverWorkingLogs::where(['rider_id' => $request->user_id, 'working_hr' => 0])->update(['working_hr' => $hr]);
                }

                $today_date = date('Y-m-d');


                $driver_total_working_perday = Driver_total_working_perday::where(['rider_id' => $request->user_id, 'current_date' => $today_date])->first();
                if ($driver_total_working_perday) {
                    if (isset($hr)) {
                        Driver_total_working_perday::where(['rider_id' => $request->user_id, 'current_date' => $today_date])->update(['total_hr' => ($driver_total_working_perday->total_hr + $hr)]);
                    }
                } else {
                    if (isset($hr)) {
                        Driver_total_working_perday::create(['rider_id' => $request->user_id, 'total_hr' => $hr, 'current_date' => $today_date]);
                    }
                }
            }


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
            $RiderAssignOrders = new RiderAssignOrders;
            $rejectedOrders = new RiderAssignOrders;
            $RiderIncentives = new \App\Models\RiderIncentives;
            $RiderReviewRatings = new \App\Models\RiderReviewRatings;
            $Driver_total_working_perday = new \App\Models\Driver_total_working_perday;
            if ($request->report_for == 'today') {
                $RiderAssignOrders = $RiderAssignOrders->whereDate('created_at', Carbon::now());
                $rejectedOrders = $rejectedOrders->whereDate('created_at', Carbon::now());
                $RiderIncentives = $RiderIncentives->whereDate('created_at', Carbon::now());
                $RiderReviewRatings = $RiderReviewRatings->whereDate('created_at', Carbon::now());
                $Driver_total_working_perday = $Driver_total_working_perday->whereDate('current_date', Carbon::now());
            }
            if ($request->report_for == 'last_week') {
                $RiderAssignOrders = $RiderAssignOrders->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $rejectedOrders = $rejectedOrders->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $RiderIncentives = $RiderIncentives->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $RiderReviewRatings = $RiderReviewRatings->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $Driver_total_working_perday = $Driver_total_working_perday->whereBetween(
                    'current_date',
                    [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
            }
            if ($request->report_for == 'last_four_week') {
                $RiderAssignOrders = $RiderAssignOrders->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek(4)->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $rejectedOrders = $rejectedOrders->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek(4)->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $RiderIncentives = $RiderIncentives->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek(4)->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $RiderReviewRatings = $RiderReviewRatings->whereBetween(
                    'created_at',
                    [Carbon::now()->subWeek(4)->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
                $Driver_total_working_perday = $Driver_total_working_perday->whereBetween(
                    'current_date',
                    [Carbon::now()->subWeek(4)->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]
                );
            }
            $earning_and_orders = $RiderAssignOrders->where(['action' => '3', 'rider_id' => $request->user_id])->select(\DB::raw('IFNULL(SUM(earning),0) as earning'), \DB::raw('IFNULL(COUNT(id),0) as order_count'))->first();
            $rejectedOrders     = $rejectedOrders->where(['action' => '2', 'rider_id' => $request->user_id])->select(\DB::raw('IFNULL(COUNT(id),0) as rejectOrders'))->first();
            $RiderIncentives    = $RiderIncentives->where(['rider_id' => $request->user_id])->select(\DB::raw('IFNULL(SUM(amount),0) as amount'))->first();
            $RiderReviewRatings    = $RiderReviewRatings->where(['rider_id' => $request->user_id])->select(\DB::raw('IFNULL(AVG(rating),0.0) as rating'))->first();
            $Driver_total_working_perday    = $Driver_total_working_perday->where(['rider_id' => $request->user_id])->select(\DB::raw('IFNULL(SUM(total_hr),0) as total_working_seconds'))->first();
            //$workingHours = calculateWorkingHours($request->user_id,Carbon::now(),Carbon::now());
            //[now()->subdays(30), now()->subday()]
            if ($Driver_total_working_perday->total_working_seconds < 0) {
                $init = 0;
            } else {
                $init = $Driver_total_working_perday->total_working_seconds;
            }

            $day = floor($init / 86400);
            $hours = floor(($init - ($day * 86400)) / 3600);
            $minutes = floor(($init / 60) % 60);
            $time = date('H:i', strtotime($hours . '.' . $minutes));

            $response = ['earning' => $earning_and_orders->earning, 'order_delivered' => $earning_and_orders->order_count, 'rejected_orders' => $rejectedOrders->rejectOrders, 'incentive' => $RiderIncentives->amount, 'rating' => round($RiderReviewRatings->rating, 2), 'workingHours' => $time];
            //
            $chart = [];
            if ($request->report_for == 'today') {
                $date = Carbon::now()->startOfWeek();;
                for ($i = 0; $i < 7; $i++) {
                    $dayData = RiderAssignOrders::whereDate('created_at', $date)->where('rider_id', '=', $request->user_id)->where('action', '=', '3')->select(\DB::raw('IFNULL(SUM(earning),0) as earning'))->first();
                    $dayData->day = date('D', strtotime($date));
                    $dayData->date = date('d-m-Y', strtotime($date));
                    $date = $date->addDays(1);
                    $chart[] = $dayData;
                }
            }

            $profile = Deliver_boy::where('id', '=', $request->user_id)->select('name', 'email', 'username', 'mobile', 'is_online', \DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            return response()->json([
                'status'   => true,
                'message'  => 'data Get Successfully',
                'reports' => $response,
                'chart' => $chart,
                'profile' => $profile

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

    public function orderEarnings(Request $request)
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

            $earning = \App\Models\RiderAssignOrders::where(['rider_id' => $request->user_id])->where('action','=','3')->select(\DB::raw('IFNULL(SUM(earning),0) as earning'))->first();
            $incentive = \App\Models\RiderIncentives::where(['rider_id' => $request->user_id])->select(\DB::raw('IFNULL(SUM(amount),0) as amount'))->first();
            $RiderTransactions = \App\Models\RiderTransactions::where(['rider_id' => $request->user_id])->select('*', \DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y %h:%i %p') as date"))->get();
            $profile = Deliver_boy::where('id', '=', $request->user_id)->select('name', 'email', 'username', 'mobile', 'is_online', \DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();
            $response = ['earning' => $earning->earning, 'incentive' => $incentive->amount, 'transaction' => $RiderTransactions];
            return response()->json([
                'status'   => true,
                'message'  => 'data Get Successfully',
                'reports' => $response,
                'profile' => $profile

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    public function incentiveHistory(Request $request)
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
            $incentive = \App\Models\RiderIncentives::where(['rider_id' => $request->user_id])->select(\DB::raw("DATE_FORMAT(created_at, '%d %b %Y') as date"), 'amount')->orderBy('id', 'desc')->get();
            $profile = Deliver_boy::where('id', '=', $request->user_id)->select('name', 'email', 'username', 'mobile', 'is_online', \DB::raw('CONCAT("' . asset('dliver-boy') . '/", image) AS image'))->first();

            return response()->json([
                'status'   => true,
                'message'  => 'data Get Successfully',
                'reports' => $incentive,
                'profile' => $profile

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    public function logInHistory(Request $request)
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
            $period = \Carbon\CarbonPeriod::create(Carbon::now()->subDays(6), Carbon::now());
            $response = [];

            foreach ($period as $Key => $value) {

                $res = \App\Models\Driver_total_working_perday::where('current_date', '=', Carbon::parse($value)->format('Y-m-d'))->where('rider_id', '=', $request->user_id)->select(\DB::Raw('IFNULL( `total_hr` , 0 ) as totalHour'))->first();
                if ($res) {
                    if ($res->totalHour < 0) {
                        $init = 0;
                    } else {
                        $init = $res->totalHour;
                    }

                    $day = floor($init / 86400);
                    $hours = floor(($init - ($day * 86400)) / 3600);
                    $minutes = floor(($init / 60) % 60);
                    $time = date('H:i', strtotime($hours . '.' . $minutes));
                    $response[] = array('date' => Carbon::parse($value)->format('d-m-Y'), 'hour' => $time);
                } else {
                    $response[] = array('date' => Carbon::parse($value)->format('d-m-Y'), 'hour' => "0");
                }
            }
            return response()->json([
                'status'   => true,
                'message'  => 'data Get Successfully',
                'response' => $response

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
    function calculateWorkingHours($riderId, $from, $to)
    {
        $logs = \App\Models\DriverWorkingLogs::whereDate('created_at', Carbon::now())->orderBy('id', 'DESC')->get();
        if (!empty($logs)) {
            $hours = 0;
            foreach ($logs as $key => $value) {
                if ($value->status) {
                } else {
                }
            }
        } else {
            return 0;
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
            Deliver_boy::where('id', '=', $request->user_id)->update(['lat' => $request->lat, 'lng' => $request->lng]);

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
    public function checkRiderActive(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_id' => 'required|numeric|exists:deliver_boy,id',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $status = Deliver_boy::where('id', '=', $request->user_id)->select(\DB::raw('IFNULL(status,0) as rider_status'))->first();

            return response()->json([
                'status'   => true,
                'rider_status'  => $status->rider_status

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
