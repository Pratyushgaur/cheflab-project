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
    public function temp_recharge(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'user_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $WalletGatewayTransactions = new \App\Models\WalletGatewayTransactions;
            $WalletGatewayTransactions->user_id = $request->user_id;
            $WalletGatewayTransactions->amount = $request->amount;
            $WalletGatewayTransactions->save();
            $id = $WalletGatewayTransactions->id;
            $transaction =rand(10000,99999).$id;
            \App\Models\WalletGatewayTransactions::where('id','=',$id)->update(['transaction_id' => $transaction]);
            return response()->json([
                'status' => true,
                'transaction_id'=>$transaction
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function check_recharge(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'transaction_id' => 'required|numeric|exists:wallet_gateway_transactions,transaction_id'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $transaction = \App\Models\WalletGatewayTransactions::where('transaction_id','=',$request->transaction_id)->first();
            return response()->json([
                'status' => true,
                'response'=>$transaction
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
                'type' => 'required|numeric',
                'transaction_id' => 'required'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $UserWalletTransactions = new \App\Models\UserWalletTransactions;
            $UserWalletTransactions->user_id = $request->user_id;
            $UserWalletTransactions->amount = $request->amount;
            $UserWalletTransactions->narration = "Recharge";
            $UserWalletTransactions->transaction_id = $request->transaction_id;
            
            $UserWalletTransactions->save();
            //
            $users = User::where('id', '=', $request->user_id)->select('wallet_amount')->first();
            $total = $request->amount + $users->wallet_amount;
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