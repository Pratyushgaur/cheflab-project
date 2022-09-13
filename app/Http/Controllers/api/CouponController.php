<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
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
                $data = \App\Models\Coupon::select('name',\DB::raw('CONCAT("'.asset('coupon-vendor').'/", image) AS image'),'code','discription','from','id','to');
                $data = $data->whereDate('from', '>', Carbon::now())->whereDate('to', '<', Carbon::now());
                
                $data = $data->get();
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$data
    
                ], 200);
            } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}