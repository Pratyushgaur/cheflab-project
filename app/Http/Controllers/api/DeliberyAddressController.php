<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use Validator;
use Carbon\Carbon;
// this is vikas testing
class DeliberyAddressController extends Controller
{
    public function deliverAddress(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required',
                'house_no' => 'required',
            ]);
            $address = new DeliveryAddress;
            $address->house_no =$request->house_no;
            $address->user_id = $request->user_id;
            $address->reach =$request->reach;
            $address->contact_no =$request->contact_no;
            $address->address_type =$request->address_type;
            $address->lat = $request->lat;
            $address->long = $request->long;
            $address->save();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>$address
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}