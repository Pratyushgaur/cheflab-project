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
            $data=[];
            $Blogs = AppPromotionBlogs::select('id', 'blog_type', 'name', 'from', 'to')
//                ->where(function ($p) {
//                    $p->where('from', '<=', mysql_date_time())->where('to', '>', mysql_date_time());
//                })
                ->where('vendor_type', $request->vendor_type)
                ->get();

            $product_count = 0;
//            dd($Blogs->toArray());
            if (isset($Blogs[0])) {
                foreach ($Blogs as $k => $blog) {
                    $data1=null;
                    $data[$k]['blog'] = $blog;
                    $blog_id = $blog->id;
                    //$blog->blog_type 1: vendor 2:product
                    if ($blog->blog_type == '1') {

                        $resturant = get_restaurant_near_me($request->lat, $request->lng, null, request()->user()->id, null, null);

                        $resturant->join('app_promotion_blog_bookings', function ($query) {
                            $query->on('app_promotion_blog_bookings.vendor_id', '=', 'vendors.id');
                        });

                        $resturant->join('app_promotion_blog_settings',
                            function ($q) use ($blog_id) {
                                $q->on('app_promotion_blog_bookings.app_promotion_blog_setting_id', '=', 'app_promotion_blog_settings.id');
                                $q->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog_id);
                                $q->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                            });
                        $resturant->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog->id);
                        $resturant->addSelect('app_promotion_blog_bookings.app_promotion_blog_id', 'app_promotion_blog_bookings.app_promotion_blog_setting_id',
                            'app_promotion_blog_bookings.vendor_id', 'from_date', 'to_date', 'from_time', 'to_time',
                            'app_promotion_blog_bookings.image as blog_promotion_image')
                            ->where('app_promotion_blog_settings.is_active', 1)
                            ->where('app_promotion_blog_bookings.payment_status', 1)
                            ->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                        $resturant = $resturant->get();
                        $data1   = $resturant;
                        $data[$k]['vendors'] = $data1;
                    }
                    if ($blog->blog_type == '2') {
                        $resturant = get_restaurant_ids_near_me($request->lat, $request->lng, null, true, null, null);

                        $resturant->join('app_promotion_blog_bookings', function ($query) {
                            $query->on('app_promotion_blog_bookings.vendor_id', '=', 'vendors.id');
                        });
                        $resturant->join('app_promotion_blog_settings',
                            function ($q) use ($blog_id) {
                                $q->on('app_promotion_blog_bookings.app_promotion_blog_setting_id', '=', 'app_promotion_blog_settings.id');
                                $q->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog_id);
                                $q->orderBy('app_promotion_blog_settings.blog_position', 'asc');
                            });

                        $resturant->where('app_promotion_blog_bookings.app_promotion_blog_id', $blog->id);

                        $resturant->addSelect('app_promotion_blog_bookings.app_promotion_blog_id',
                            'app_promotion_blog_bookings.app_promotion_blog_setting_id',
                            'app_promotion_blog_bookings.vendor_id', 'from_date', 'to_date', 'from_time', 'to_time',
                            'app_promotion_blog_bookings.product_id')
                            ->where('app_promotion_blog_settings.is_active', 1)
                            ->where('app_promotion_blog_bookings.payment_status', 1)
                            ->orderBy('app_promotion_blog_settings.blog_position', 'asc');
//                        dd($resturant->get()->toArray());
                        $resturants = $resturant->get();

                        foreach ($resturants as $k => $res)
                            $data1[] = get_product_with_variant_and_addons(['products.id' => $res->product_id],
                                $request->user()->id, null, null, true);

                        $data[$k]['products'] = $data1;
                    }


                }

            }
//            dd($data);

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => $data

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }
}
