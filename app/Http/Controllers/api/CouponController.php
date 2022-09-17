<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
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
                $coupon =  \App\Models\Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)->where('to', '>',$date)->select('name','discount_type','coupon_valid_x_user','discription')->first();
                $wordlist =  \App\Models\CouponHistory::where('code', '=', $coupon->code)->get();
                $wordCount = $wordlist->count();
                if($coupon->coupon_valid_x_user == $wordCount){
                    return response()->json([
                        'status' => false,
                        'message'=>'Coupon is exp',
            

                    ], 401);   
                }else{
                    return response()->json([
                        'status' => true,
                        'message'=>'Data Get Successfully',
                        'response'=>$coupon

                    ], 200);
                }
                      
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
                $date = today()->format('Y-m-d');
                $coupon =  \App\Models\Coupon::where('id', '=', $request->id)->where('status', '=',1)->where('to', '>',$date)->select('name','id','from','to','code','discount_type','discount','maxim_dis_amount','minimum_order_amount','promo_redeem_count','promocode_use','coupon_valid_x_user','discription')->first();
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
            $date = today()->format('Y-m-d');
            $vendor_coupon =  \App\Models\Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)->where('to', '>',$date)->select('name','discount_type','coupon_valid_x_user','discription')->first();
          //  $admin_coupon =  \App\Models\Coupon::where('create_by', '=', 'admin')->where('status', '=',1)->where('to', '>',$date)->select('name','discount_type','coupon_valid_x_user','discription')->get();
            $admin_coupon = \App\Models\Coupon::where(['create_by' => 'admin'])->select('name','code','discount_type','coupon_valid_x_user','discription',\DB::raw('CONCAT("'.asset('coupon-admin').'/", image) AS image'))->get();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>$vendor_coupon, $admin_coupon 

            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}