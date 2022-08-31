<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Mobileotp;
use Validator;

class LoginApiController extends Controller
{
    public function register_send_otp(Request $request)
    {
        
        try 
        {
            $validateUser = Validator::make($request->all(), 
            [
                'mobile_number' => 'required|numeric|digits:10'
            ]);

            if($validateUser->fails()){
                $error = $validateUser->errors();
                
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            if(User::where('mobile_number', '=', $request->mobile_number)->exists()){
                return response()->json([
                    'status' => false,
                    'error'=>'Already Have Regiseter this Number'
                ], 401);
            }else{
                $otp = $this->otp_generate($request->mobile_number);
                return response()->json([
                    'status' => true,
                    'message'=>'otp Generated',
                    'mobile_number'=>$request->mobile_number,
                    'otp'=>$otp,
                ], 200);
            }
            
           

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function register_verify_otp(Request $request)
    {
        
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'mobile_number' => 'required|numeric|digits:10',
                'otp' => 'required|numeric|digits:4',
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $insertedOtp = Mobileotp::where(['mobile_number' =>$request->mobile_number])->first();
            if($insertedOtp->otp == $request->otp){
                Mobileotp::where(['mobile_number' =>$request->mobile_number])->update(['status' =>'1']);
                return response()->json([
                    'status' => true,
                    'message'=>'Verified',
                    'mobile_number'=>$request->mobile_number
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
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function register_user(Type $var = null)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'mobile_number' => 'required|numeric|digits:10',
                'name' => 'required|max:20',
                "email" => "required| Gaur",
                "email" => "pratyushgaur07@gmail.com",
                "email" => "pratyushgaur07@gmail.com",
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
    }
    function otp_generate($mobile_number){
        $Otp_no = random_int(1000, 9999);
        if (Mobileotp::where('mobile_number', '=', $mobile_number)->exists()) {
            Mobileotp::where('mobile_number', '=', $mobile_number)->update(['otp'=>$Otp_no,'status' =>'0']);
        } else {
            Mobileotp::insert([
                    'mobile_number' =>$mobile_number,
                    'otp' =>$Otp_no,
            ]);
        }
        return $Otp_no;
        
    }
}
