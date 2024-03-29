<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

// this is vikas testing
class BannerController extends Controller
{
    public function getHomepageBanner(Request $request){
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'for' => ['required', Rule::in( config('custom_app_setting.promotion_banner_for_only_values'))]
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }

            $data = \App\Models\RootImage::where([ 'is_active' => '1' ])
                ->where('banner_for',$request->for)
                ->select('name', \DB::raw('CONCAT("' . asset('admin-banner') . '/", bannerImage) AS image'), 'id' ,'redirect_vendor_id as vendor_id')
                ->orderBy('position', 'ASC')->get();
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
//    public function getPromotionBanner(){
//        try {
//            $date = today()->format('Y-m-d');
//            if(SloteBook::where('date','=',$date)->exists()){
//
//                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',1)->exists()){
//                    $slot1 = SloteBook::where(['is_active'=>'1'])->where('position','=',1)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
//                }else{
//                    $banner1 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'1'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
//                }
//                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',2)->exists()){
//                    $slot2 = SloteBook::where(['is_active'=>'1'])->where('position','=',2)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
//                }else{
//                    $banner2 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'2'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
//                }
//                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',3)->exists()){
//                    $slot3 = SloteBook::where(['is_active'=>'1'])->where('position','=',3)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
//                }else{
//                    $banner3 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'3'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
//                }
//                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',4)->exists()){
//                    $slot4 = SloteBook::where(['is_active'=>'1'])->where('position','=',4)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
//                }else{
//                    $banner4 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'4'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
//                }
//                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',5)->exists()){
//                    $slot5 = SloteBook::where(['is_active'=>'1'])->where('position','=',5)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
//               }else{
//                    $banner5 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'5'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
//                }
//                return response()->json([
//                    'status' => true,
//                    'message'=>'Data Get Successfully',
//                    'response'=>$data
//
//                ], 200);
//            }else{
//                $data = \App\Models\RootImage::where(['is_active'=>'1'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->orderBy('position','ASC')->get();
//                return response()->json([
//                    'status' => true,
//                    'message'=>'Data Get Successfully',
//                    'response'=>$data
//
//                ], 200);
//            }
//        } catch (\Throwable $th) {
//            return response()->json([
//                'status' => false,
//                'error' => $th->getMessage()
//            ], 500);
//        }
//    }

    public function getPromotionBanner(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric',
                    'for' => ['required', Rule::in( config('custom_app_setting.promotion_banner_for_only_values'))]
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $date             = today()->format('Y-m-d');
            $vendor_ids       = get_restaurant_ids_near_me($request->lat, $request->lng, [ 'is_all_setting_done' => 1 ]);
            $current_time     = mysql_time();
            $current_date     = mysql_date_time();
            $number_of_slides = config('custom_app_setting.promotion_banner_number_of_slides');
            $slots = \App\Models\SloteBook::where([ 'cheflab_banner_image.is_active' => '1' ])
            ->where([ 'cheflab_banner_image.banner_for' =>  $request->for])
            ->rightJoin('cheflab_banner_image',function($join) use ($vendor_ids, $current_date, $current_time){
                $join->on('cheflab_banner_image.id', '=', 'slotbooking_table.cheflab_banner_image_id');
                $join->whereIn('vendor_id', $vendor_ids)
                        ->where('from_date', '<=', $current_date)
                        ->where('to_date', '>=', $current_date)
                        ->where('from_time', '<=', $current_time)
                        ->where('to_time', '>=', $current_time)
                        ->where([ 'slotbooking_table.is_active' => '1' ]);
            })
            ->selectRaw('slotbooking_table.id as slot_id,CONCAT("' . asset('slot-vendor-image') . '/", slot_image) AS slot_image,CONCAT("' . asset('admin-banner') . '/", bannerImage) AS bannerImage,'
                    . 'cheflab_banner_image.position as banner_position,slotbooking_table.vendor_id')
            ->addSelect('cheflab_banner_image.redirect_vendor_id')
                ->orderBy('cheflab_banner_image.position', 'asc')
                ->limit($number_of_slides)
                ->get();

            $response = [];
            foreach ($slots as $k => $slot) {
                if ($slot->slot_id != '')
                    $response[] = [ 'image' => $slot->slot_image, 'position' => $slot->banner_position,'vendor_id'=> $slot->vendor_id];
                else
                    $response[] = [ 'image' => $slot->bannerImage, 'position' => $slot->banner_position ,'vendor_id'=>$slot->redirect_vendor_id];
            }

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $response
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([ 'status' => false,
                                      'error'  => $th->getMessage() ], 500);
        }
    }
}
