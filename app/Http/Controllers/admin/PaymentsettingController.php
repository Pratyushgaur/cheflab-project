<?php

namespace App\Http\Controllers\Admin;
use App\Models\Paymentsetting;
use App\Models\Social_media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class PaymentsettingController extends Controller
{

    public function index(){  
        
        $id = '1';
        $data = Paymentsetting::findOrFail($id);
        return view('admin/payout/index',compact('data'));
    }

    public function storeGernel(Request $request){

        // echo '<pre>';print_r($request->all());die;
        $general = Paymentsetting::find($request->id);
        $general->additions = $request->additions;
        if($request->hiddentoggle){
            $general->convenience_fee = $request->convenience_fee;
            
        }else{
            $general->convenience_fee = 0;
        }
        
        $general->order_rejection = $request->order_rejection;  
        $general->toggle = $request->hiddentoggle;      
        $general->save();
        return redirect()->route('admin.payout.setting')->with('message', 'Update Successfully');
    }
    
    
}
