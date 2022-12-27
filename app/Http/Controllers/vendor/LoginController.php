<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use Hash;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if(Auth::guard('vendor')->attempt(array('email' =>$request->email,'password' => $request->password))){
            
            if ($request->remember === null) {
                setcookie('login_email', $request->email, 100);
                setcookie('login_password', $request->password, 100);
            } else {
                setcookie('login_email', $request->email, time() + 60 * 60 * 24 * 10);
                setcookie('login_password', $request->password, time() + 60 * 60 * 24 * 10);
            }
            $request->session()->put([
                '*$%&%*id**$%#' => Auth::guard('vendor')->user()->id,
            ]);
            
            if ($request->session()->has('*$%&%*id**$%#')) {
                
                if (Auth::guard('vendor')->user()->vendor_type == 'restaurant') {
                   return redirect()->route('restaurant.dashboard')->with('message', 'Successfully Logged In!');
                } elseif(Auth::guard('vendor')->user()->vendor_type == 'chef') {
                    
                    return redirect()->route('chef.dashboard')->with('message', 'Successfully Logged In!');
                }
                
                //return redirect('admin/dashbord-admin')->with('message', 'Successfully Logged In!');
            } else {
                  
                return \Redirect::back()->withErrors(['error' => 'You have entered wrong credentials.. Please try again...']);
            }
            
            
        }else{
            return \Redirect::back()->with('error', 'You have Provide Wrong Credentials');   
        }

    }   

    public function checkEmailVendor(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'email'    => 'required|exists:vendors,email'
            ],
            [
                "email.exists" =>'We Dont Have Registered This Email',
                "email.required" =>'Email Required for Recover Password',
            ]
        
        );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()[0]], 200);
            }
            
            $user =  \App\Models\Vendors::where('email','=',$request->email)->first();
            if(!empty($user)){
                $otp = rand(1000,9999);
                \App\Models\Vendors::where('id','=',$user->id)->update(['password_change_otp'=>$otp]);
                return response()->json([
                    'status' => true
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'error'  => 'No User Found'
                ], 200);
            }
            return response()->json($user);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 200);
        }
    }
    public function verify_otp(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'email'    => 'required|exists:vendors,email',
                'otp'    => 'required'
            ],
            [
                "email.exists" =>'We Dont Have Registered This Email',
                "email.required" =>'Email Required for Recover Password',
            ]
        
        );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()[0]], 200);
            }
            
            $user =  \App\Models\Vendors::where('email','=',$request->email)->first();
            if(!empty($user)){
                if($user->password_change_otp == $request->otp){
                    return response()->json(['status' => true], 200);
                }else{
                    return response()->json(['status' => false, 'error' => 'Invalid OTP Enter'], 200);
                }
            
            }else{
                return response()->json([
                    'status' => false,
                    'error'  => 'No User Found'
                ], 200);
            }
            return response()->json($user);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 200);
        }
    }
    public function change_new_pass(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'email'    => 'required|exists:vendors,email',
                'new_pass'    => 'required'
            ],
            [
                "email.exists" =>'We Dont Have Registered This Email',
                "email.required" =>'Email Required for Recover Password',
            ]
        
        );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()[0]], 200);
            }
            
            $user =  \App\Models\Vendors::where('email','=',$request->email)->first();
            if(!empty($user)){
                \App\Models\Vendors::where('id','=',$user->id)->update(['password'=>Hash::make($request->new_pass)]);
                return response()->json(['status' => true], 200);
                
            }else{
                return response()->json([
                    'status' => false,
                    'error'  => 'No User Found'
                ], 200);
            }
            return response()->json($user);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 200);
        }
    }
    
}
