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
                'error' => $th->getMessage()
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
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function register_user(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                //'mobile_number' => 'required|numeric|digits:10|unique:user.mobile_number',
                'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number',
                'name' => 'required|max:20',
                'email' => 'required|email|unique:users,email',
                //'email' => 'required|email|unique:user.email|max:50',
                //'alternative_mobile' => 'numeric|digits:10'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            //check otp is verified 
            if(Mobileotp::where(['mobile_number' =>$request->mobile_number,'status' =>'1'])->exists()){
                
                $user = new User;
                if($request->referralcode != ''){//
                    
                      $referralUser = User::where('referralCode','=',$request->referralcode);
                    if($referralUser->exists()){
                        $r_user = $referralUser->first();
                        $user->referby =$r_user->id;
                    }else{
                        return response()->json([
                            'status' => false,
                            'error'=>'Invalid Referral Code'
                            
                        ], 401);
                    }
                }
                
                
                $user->name =$request->name;
                $user->email =$request->email;
                $user->mobile_number =$request->mobile_number;
                $user->alternative_number =$request->alternative_mobile;
                $user->referralCode = $this->generateReferralCode($request->name);
                $user->save();

                $token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message'=>'User Registration Successfully',
                    'token'=>$token
                ], 200);

            }else{
                return response()->json([
                    'status' => false,
                    'error'=>'System Error'
                    
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
        

    }

    public function login_send_otp(Request $request)
    {
        try {
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
            if (User::where(['mobile_number' => $request->mobile_number])->exists()) {
                $otp = $this->otp_generate($request->mobile_number);
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
    public function login_verify_otp(Request $request)
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
                $user = User::where('mobile_number','=',$request->mobile_number)->select('id','name')->first();
                $token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message'=>'User Login Successfully',
                    'token'=>$token
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
    function getData(Request $request){
        return $request->user();
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
    public function generateReferralCode($name)
    {
        $name = str_replace(' ', '', $name);
        $name = preg_replace('/\s+/', '', $name);
        $name = strtoupper($name);
        $code = $name.rand(1000,9999);
        if (User::where('referralCode','=',$code)->exists()) {
            $exit = false;
            $code = $name.rand(1000,9999);
            while($exit == false){
                
                if(User::where('referralCode','=',$code)->exists()){
                    $code = $name.rand(1000,9999);
                }else{
                    $exit = true;
                }
                
            }
            return $code;
        } else {
            return $code;
        }
        
        
    }
}
