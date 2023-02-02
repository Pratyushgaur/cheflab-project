<?php

namespace App\Http\Controllers\api\rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deliver_boy;
use App\Models\RiderMobileOtp;
use Validator;
use Illuminate\Support\Facades\Http;

class LoginApiController extends Controller
{
    public function login_send_otp(Request $request)
    {

        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'username' => 'required|numeric|digits:10'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }



            if ($deliveryBoyData->status == 1) {
                $data =  $deliveryBoy->first();
                $otp = $this->otp_generate($data->mobile);
                $msg = "OTP to Login to your ChefLab Rider App is $otp DO NOT share this OTP to anyone for security reasons.";
                $url = "http://bulksms.msghouse.in/api/sendhttp.php?authkey=9470AY23GFzFZs6315d117P11&mobiles=$data->mobile&message=" . urlencode($msg) . "&sender=CHEFLB&route=4&country=91&DLT_TE_ID=1507167507835135096";
                Http::get($url);
                return response()->json([
                    'status' => true,
                    'message'=>'Otp Send Successfully',
                    'otp'=>$otp,
                    'mobile' =>$data->mobile
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'error'=>'Your Account is Inactive. cantact with admin to process'

                if ($deliveryBoyData->status == 1) {
                    $data =  $deliveryBoy->first();
                    $otp = $this->otp_generate($data->mobile);
                    return response()->json([
                        'status' => true,
                        'message' => 'Otp Send Successfully',
                        'otp' => $otp,
                        'mobile' => $data->mobile
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'error' => 'Your Account is Inactive. cantact with admin to process'

                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'User Not Found'

                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    function otp_generate($mobile)
    {
        $Otp_no = random_int(1000, 9999);
        if (RiderMobileOtp::where('mobile_number', '=', $mobile)->exists()) {
            RiderMobileOtp::where('mobile_number', '=', $mobile)->update(['otp' => $Otp_no, 'status' => '0']);
        } else {
            RiderMobileOtp::insert([
                'mobile_number' => $mobile,
                'otp' => $Otp_no,
            ]);
        }
        return $Otp_no;
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
            $insertedOtp = RiderMobileOtp::where(['mobile_number' => $request->mobile_number])->first();
            if ($insertedOtp->otp == $request->otp) {
                RiderMobileOtp::where(['mobile_number' => $request->mobile_number])->update(['status' => '1']);
                $user = Deliver_boy::where('mobile', '=', $request->mobile_number)->select('id', 'name', 'mobile', 'email', 'type')->first();
                ///$token = $user->createToken('cheflab-app-token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'User Login Successfully',
                    'user' => array('name' => $user->name, 'email' => $user->email, 'mobile' => $user->mobile, 'user_id' => $user->id, 'type' => $user->type)
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

    public function getDistance()
    {
        //return round(point2point_distance(24.466551,74.884048,24.464050432928225,74.86669534531778,'K'),2);
        //24.464050432928225, 74.86669534531778
    }

    public function getDistance2()
    {
        //return GetDrivingDistance(22.7533,75.8937,22.6977, 75.8333);
        return userToVendorDeliveryCharge(22.7533, 75.8937, 22.6977, 75.8333);
        //24.464050432928225, 74.86669534531778
        //24.54764088976084, 74.83816149442208
        //24.258000662713282, 74.93817489405903
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
            $record = \App\Models\AdminMasters::select('driver_app_current_version', 'driver_app_force_update', 'driver_app_soft_update')->first();
            if (floatval($request->version) < floatval($record->driver_app_current_version)) {
                return response()->json([
                    'status' => true,
                    'data' => array('current_version' => $record->driver_app_current_version, 'force_update' => $record->driver_app_force_update, 'user_app_soft_update' => $record->driver_app_soft_update)
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
}
