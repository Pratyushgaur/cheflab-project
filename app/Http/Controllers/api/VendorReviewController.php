<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Vendors;
use Illuminate\Http\Request;
use App\Models\VendorReview;
use Validator;
use Carbon\Carbon;
// this is vikas testing
class VendorReviewController extends Controller
{
//    public function getReviewData(Request $request){
//        try {
//            $validateUser = Validator::make($request->all(),
//            [
//                'user_id' => 'required|numeric',
//            ]);
//            if($validateUser->fails()){
//                $error = $validateUser->errors();
//                return response()->json([
//                    'status' => false,
//                    'error'=>$validateUser->errors()->all()
//
//                ], 401);
//            }
//           // $review =  \App\Models\VendorReview::where('vendor_id', '=', $request->vendor_id)->where('user_id', '=',$request->user_id)->select('id','user_id','vendor_id','rating','review')->get();
//            $review = new VendorReview;
//            $review->user_id =$request->user_id;
//            $review->vendor_id = $request->vendor_id;
//            $review->rating =$request->rating;
//            $review->review	 =$request->review	;
//            $review->save();
//            return response()->json([
//                'status' => true,
//                'message'=>'Data Get Successfully',
//                'response'=>$review
//
//            ], 200);
//        } catch (\Throwable $th) {
//            return response()->json([
//                'status' => false,
//                'error' => $th->getMessage()
//            ], 500);
//        }
//    }
    public function saveReviewData(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'vendor_id' => 'required|numeric',
                    'rating' => 'required|numeric',
                    'review' => 'required',
                ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            // $review =  \App\Models\VendorReview::where('vendor_id', '=', $request->vendor_id)->where('user_id', '=',$request->user_id)->select('id','user_id','vendor_id','rating','review')->get();
            $review = new VendorReview;
            $review->user_id =$request->user()->id;
            $review->vendor_id = $request->vendor_id;
            $review->rating =$request->rating;
            $review->review	 =$request->review	;
            $review->save();

            $rating=VendorReview::select(\DB::raw('AVG(rating) as rating'))->where('vendor_id',$request->vendor_id)->first();
            $vendor=Vendors::find($request->vendor_id);
            $vendor->vendor_ratings=$rating->rating;
            $vendor->save();
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


    public function getReviewData(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'lat' => 'required',
                'lng' => 'required',
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            $review = get_restaurant_near_me($request->lat,$request->lng,['vendor_type'=>'restaurant'],$request->user()->id)->orderBy('vendor_ratings','DESC');
            //$review = $review->leftjoin('vendor_review_rating','vendors.id','=','vendor_review_rating.vendor_id');
            $review = $review->addSelect('vendors.id as vendor_id');
            $review = $review->orderBy('vendor_ratings','DESC')->get();
            ///$review = $review->addSelect('vendor_review_rating.id','vendor_review_rating.user_id','vendor_review_rating.vendor_id','vendor_review_rating.rating as rating_given_by_me','vendor_review_rating.review')->get();
            
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
