<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\CouponHistory;

// this is vikas testing
class CouponController extends Controller
{
    public function getCoupon(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'vendor_id' => 'required|numeric'
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()

                    ], 401);
                }
                $date = today()->format('Y-m-d');
                $coupon =  Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('*')->get();
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$coupon

                ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function couponDetailPage(Request $request){
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'id' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
                //$date = today()->format('Y-m-d');
                $date = mysql_date_time();
                $coupon =  Coupon::where('id', '=', $request->id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('name','id','from','to','code','discount_type','discount','maxim_dis_amount','minimum_order_amount','promo_redeem_count','promocode_use','coupon_valid_x_user','description')->first();
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$coupon

                ], 200);
            } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function getPromoCode(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'vendor_id' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            //$date = today()->format('Y-m-d');
            $date = today()->format('m/d/Y');
            $vendor_coupon =  Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)
                ->where('from', '<=',mysql_date_time($date))->where('to', '>=',mysql_date_time($date))
                ->select('name','discount_type','coupon_valid_x_user','description','id')->get();
          //  $admin_coupon =  \App\Models\Coupon::where('create_by', '=', 'admin')->where('status', '=',1)->where('to', '>',$date)->select('name','discount_type','coupon_valid_x_user','description')->get();
            $admin_coupon = Coupon::where(['create_by' => 'admin'])
                ->where('from', '<=',mysql_date_time($date))->where('to', '>=',mysql_date_time($date))
                ->select('name','code','discount_type','coupon_valid_x_user','description',\DB::raw('CONCAT("'.asset('coupon-admin').'/", image) AS image'),'id')
                ->get();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>array('vendor'=>$vendor_coupon,'admin'=>$admin_coupon)

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function couponApply(Request $request){
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'code' => 'required'
                ]

            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            date_default_timezone_set('Asia/Kolkata');
            //check code is valid or not
             $coupon =  Coupon::where('code','=',strtoupper($request->code));
             if($coupon->exists()){
                $coupon = $coupon->first();
                if(Carbon::now()->between(\Illuminate\Support\Carbon::createFromFormat('Y-m-d', mysql_date($coupon->from)),
                    \Illuminate\Support\Carbon::createFromFormat('Y-m-d', mysql_date($coupon->to))->addDay())){
                    // check coupon use Limit
                    if(CouponHistory::where('coupon_id','=',$coupon->id)->count() < $coupon->coupon_valid_x_user){
                        // check redom count

                        if($coupon->promocode_use != 4){
                            if($coupon->promocode_use == 1){
                                $count = CouponHistory::whereDate('created_at', '>=', Carbon::today()->format('Y-m-d'))->whereDate('created_at', '<=', today()->format('Y-m-d'))->where('user_Id','=',request()->user()->id)->where('coupon_id','=',$coupon->id)->count() ;
                                $msg = 'You Can Use This Coupon Only '.$coupon->promo_redeem_count.' times in a day';
                            }
                            if($coupon->promocode_use == 2){ // week
                                $count = CouponHistory::whereDate('created_at', '>=', Carbon::today()->subDays(7)->format('Y-m-d'))->whereDate('created_at', '<=', today()->format('Y-m-d'))->where('user_Id','=',request()->user()->id)->where('coupon_id','=',$coupon->id)->count() ;
                                $msg = 'You Can Use This Coupon Only '.$coupon->promo_redeem_count.' times in a Week';
                            }
                            if($coupon->promocode_use == 3){ // Month
                                $count = CouponHistory::whereDate('created_at', '>=', Carbon::today()->subDays(7)->format('Y-m-d'))->whereDate('created_at', '<=', today()->format('Y-m-d'))->where('user_Id','=',request()->user()->id)->where('coupon_id','=',$coupon->id)->count() ;
                                $msg = 'You Can Use This Coupon Only '.$coupon->promo_redeem_count.' times in a Month';
                            }
                            //check edom count qual to use
                            if($count >= $coupon->promo_redeem_count){
                                return response()->json([
                                    'status' => false,
                                    'error' => $msg

                                ], 401);
                            }

                        }
                        return response()->json([
                            'status' => true,
                            'message'=>'Data Get Successfully',
                            'response'=>$coupon

                        ], 200);
                    }else{
                        return response()->json([
                            'status' => false,
                            'error' => 'Coupon Use Limit is Full'

                        ], 401);
                    }
                }else{
                    return response()->json([
                        'status' => false,
                        'error' => 'Coupon Is Expired'

                    ], 401);
                }


             }else{
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid Coupon Code .Try Onther One'

                ], 401);
             }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage(),
                'errors' => $th->getTrace()
            ], 500);
        }
    }
}
