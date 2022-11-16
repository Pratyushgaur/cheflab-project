<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product_master;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Validator;

// this is vikas testing
class ProductReviewController extends Controller
{
//    public function getReviewData(Request $request){
//        try {
//            $validateUser = Validator::make($request->all(),
//            [
//                'product_id' => 'required|numeric',
//                'user_id' => 'required|numeric',
//                'rating' => 'required|numeric',
//                'review' => 'required'
//            ]);
//            if($validateUser->fails()){
//                $error = $validateUser->errors();
//                return response()->json([
//                    'status' => false,
//                    'error'=>$validateUser->errors()->all()
//
//                ], 401);
//            }
//            $review = new VendorReview;
//            $review->user_id =$request->user()->id;
//            $review->product_id = $request->product_id;
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

    public function saveReviewData(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'product_id' => 'required|numeric',
                    'rating'     => 'required|numeric',
                    'review'     => 'required',
                ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            // $review =  \App\Models\VendorReview::where('vendor_id', '=', $request->vendor_id)->where('user_id', '=',$request->user_id)->select('id','user_id','vendor_id','rating','review')->get();
            $review             = new ProductReview();
            $review->user_id    = $request->user()->id;
            $review->product_id = $request->product_id;
            $review->rating     = $request->rating;
            $review->review     = $request->review;
            $review->save();

            $rating                 = ProductReview::select(\DB::raw('AVG(rating) as rating'))->where('product_id', $request->vendor_id)->first();
            $vendor                 = Product_master::find($request->product_id);
            $vendor->product_rating = $rating->rating;
            $vendor->save();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $review
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }


    public function getReviewData(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'lat' => 'required',
                    'lng' => 'required',
                ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $vendor_ids = ProductReview::join('products', 'products.id', '=', 'product_review_rating.product_id')
                ->where('user_id', $request->user()->id)->pluck('userId');

            $product_ids = ProductReview::groupBy('product_id')->pluck('product_id');
            $rest_ids   = get_restaurant_ids_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], true)->whereIn('vendors.id', $vendor_ids)->pluck('vendors.id');
//            dd($product_ids);
            if (!empty($rest_ids) && !empty($product_ids))
                $products = get_product_with_variant_and_addons(null, $request->user()->id, null, '', true, false, $rest_ids,
                null,null,false,$product_ids);
//                ->join('vendor_review_rating','vendors.id','=','vendor_review_rating.vendor_id')
//                ->where('vendor_review_rating.user_id', '=', $request->user()->id)
//                ->addSelect('vendor_review_rating.id','vendor_review_rating.user_id','vendor_review_rating.vendor_id','vendor_review_rating.rating as rating_given_by_me','vendor_review_rating.review')->get();
            else
                $products = [];

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'products' => $products

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

}
