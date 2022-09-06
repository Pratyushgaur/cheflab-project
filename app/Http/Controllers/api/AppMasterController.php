<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppMasterController extends Controller
{
    public function getCategories()
    {
        try {
            $data = \App\Models\Catogory_master::where(['is_active'=>'1'])->select('categories.name',\DB::raw('CONCAT("'.asset('categories').'/", categoryImage) AS image'))->orderBy('position','ASC')->get();
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
            $data = \App\Models\Cuisines::where(['is_active'=>'1'])->select('cuisines.name',\DB::raw('CONCAT("'.asset('cuisines').'/", cuisinesImage) AS image'))->orderBy('position','ASC')->get();
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
