<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SloteBook;
use Validator;
use Carbon\Carbon;
// this is vikas testing
class BannerController extends Controller
{
    public function getHomepageBanner(Request $request){
        try {
            $data = \App\Models\RootImage::where(['is_active'=>'1'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id')->orderBy('position','ASC')->get();
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
    public function getPromotionBanner(){
        try {
            $date = today()->format('Y-m-d');
            if(SloteBook::where('date','=',$date)->exists()){
               
                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',1)->exists()){
                    $slot1 = SloteBook::where(['is_active'=>'1'])->where('position','=',1)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
                }else{
                    $banner1 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'1'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
                }
                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',2)->exists()){
                    $slot2 = SloteBook::where(['is_active'=>'1'])->where('position','=',2)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
                }else{
                    $banner2 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'2'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
                }
                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',3)->exists()){
                    $slot3 = SloteBook::where(['is_active'=>'1'])->where('position','=',3)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
                }else{
                    $banner3 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'3'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
                }
                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',4)->exists()){
                    $slot4 = SloteBook::where(['is_active'=>'1'])->where('position','=',4)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
                }else{
                    $banner4 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'4'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
                }
                if(SloteBook::where(['is_active'=>'1'])->where('date','=',$date)->where('position','=',5)->exists()){
                    $slot5 = SloteBook::where(['is_active'=>'1'])->where('position','=',5)->select('date',\DB::raw('CONCAT("'.asset('slot-vendor-image').'/", slot_image) AS image'),'id','slot_name','price','position')->get();
               }else{
                    $banner5 = \App\Models\RootImage::where(['is_active'=>'1'])->where(['position'=>'5'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->get();
                }
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$data
    
                ], 200);
            }else{
                $data = \App\Models\RootImage::where(['is_active'=>'1'])->select('name',\DB::raw('CONCAT("'.asset('admin-banner').'/", bannerImage) AS image'),'id','position')->orderBy('position','ASC')->get();
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$data
    
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}