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
                $coupon =  \App\Models\Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('id','name','discount_type','coupon_valid_x_user','discription')->get();
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
                $date = today()->format('Y-m-d');
                $coupon =  \App\Models\Coupon::where('id', '=', $request->id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('name','id','from','to','code','discount_type','discount','maxim_dis_amount','minimum_order_amount','promo_redeem_count','promocode_use','coupon_valid_x_user','discription')->get();
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
            $vendor_coupon =  \App\Models\Coupon::where('vendor_id', '=', $request->vendor_id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('name','discount_type','coupon_valid_x_user','discription')->get();
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
    public function couponApply(Request $request){
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
            $vendor_coupon =  \App\Models\Coupon::where('id', '=', $request->id)->where('status', '=',1)->where('from', '<=',$date)->where('to', '>=',$date)->select('name','discount_type','coupon_valid_x_user','discription','promocode_use','promo_redeem_count','from')->get();
            $coupon =  \App\Models\CouponHistory::where('coupon_id', '=', $request->id)->get();
            $wordCount = $coupon->count();
           
            foreach($vendor_coupon as $k){
                $userid =  \App\Models\CouponHistory::where('user_Id', '=', $request->user_Id)->where('code', '=', $k['code'])->get();
                $coutuser = $userid->count();
                if($k['coupon_valid_x_user'] == $wordCount){
                    return response()->json([
                        'status' => false,
                        'message'=>'Coupon is validity exp',
                    ], 401);   
                }else{
                    
                    $day = 1;
                    $week = 2;
                    $month = 3;
                    $lifetime = 4;
                    //echo $k['promocode_use'];die;
                    if($k['promocode_use'] == $day){
                       
                        $date = today()->format('Y-m-d');
                       $user  = \App\Models\CouponHistory::where('coupon_id', '=', $request->id)->where('user_Id', '=', $request->user_Id)->get();
                       $cont = $user->count();
                       if($k['promo_redeem_count'] == $cont){
                            return response()->json([
                                'status' => false,
                                'message'=>'You are allready use this coupon',
                                'response'=>$cont
            
                            ], 401);
                       }else{
                            return response()->json([
                                'status' => true,
                                'message'=>'Data Get Successfully',
                                'response'=>$vendor_coupon
            
                            ], 200);
                       }
                            
                    }elseif($k['promocode_use'] == $week){
                        $d1 = $k['from'];
                        $d2 = $date = today()->format('Y-m-d');
                        $interval = $d1->diff($d2);
                        $days = $interval->format('%a');
             
                       // $days = $interval->format('%a');
                        if($interval == 14){
                            return response()->json([
                                'status' => false,
                                'message'=>'You are allready use this coupon',
                                'response'=>$cont
            
                            ], 401);
                        }else{
                            return response()->json([
                                'status' => true,
                                'message'=>'Data Get Successfully',
                                'response'=>$vendor_coupon
            
                            ], 200);
                        }

                    }elseif($k['promocode_use'] == $month){
                        $d1 = $k['from'];
                        $d2 = $date = today()->format('Y-m-d');
                        $interval = $d1->diffInDays($d2);
                       // $days = $interval->format('%a');
                        if($interval == 30){
                            return response()->json([
                                'status' => false,
                                'message'=>'You are allready use this coupon',
                                'response'=>$cont
            
                            ], 401);
                        }else{
                            return response()->json([
                                'status' => true,
                                'message'=>'Data Get Successfully',
                                'response'=>$vendor_coupon
            
                            ], 200);
                        }
                    }elseif($k['promocode_use'] == $lifetime){
                        return response()->json([
                            'status' => true,
                            'message'=>'Data Get Successfully',
                            'response'=>$vendor_coupon
        
                        ], 200);
                    }
                    
                }
                
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}