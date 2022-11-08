<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product_master;
use Illuminate\Http\Request;
// this is vikas testing
class AppMasterController extends Controller
{
    public function getCategories()
    {
        try {
         //   Product_master::
            $data = \App\Models\Catogory_master::where(['is_active'=>'1'])->select('categories.name',\DB::raw('CONCAT("'.asset('categories').'/", categoryImage) AS image'),'id')
                ->orderBy('position','ASC')->get();
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
    public function getCuisines()
    {
        try {
            $data = \App\Models\Cuisines::where(['is_active'=>'1'])->select('cuisines.name',\DB::raw('CONCAT("'.asset('cuisines').'/", cuisinesImage) AS image'),'id')->orderBy('position','ASC')->get();
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
