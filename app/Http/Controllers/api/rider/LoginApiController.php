<?php

namespace App\Http\Controllers\api\rider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Deliver_boy;
use App\Models\AdminMasters;
use App\Models\RiderMobileOtp;
use Validator;

class LoginApiController extends Controller
{
    public function login_send_otp(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'username' => 'required|numeric|digits:10'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            $deliveryBoy =  Deliver_boy::where(['mobile' => $request->username])->orWhere('username','=',$request->username);
            if ($deliveryBoy->exists()) {
                $data =  $deliveryBoy->first();
                $otp = $this->otp_generate($data->mobile);
                return response()->json([
                    'status' => true,
                    'message'=>'Otp Send Successfully',
                    'otp'=>$otp,
                    'mobile' =>$data->mobile
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error'=>'User Not Found'

                ], 401);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    function otp_generate($mobile){
        $Otp_no = random_int(1000, 9999);
        if (Mobileotp::where('mobile', '=', $mobile)->exists()) {
            Mobileotp::where('mobile', '=', $mobile)->update(['otp'=>$Otp_no,'status' =>'0']);
        } else {
            Mobileotp::insert([
                    'mobile' =>$mobile,
                    'otp' =>$Otp_no,
            ]);
        }
        return $Otp_no;

    }
    public function login_verify_otp(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'mobile' => 'required|numeric|digits:10',
                'otp' => 'required|numeric|digits:4',
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            $insertedOtp = RiderMobileOtp::where(['mobile_number' =>$request->mobile_number])->first();
            if($insertedOtp->otp == $request->otp){
                RiderMobileOtp::where(['mobile_number' =>$request->mobile_number])->update(['status' =>'1']);
                $user = Deliver_boy::where('mobile','=',$request->mobile_number)->select('id','name','mobile','email','type')->first();
                ///$token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message'=>'User Login Successfully',
                    'user'=>array('name' =>$user->name,'email'=>$user->email,'mobile'=>$user->mobile,'user_id'=>$user->id,'type'=>$user->type)
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'error'=>'Invalid OTP',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    
    }
    
    public function getDistance()
    {
        //return round(point2point_distance(24.466551,74.884048,24.464050432928225,74.86669534531778,'K'),2);
        //24.464050432928225, 74.86669534531778
    }
    public function getDistance2()
    {
        //return GetDrivingDistance(22.7533,75.8937,22.6977, 75.8333);
        return userToVendorDeliveryCharge(22.7533,75.8937,22.6977, 75.8333);
        //24.464050432928225, 74.86669534531778
        //24.54764088976084, 74.83816149442208
        //24.258000662713282, 74.93817489405903
    }
}
