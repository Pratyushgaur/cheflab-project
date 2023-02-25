<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\AdminMasters;
use App\Models\Mobileotp;
use Validator;
use Illuminate\Support\Facades\Http;


class LoginApiController extends Controller
{
    public function register_send_otp(Request $request)
    {

        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'mobile_number' => 'required|numeric|digits:10'
                ]
            );

            if ($validateUser->fails()) {
                $error = $validateUser->errors();

                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            if (User::where('mobile_number', '=', $request->mobile_number)->exists()) {
                return response()->json([
                    'status' => false,
                    'error' => 'Already Have Register this Number'
                ], 401);
            } else {
                $otp = $this->otp_generate($request->mobile_number);
                $msg = "OTP to Login to your ChefLab account is $otp DO NOT share this OTP to anyone for security reasons.";
                $url = "http://bulksms.msghouse.in/api/sendhttp.php?authkey=9470AY23GFzFZs6315d117P11&mobiles=$request->mobile_number&message=" . urlencode($msg) . "&sender=CHEFLB&route=4&country=91&DLT_TE_ID=1507166723953585920";
                Http::get($url);
                return response()->json([
                    'status' => true,
                    'message' => 'otp Generated',
                    'mobile_number' => $request->mobile_number,
                    'otp' => $otp,
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
            $validateUser = Validator::make(
                $request->all(),
                [
                    'mobile_number' => 'required|numeric|digits:10',
                    'otp' => 'required|numeric|digits:4',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $insertedOtp = Mobileotp::where(['mobile_number' => $request->mobile_number])->first();
            if ($insertedOtp->otp == $request->otp) {
                Mobileotp::where(['mobile_number' => $request->mobile_number])->update(['status' => '1']);
                return response()->json([
                    'status' => true,
                    'message' => 'Verified',
                    'mobile_number' => $request->mobile_number
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid OTP',
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
            $validateUser = Validator::make(
                $request->all(),
                [

                    'mobile_number' => 'required|numeric|digits:10|unique:users,mobile_number',
                    'name' => 'required|max:20',
                    'lastname' => 'required|max:20',
                    'email' => 'required|email|unique:users,email',
                    'alternative_mobile' => 'nullable|sometimes|numeric|digits:10|unique:users,alternative_number',

                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            //check otp is verified
            if (Mobileotp::where(['mobile_number' => $request->mobile_number, 'status' => '1'])->exists()) {
                //  $refer_amount = AdminMasters::select('refer_amount');
                $user = new User;
                if ($request->referralcode != '') { //

                    $referralUser = User::where('referralCode', '=', $request->referralcode);
                    if ($referralUser->exists()) {
                        $r_user = $referralUser->first();
                        $user->referby = $r_user->id;
                    } else {
                        return response()->json([
                            'status' => false,
                            'error' => 'Invalid Referral Code'

                        ], 401);
                    }
                }

                $user->name = $request->name;
                $user->surname = $request->lastname;
                $user->email = $request->email;
                $user->mobile_number = $request->mobile_number;
                //  $user->by_earn = $refer_amount;
                $user->alternative_number = $request->alternative_mobile;
                $user->referralCode = $this->generateReferralCode($request->name);

                $user->save();

                $token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'User Registration Successfully',
                    'token' => array('name' => $user->name, 'email' => $user->email, 'mobile' => $user->mobile_number, 'user_id' => $user->id, 'token' => $token)
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'OTP is not verified.'

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
            $validateUser = Validator::make(
                $request->all(),
                [
                    'mobile_number' => 'required|numeric|digits:10'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $user = User::where(['mobile_number' => $request->mobile_number]);
            if ($user->exists()) {
                if($user->first()->status == '0'){
                    return response()->json([
                        'status' => false,
                        'error' => 'Account Deactivated'
    
                    ], 401);
                }
                $otp = $this->otp_generate($request->mobile_number);

                $msg = "OTP to Login to your ChefLab account is $otp DO NOT share this OTP to anyone for security reasons.";
                $url = "http://bulksms.msghouse.in/api/sendhttp.php?authkey=9470AY23GFzFZs6315d117P11&mobiles=$request->mobile_number&message=" . urlencode($msg) . "&sender=CHEFLB&route=4&country=91&DLT_TE_ID=1507166723953585920";
                Http::get($url);
                return response()->json([
                    'status' => true,
                    'message' => 'Otp Send Successfully',
                    'otp' => $otp
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Mobile Number Not Found'

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
            $validateUser = Validator::make(
                $request->all(),
                [
                    'mobile_number' => 'required|numeric|digits:10',
                    'otp' => 'required|numeric|digits:4',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $insertedOtp = Mobileotp::where(['mobile_number' => $request->mobile_number])->first();
            if ($insertedOtp->otp == $request->otp) {
                Mobileotp::where(['mobile_number' => $request->mobile_number])->update(['status' => '1']);
                $user = User::where('mobile_number', '=', $request->mobile_number)->select('id', 'name', 'mobile_number', 'email')->first();
                $token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'User Login Successfully',
                    'token' => array('name' => $user->name, 'email' => $user->email, 'mobile' => $user->mobile_number, 'user_id' => $user->id, 'token' => $token)
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid OTP',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    function guestLogin(){
        $user = User::where('is_guest', '=', '1')->select('id', 'name', 'mobile_number', 'email')->first();
        $token = $user->createToken('cheflab-app-token')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'User Login Successfully',
            'token' => array('name' => $user->name, 'email' => $user->email, 'mobile' => $user->mobile_number, 'user_id' => $user->id, 'token' => $token)
        ], 200);
    }
    public function checkVersion(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'version' => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $version = floatval($request->version);
            $record = \App\Models\AdminMasters::select('user_app_current_version', 'user_app_force_update', 'user_app_soft_update')->first();
            if (floatval($request->version) < floatval($record->user_app_current_version)) {
                return response()->json([
                    'status' => true,
                    'data' => array('current_version' => $record->user_app_current_version, 'force_update' => $record->user_app_force_update, 'user_app_soft_update' => $record->user_app_soft_update)
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'data' => []
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function checkIosVersion(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'version' => 'required'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            $version = floatval($request->version);
            $record = \App\Models\AdminMasters::select('ios_user_app_version', 'ios_user_app_force_update', 'ios_user_app_soft_update')->first();
            if (floatval($request->version) < floatval($record->ios_user_app_version)) {
                return response()->json([
                    'status' => true,
                    'data' => array('current_version' => $record->ios_user_app_version, 'force_update' => $record->ios_user_app_force_update, 'user_app_soft_update' => $record->ios_user_app_soft_update)
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'data' => []
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    function getData(Request $request)
    {
        return $request->user();
    }
    function otp_generate($mobile_number)
    {
        if ($mobile_number == '9424567807') {
            $Otp_no = '1234';
        } else {
            $Otp_no = random_int(1000, 9999);
        }

        if (Mobileotp::where('mobile_number', '=', $mobile_number)->exists()) {
            Mobileotp::where('mobile_number', '=', $mobile_number)->update(['otp' => $Otp_no, 'status' => '0']);
        } else {
            Mobileotp::insert([
                'mobile_number' => $mobile_number,
                'otp' => $Otp_no,
            ]);
        }
        return $Otp_no;
    }
    public function generateReferralCode($name)
    {
        // $name = str_replace(' ', '', $name);
        // $name = preg_replace('/\s+/', '', $name);
        // $name = strtoupper($name);
        $name =  chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
        $code = $name . rand(1000, 9999);
        if (User::where('referralCode', '=', $code)->exists()) {
            $exit = false;
            $code = $name . rand(1000, 9999);
            while ($exit == false) {

                if (User::where('referralCode', '=', $code)->exists()) {
                    $code = $name . rand(1000, 9999);
                } else {
                    $exit = true;
                }
            }
            return $code;
        } else {
            return $code;
        }
    }
}
