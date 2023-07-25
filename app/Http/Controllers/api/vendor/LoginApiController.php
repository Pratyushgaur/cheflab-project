<?php

namespace App\Http\Controllers\api\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\Http;
use Auth;
class LoginApiController extends Controller
{
    function index (Request $request ){
        
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                $error = $validateUser->errors();

                return response()->json([
                    'status' => false,
                    'error' => $validateUser->errors()->all()

                ], 401);
            }
            if(Auth::guard('vendor')->attempt(array('email' =>$request->email,'password' => $request->password))){
                 $vendor = \App\Models\Vendors::find(Auth::guard('vendor')->user()->id);
                 $token = $vendor->createToken('cheflab-vendor-app-token')->plainTextToken;
                 return response()->json([
                    'status' => true,
                    'message' => "Successfully Login",
                    'vendor_id' => $vendor->id,
                    'name' => $vendor->name,
                    'token' => $token

                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid Email or Password'
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
