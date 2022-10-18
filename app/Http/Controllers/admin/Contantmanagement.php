<?php

namespace App\Http\Controllers\Admin;
use App\Models\User_faq;
use App\Models\Content_management;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables; 
class Contantmanagement extends Controller
{
    
    public function index(){
        $id = '1';
        $data = Content_management::findOrFail($id);
        return view('admin/contentmangement/user',compact('data'));
    }
    public function storePrivacy(Request $request){
        $general = Content_management::find($request->id);
        $general->user_privacy_policy = $request->user_privacy_policy;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Privacy Policy  Update Successfully');
    }
    public function storeVendorTC(Request $request){
        $general = Content_management::find($request->id);
        $general->terms_conditions_user = $request->terms_conditions_user;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Vendor Terms & Condition  Update Successfully');
    }
    public function storeCheflabTC(Request $request){
        $general = Content_management::find($request->id);
        $general->terms_conditions_cheflab = $request->terms_conditions_cheflab;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Cheflab Terms & Condition  Update Successfully');
    }
    public function storeRefund(Request $request){
        $general = Content_management::find($request->id);
        $general->refund_cancellation_user = $request->refund_cancellation_user;
        $general->save();
        return redirect()->route('admin.user.contentmanagement')->with('message', 'Cheflab Terms & Condition  Update Successfully');
    }
}