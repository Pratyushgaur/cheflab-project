<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Validator;
use Carbon\Carbon;
// this is vikas testing
class ProductReviewController extends Controller
{
    public function getReviewData(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'product_id' => 'required|numeric',
                'user_id' => 'required|numeric'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()
                    
                ], 401);
            }
            $review = new VendorReview;
            $review->user_id =$request->user_id;
            $review->product_id = $request->product_id;
            $review->rating =$request->rating;
            $review->review	 =$request->review	;
            $review->save();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>$review

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}