<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use Hash;
use App\Models\Vendors;
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
                $msg = "OTP to update your ChefLab vendor account password is $otp DO NOT share this OTP to anyone for security reasons.";  
                $url = "http://bulksms.msghouse.in/api/sendhttp.php?authkey=9470AY23GFzFZs6315d117P11&mobiles=$user->mobile&message=".urlencode($msg)."&sender=CHEFLB&route=4&country=91&DLT_TE_ID=1507167378318092499";
                \Http::get($url);
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

    public function vendorLogin(Request $request)
    {
      
        $vendorEmail = Vendors::where('id', $request->id)->first(); 
        if ($vendorEmail) {

                    Auth::guard('vendor')->login($vendorEmail);

                if($vendorEmail->status==0) {
                   return response()->json(['success'=>0,'message'=>'Your Account Not Approved']); die;
                }else{
                    return response()->json(['success'=>2,'message'=>'Successfully Logged In!']); die;
                }

        }
        return response()->json(['success'=>1,'message'=>'Login details are not valid']); die;

    }
    
}
