<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Vendors;
use Illuminate\Http\Request;
use App\Models\VendorReview;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Models\Cuisines;
use App\Models\Catogory_master;

use URL;
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

            $rating=VendorReview::select(\DB::raw('AVG(rating) as rating'),\DB::raw('COUNT(id) as total_review'))->where('vendor_id',$request->vendor_id)->first();
            $vendor=Vendors::find($request->vendor_id);
            $vendor->vendor_ratings=$rating->rating;
            $vendor->review_count=$rating->total_review;
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
                'offset'=>'required','limit'=>'required',
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            //return Vendors::select('name')->withCount(['products as ps_count'])->having('ps_count', '>', 0)->get();            ;
            $review = get_restaurant_near_me($request->lat,$request->lng,['vendor_type'=>'restaurant'],$request->user()->id)->orderBy('vendor_ratings','DESC');
            $review = $review->offset($request->offset)->limit($request->limit);
            $data = $review->get();
            $baseurl = URL::to('vendor-banner/') . '/';
            foreach ($data as $key => $value) {
                $banners = json_decode($value->banner_image);
                if (is_array($banners))
                    $urlbanners = array_map(function ($banner) {
                        return URL::to('vendor-banner/') . '/' . $banner;
                    }, $banners);
                else
                    $urlbanners = [];

                $data[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $category                   = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $data[$key]->categories     = $category;
                $data[$key]->imageUrl       = $baseurl;
                $data[$key]->banner_image   = $urlbanners;
                $data[$key]->next_available = next_available_day($value->id);
            }
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

    public function getVendorReviews(Request $request){
        try {
            $validateUser = Validator::make($request->all(),
            [
                'vendor_id' => 'required',
                'offset' => 'required',
                'limit' => 'required'
            ]);
            if($validateUser->fails()){
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'=>$validateUser->errors()->all()

                ], 401);
            }
            //
            $review = VendorReview::join('users','vendor_review_rating.user_id','=','users.id')->where('vendor_id','=',$request->vendor_id)
            //->skip($request->offset)->take($request->limit)
            ->orderBy('vendor_review_rating.id','desc')
            ->select('users.name',\DB::raw('CONCAT("' . asset('vendors') . '/", image) AS image') , 'vendor_review_rating.rating','review',\DB::raw("DATE_FORMAT(vendor_review_rating.created_at, '%d %b %Y at %H:%i %p') as date"))->get();
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
