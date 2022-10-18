<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserFaqApiController extends Controller
{
    public function get_user_faq(){
        try {
            $data = \App\Models\User_faq::select('id','faq_question','faq_answer')->get();
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
