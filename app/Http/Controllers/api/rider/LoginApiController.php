<?php

namespace App\Http\Controllers\api\rider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Deliver_boy;
use App\Models\AdminMasters;
use App\Models\Mobileotp;
use Validator;

class LoginApiController extends Controller
{
    public function login_send_otp(Request $request)
    {
        try {
           
            if (Deliver_boy::where(['mobile' => $request->mobile])->orwhere(['ridercode' => $request->ridercode])->exists()) {
                $mob = Deliver_boy::where('mobile', '=', $request->mobile)->orwhere('ridercode', '=', $request->ridercode)->select('mobile')->first();
                //var_dump($mob);die;
                $otp = $this->otp_generate($request->mob);
                return response()->json([
                    'status' => true,
                    'message'=>'Otp Send Successfully',
                    'otp'=>$otp
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error'=>'Mobile Number Not Found'

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
            $insertedOtp = Mobileotp::where(['mobile' =>$request->mobile])->first();
            if($insertedOtp->otp == $request->otp){
                Mobileotp::where(['mobile' =>$request->mobile])->update(['status' =>'1']);
                $user = Deliver_boy::where('mobile','=',$request->mobile)->select('id','name','mobile','email')->first();
                $token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message'=>'User Login Successfully',
                    'token'=>array('name' =>$user->name,'email'=>$user->email,'mobile'=>$user->mobile,'user_id'=>$user->id,'token'=>$token)
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
}
