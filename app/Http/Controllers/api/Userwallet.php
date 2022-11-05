<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\User_rechaege;
use Validator;
use Carbon\Carbon;
// this is vikas testing
class Userwallet extends Controller
{
    public function getUserwallet(Request $request){
        try {    
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $data = \App\Models\User::where(['id'=>$request->user_id])->select('id','name','mobile_number','wallet_amount')->get();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>$data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function Recharge(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required|numeric',
                'amount' => 'required|numeric',
                'type' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $user = new  User_rechaege;
            $user->amount =$request->amount;
            $user->user_id =$request->user_id;
            $user->type =$request->type;
            $user->transaction_id =$request->transaction_id;
            $user->save();
            $users = User::where('id', '=', $request->user_id)->select('wallet_amount')->get();
            foreach($users as $key => $value){
                $total = $request->amount + $value['wallet_amount'];
               
            }
   
            $update = User::where('id', '=', $request->user_id)->update(['wallet_amount' => $total]);
            return response()->json([
                'status' => true,
                'message'=>'Recharge  Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function allTransactions(Request $request){
        try {    
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $data = \App\Models\User_rechaege::where(['user_id'=>$request->user_id])->select('id','type','created_at','transaction_id','amount')->get();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
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