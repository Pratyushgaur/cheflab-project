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

class LoginApiController extends Controller
{
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
}
