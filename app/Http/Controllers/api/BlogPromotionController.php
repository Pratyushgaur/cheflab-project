<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AppPromotionBlogs;
use Illuminate\Http\Request;

class BlogPromotionController extends Controller
{
    public function getBlogPromotion(Request $request)
    {
        try {
            $validateUser = Validator::make(
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
//            $Blogs = AppPromotionBlogs::select('blog_type', 'name', 'from', 'to')
//                ->where('from', '>', mysql_date_time())
//                ->orWhere('to', '<', mysql_add_time())->get();
//
//            if (isset($Blogs[0])) {
//                foreach ($Blogs as $k => $blog) {
//                    $blog_id = $blog->id;
//
//                    //$blog->blog_type 1: vendor 2:product
//                    if ($blog->blog_type == 1) {
//
//                        $resturant = get_restaurant_near_me($request->lat, $request->lng, null, request()->user()->id, null, null);
//
//                        $resturant->join('app_promotion_blog_settings',
//                            function ($q) use ($blog_id) {
//                                $q->on('app_promotion_blog.app_promotion_blog_setting_id', '=', 'app_promotion_blog_settings.id');
//                                $q->where('app_promotion_blog_id', $blog_id);
//                                $q->orderBy('app_promotion_blog_id', 'asc');
//                            })
//                            ->join('app_promotion_blog_booking', function ($query) {
//                                $query->on('app_promotion_blog_booking.app_promotion_blog_setting_id', '=', 'app_promotion_blog_settings.id')
//                                    ->where('app_promotion_blog_booking.vendor_id', '=', 'vendors.id');
//                            })
//                            ->where('app_promotion_blog_id', $blog->id)
//                            ->addSelect('app_promotion_blog_id', 'app_promotion_blog_setting_id', 'vendor_id', 'from_date', 'to_date', 'from_time', 'to_time', 'image')
//                            ->where('to_date.is_active', 1)
//                            ->where('to_date.payment_status', 1);
//                        $Blogs[$k]['vendors']=$resturant;
//                    }
//
//                }
//                dd($Blogs);
//            }


            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $products

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
}
