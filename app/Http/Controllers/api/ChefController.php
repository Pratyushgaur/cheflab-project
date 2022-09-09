<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
class ChefController extends Controller
{
    public function chefHomePage()
    {
        try {
            $vendors = \App\Models\Vendors::where(['status'=>'1','vendor_type'=>'chef'])->select('name',\DB::raw('CONCAT("'.asset('vendors').'/", image) AS image','rating'))->orderBy('id','desc')->get();
            $products = \App\Models\Product_master::where(['products.status'=>'1','product_for'=>'2'])->join('vendors','products.userId','=','vendors.id')->select('products.product_name','product_price','customizable',\DB::raw('CONCAT("'.asset('products').'/", product_image) AS image','vendors.name as restaurantName'))->orderBy('products.id','desc')->get();
            return response()->json([
                'status' => true,
                'message'=>'Data Get Successfully',
                'response'=>['vendors'=>$vendors,'products' => $products]

            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function getChefByCategory(Request $request)
        {
            try {
                $validateUser = Validator::make($request->all(), 
                [
                    'category_id' => 'required|numeric'
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()
                        
                    ], 401);
                }
                //$data = \App\Models\Product_master::distinct('userId')->select('userId','vendors.name','')->join('vendors','products.userId','=','vendors.id')->where(['products.status'=>'1','product_for'=>'3','category' => $request->category_id])->get();
                $data = \App\Models\Vendors::select('name',\DB::raw('CONCAT("'.asset('vendors').'/", image) AS image'),'vendor_ratings','speciality','deal_categories','id');
                $data = $data->where(['vendors.status'=>'1','vendor_type'=>'chef'])->whereRaw('FIND_IN_SET("'.$request->category_id.'",deal_categories)');
                
                $data = $data->get();
                date_default_timezone_set('Asia/Kolkata');
                foreach ($data as $key => $value) {
                    $category =  \App\Models\Catogory_master::whereIn('id',explode(',',$value->deal_categories))->pluck('name');
                    $timeSchedule =  \App\Models\VendorOrderTime::where(['vendor_id'=>$value->id,'day_no'=>Carbon::now()->dayOfWeek])->first();
                    if ($timeSchedule->available) {
                        if (strtotime(date('H:i:s')) >= strtotime($timeSchedule->start_time) && strtotime(date('H:i:s')) <= strtotime($timeSchedule->end_time)){
                            $data[$key]->isClosed = false;
                        }else{
                            $data[$key]->isClosed = true;
                        }
                    } else {
                        $data[$key]->isClosed = true;
                    }
                    $data[$key]->categories = $category;
                    $data[$key]->is_like = true;
                    
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
        public function getChefDetailPage(Request $request)
        {
            try {
                $validateUser = Validator::make($request->all(), 
                [
                    'vendor_id' => 'required|numeric'
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()
                        
                    ], 401);
                }
                $category = \App\Models\Product_master::where(['vendor_id'=>$request->vendor_id])->select('product_name','id','product_image','type','category','cuisines','product_price','product_rating','customizable')->get();
                /*foreach($category as  $key =>$value){
                    $product = \App\Models\Product_master::where(['products.status'=>'1','product_for'=>'3']);
                    $product = $product->join('categories','products.category','=','categories.id');
                    $product = $product->where('menu_id','=',$value->id);
                    $product = $product->select('products.product_name','product_price','customizable',\DB::raw('CONCAT("'.asset('products').'/", product_image) AS image'));
                    $product = $product->get();
                    $category[$key]->products = $product;
                }*/
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$category
    
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 500);
            }
        }
        public function getChefProfile(Request $request){
            try {
                $validateUser = Validator::make($request->all(), 
                [
                    'vendor_id' => 'required|numeric'
                ]);
                if($validateUser->fails()){
                    $error = $validateUser->errors();
                    return response()->json([
                        'status' => false,
                        'error'=>$validateUser->errors()->all()
                        
                    ], 401);
                }
               $vendors = \App\Models\Vendors::join('chef_video', 'vendors.id', '=', 'chef_video.vendor_id')
               ->get(['vendors.*', 'chef_video.title','chef_video.sub_title','chef_video.link']);
                return response()->json([
                    'status' => true,
                    'message'=>'Data Get Successfully',
                    'response'=>$vendors

                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'error' => $th->getMessage()
                ], 500);
            }
        }
        public function getChefBrowsemenu(Request $request)
        {
            try {
                //code...
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        
}