<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Validator;
use Hash;
use App\Models\Vendors;
class LoginController extends Controller
{
    function index(){
        return view("vendor.vendor_app.login");
    }
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
                   return redirect()->route('app.restaurant.dashboard',Auth::guard('vendor')->user()->id);
                } 
                // elseif(Auth::guard('vendor')->user()->vendor_type == 'chef') {
                    
                //     return redirect()->route('chef.dashboard')->with('message', 'Successfully Logged In!');
                // }
                
                //return redirect('admin/dashbord-admin')->with('message', 'Successfully Logged In!');
            } else {
                  
                return \Redirect::back()->withErrors(['error' => 'You have entered wrong credentials.. Please try again...']);
            }
            
            
        }else{
            return \Redirect::back()->with('error', 'You have Provide Wrong Credentials');   
        }

    } 

    public function login_test(Request $request)
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
                
                
                return response()->json(['status' => true, 'response' =>'succes'], 200);

                        
                // if (Auth::guard('vendor')->user()->vendor_type == 'restaurant') {
                //    return redirect()->route('app.restaurant.dashboard');
                // } 
                // elseif(Auth::guard('vendor')->user()->vendor_type == 'chef') {
                    
                //     return redirect()->route('chef.dashboard')->with('message', 'Successfully Logged In!');
                // }
                
                //return redirect('admin/dashbord-admin')->with('message', 'Successfully Logged In!');
            } else {
                  
                return response()->json([
                    'status' => false,
                    'error'  => "invalid"
                ], 500); 
            }
            
            
        }else{
            //return \Redirect::back()->with('error', 'You have Provide Wrong Credentials');   
            return response()->json([
                'status' => true,
                'error'  => "You have Provide Wrong Credentials"
            ], 500); 
        }

    } 

    
}
