<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AppPromotionBlogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BlogPromotionController extends Controller
{
    public function getBlogPromotion(Request $request)
    {
        try {
            $validateUser = \Illuminate\Support\Facades\Validator::make(
                $request->all(),
                ['lat'         => 'required|numeric',
                 'lng'         => 'required|numeric',
                 'vendor_type' => 'required|numeric'
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $Blogs         = AppPromotionBlogs::select('id', 'blog_type', 'name', 'from', 'to')
                ->where(function ($p) {
                    $p->where('from', '<=', mysql_date_time())->where('to', '>', mysql_date_time());
                })
                ->where('vendor_type', $request->vendor_type)
                ->get();
            $reponce =  promotionRowSetup($Blogs);

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $reponce

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
}
