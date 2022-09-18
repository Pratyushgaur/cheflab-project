<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
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
}
