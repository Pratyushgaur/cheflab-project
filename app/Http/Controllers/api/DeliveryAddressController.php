<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use Validator;
use Carbon\Carbon;
// this is vikas testing
class DeliveryAddressController extends Controller
{
    public function deliverAddress(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                
                'house_no' => 'required',
                'contact_no' => 'numeric|max:10',  
                'lat' => 'required',  
                'long' => 'required' 
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $address = new DeliveryAddress;
            $address->house_no =$request->house_no;
            $address->user_id = request()->user()->id;
            $address->reach =$request->reach;
            $address->contact_no =$request->contact_no;
            $address->address_type =$request->address_type;
            $address->lat = $request->lat;
            $address->long = $request->long;
            $address->save();
            return response()->json([
                'status' => true,
                'message'=>'Address Saved Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function getDeliverAddress(Type $var = null)
    {
        try {
            $user = 1;
            $data = DeliveryAddress::where('user_id',request()->user()->id);
            //$data = $data->select(\DB::raw('(CASE  WHEN delivery_address == 1 THEN Home WHEN delivery_address = 2 THEN Office ELSE Other END) AS NewQuantity'));
            
            $data = $data->get();
            return response()->json([
                'status' => true,
                'message'=>'Address Saved Successfully',
                'response'=>$data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}