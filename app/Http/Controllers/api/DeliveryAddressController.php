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
                'user_id' => 'required',
                'house_no' => 'required',
                'contact_no' => 'numeric',  
                'lat' => 'required',  
                'long' => 'required' 
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $address = new DeliveryAddress;
            $address->house_no =$request->house_no;
            $address->user_id = $request->user_id;
            $address->reach =$request->reach;
            $address->contact_no =$request->contact_no;
            $address->address_type =$request->address_type;
            $address->lat = $request->lat;
            $address->long = $request->long;
            $address->primary_key = $request->is_primary;
            $address->save();
            if($address->primary_key){
                DeliveryAddress::where('user_id',$request->user_id)->where('id','!=',$address->id)->update(['primary_key'=>'0']);
            }
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

    public function getDeliverAddress(Request $request)
    {
        try {
            $user = 1;
            $data = DeliveryAddress::where('user_id',$request->user_id)->select('*')->get();
            //$data = $data->select(\DB::raw('(CASE  WHEN delivery_address == 1 THEN Home WHEN delivery_address = 2 THEN Office ELSE Other END) AS NewQuantity'));
            
            //$data = $data->get();
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
    public function updateAdress(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required',
                'id' => 'required',
                'address_type' => 'required',
                'house_no' => 'required',
                'contact_no' => 'numeric',  
                'lat' => 'required',  
                'long' => 'required' 
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
           // $address = DeliveryAddress::find(request()->user()->id);
            $update = DeliveryAddress::where('id', '=', $request->id)->where('address_type', '=', $request->address_type)->update(['house_no' => $request->house_no, 'reach' => $request->reach, 'contact_no' => $request->contact_no,'primary_key'=>$request->is_primary]);
            if($request->is_primary){
                DeliveryAddress::where('user_id',$request->user_id)->where('id','!=',$request->id)->update(['primary_key'=>'0']);
            }
            return response()->json([
                'status' => true,
                'message'=>'Address Update Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function deleteAddres(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required',
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            DeliveryAddress::where('id',$request->id)->delete();
          //  DB::table('users')->delete($id);
           // $address->save();
            return response()->json([
                'status' => true,
                'message'=>'Address Delete Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}