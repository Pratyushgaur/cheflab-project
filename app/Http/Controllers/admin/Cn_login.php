<?php

namespace App\Http\Controllers\admin;
use App\Events\AdminLoginHistoryEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;

class Cn_login extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('adminarea.login.login');
    // }

    public function admin_login(Request $request){
        //return $request;
         $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if(Auth::guard('admin')->attempt(array('email' =>$request->email,'password' => $request->password))){
            
            event(new AdminLoginHistoryEvent(['ipAddress'=>request()->ip()]));
            if ($request->remember === null) {
                setcookie('login_email', $request->email, 100);
                setcookie('login_password', $request->password, 100);
            } else {
                setcookie('login_email', $request->email, time() + 60 * 60 * 24 * 10);
                setcookie('login_password', $request->password, time() + 60 * 60 * 24 * 10);
            }
            $request->session()->put([
                '**^&%*$$username**$%#' => Auth::guard('admin')->user()->name,
                '*$%&%*id**$%#' => Auth::guard('admin')->user()->id,
                '**$%#email**^&%*' => Auth::guard('admin')->user()->email
            ]);
            if ($request->session()->has('**^&%*$$username**$%#', '*$%&%*id**$%#', '**$%#email**^&%*')) {
                return redirect('admin/dashbord-admin')->with('message', 'Successfully Logged In!');
            } else {
                
                return \Redirect::back()->withErrors(['msg' => 'You have entered wrong credentials.. Please try again...']);
            }
            
        }else{
            return \Redirect::back()->withErrors(['msg' => 'You have entered wrong credentials.. Please try again...']);
            //return redirect()->back()->with('error', 'You have entered wrong password.. Please try again...');
        }
    }

}
