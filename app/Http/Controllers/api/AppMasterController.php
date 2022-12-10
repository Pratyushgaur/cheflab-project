<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

// this is vikas testing
class AppMasterController extends Controller
{
    // public function getCategories(Request $request)
    // {
    //     try {
    //         $validateUser = Validator::make(
    //             $request->all(),
    //             [
    //                 'lat' => 'required|numeric',
    //                 'lng' => 'required|numeric'
    //             ]
    //         );
    //         if ($validateUser->fails()) {
    //             $error = $validateUser->errors();
    //             return response()->json([
    //                 'status' => false,
    //                 'error'  => $validateUser->errors()->all()

    //             ], 401);
    //         }

    //         $resturants   = get_restaurant_ids_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], true, null, null, false);
    //         $category_ids = $resturants->join('products as p', 'p.userId', '=', 'vendors.id')
    //             ->where('p.status','=','1')
    //             ->where('p.product_approve','=','1')
    //             ->addSelect('p.category', \DB::raw('COUNT(*) as product_count'))
    //             ->groupBy('p.category')->having('product_count', '>',0)->pluck('p.category');

    //         if ($category_ids != '' && $category_ids != null){
    //             $vendorCatIds = [];
    //             foreach ($category_ids as $ids){
    //                 $vendor_count = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], null, null, null)
    //                 ->whereRaw('FIND_IN_SET(' . $ids . ',deal_categories)')->count();
    //                 if($vendor_count > 0){
    //                     $vendorCatIds[] = $ids;
    //                 }  
    //             }
    //             if (!empty($vendorCatIds)) {
    //                 $data = \App\Models\Catogory_master::whereIn('id', $vendorCatIds)->where(['is_active' => '1'])->select('categories.name', \DB::raw('CONCAT("' . asset('categories') . '/", categoryImage) AS image'), 'id')
    //                 ->orderBy('position', 'ASC')->get();
    //             } else {
    //                 $data = [];
    //             }

    //             return response()->json([
    //                 'status'   => true,
    //                 'message'  => 'Data Get Successfully',
    //                 'response' => $data

    //             ], 200);
    //         }
    //         else{
    //             $data = [];
    //             return response()->json([
    //                 'status'   => true,
    //                 'message'  => 'Data Get Successfully',
    //                 'response' => $data

    //             ], 200);
    //         }
                
                
            


    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error'  => $th->getMessage()
    //         ], 500);
    //     }

    // }

    // public function getCuisines(Request $request)
    // {
    //     try {
    //         $validateUser = Validator::make(
    //             $request->all(),
    //             [
    //                 'lat' => 'required|numeric',
    //                 'lng' => 'required|numeric'
    //             ]
    //         );
    //         if ($validateUser->fails()) {
    //             $error = $validateUser->errors();
    //             return response()->json([
    //                 'status' => false,
    //                 'error'  => $validateUser->errors()->all()

    //             ], 401);
    //         }

    //         $resturants   = get_restaurant_ids_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], true, null, null, false);
    //         $cuisines_ids = $resturants->join('products as p', 'p.userId', '=', 'vendors.id')
    //             ->addSelect('p.cuisines', \DB::raw('COUNT(*) as product_count'))
    //             ->where('p.status','=','1')
    //             ->where('p.product_approve','=','1')
    //             ->groupBy('p.cuisines')->having('product_count', '>',0)->pluck('p.cuisines');
    //         if ($cuisines_ids != '' && $cuisines_ids != null){
    //             $vendorCuisIds = [];
    //             foreach ($cuisines_ids as $ids){
    //                 $vendor_count = get_restaurant_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], null, null, null)
    //                 ->whereRaw('FIND_IN_SET(' . $ids . ',deal_cuisines)')->count();
    //                 if($vendor_count > 0){
    //                     $vendorCuisIds[] = $ids;
    //                 }  
    //             }
    //             if (!empty($vendorCuisIds)) {
    //                 $data = \App\Models\Cuisines::whereIn('id',$vendorCuisIds)->where(['is_active' => '1'])->select('cuisines.name', \DB::raw('CONCAT("' . asset('cuisines') . '/", cuisinesImage) AS image'), 'id')->orderBy('position', 'ASC')->get();
                    
    //             } else {
    //                 $data = [];
    //             }
    //             return response()->json([
    //                 'status'   => true,
    //                 'message'  => 'Data Get Successfully',
    //                 'response' => $data

    //             ], 200);
    //         }else{
    //             $data = [];
    //             return response()->json([
    //                 'status'   => true,
    //                 'message'  => 'Data Get Successfully',
    //                 'response' => $data
    
    //             ], 200);
    //         }
            


    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'error'  => $th->getTrace()
    //         ], 500);
    //     }

    // }
    public function getCuisines(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }


            $cuisines = \App\Models\Cuisines::where('is_active','=','1')->orderBy('position','ASC')->select('cuisines.name', \DB::raw('CONCAT("' . asset('cuisines') . '/", cuisinesImage) AS image'), 'id','position')->get();
            $data = [];
            foreach ($cuisines as $key => $value) {
                $resturants   = get_restaurant_ids_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], true, null, null, false);
                $resturants = $resturants->whereRaw('FIND_IN_SET(' . $value->id . ',deal_cuisines)');
                $resturants = $resturants->join('products as p', 'p.userId', '=', 'vendors.id');
                $resturants = $resturants->where('p.status','=','1');
                $resturants = $resturants->addSelect( \DB::raw('COUNT(*) as product_count'),'vendors.id');
                $resturants = $resturants->groupBy('p.id')->having('product_count', '>',0);
                if($resturants->get()->count('vendors.id') > 0){
                    $data[] = $value;
                }
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
            


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getTrace()
            ], 500);
        }

    }
    public function getCategories(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat' => 'required|numeric',
                    'lng' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }


            $category = \App\Models\Catogory_master::where('is_active','=','1')->orderBy('position','ASC')->select('categories.name', \DB::raw('CONCAT("' . asset('categories') . '/", categoryImage) AS image'), 'id','position')->get();
            $data = [];
            foreach ($category as $key => $value) {
                $resturants   = get_restaurant_ids_near_me($request->lat, $request->lng, ['vendor_type' => 'restaurant'], true, null, null, false);
                $resturants = $resturants->whereRaw('FIND_IN_SET(' . $value->id . ',deal_categories)');
                $resturants = $resturants->join('products as p', 'p.userId', '=', 'vendors.id');
                $resturants = $resturants->where('p.status','=','1');
                $resturants = $resturants->addSelect( \DB::raw('COUNT(*) as product_count'),'vendors.id');
                $resturants = $resturants->groupBy('p.id')->having('product_count', '>',0);
                if($resturants->get()->count('vendors.id') > 0){
                    $data[] = $value;
                }
            }
            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
            


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getTrace()
            ], 500);
        }

    }

}
