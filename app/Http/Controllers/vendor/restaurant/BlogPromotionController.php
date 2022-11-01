<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\AppPromotionBlogBooking;
use App\Models\AppPromotionBlogs;
use App\Models\AppPromotionBlogSetting;
use App\Models\Product_master;
use App\Models\Superadmin;
use App\Notifications\CreateSlotBookingToAdminNotification;
use Illuminate\Http\Request;

class BlogPromotionController extends Controller
{
    public function shop_promotion(Request $request)
    {
        $ids                      = AppPromotionBlogs::where('blog_type', 1)->where('vendor_type', 1)->pluck('id');
        $appPromotionBlogBookings = AppPromotionBlogBooking::with(['app_promotion_setting', 'app_promotion_blog'])
            ->whereIn('app_promotion_blog_id', $ids)
            ->where('vendor_id', \Auth::guard('vendor')->user()->id)->paginate(25);
//        dd($appPromotionBlogBookings);
        return view('vendor.restaurant.blog_promotion.list', compact('appPromotionBlogBookings'));
    }

    public function product_promotion(Request $request)
    {
        $ids                      = AppPromotionBlogs::where('blog_type', 2)->where('vendor_type', 1)->pluck('id');
        $appPromotionBlogBookings = AppPromotionBlogBooking::with(['app_promotion_setting', 'app_promotion_blog','product'])
            ->whereIn('app_promotion_blog_id', $ids)
            ->where('vendor_id', \Auth::guard('vendor')->user()->id)->paginate(25);
//        dd($appPromotionBlogBookings);

        return view('vendor.restaurant.blog_promotion.product_list', compact('appPromotionBlogBookings'));
    }


    public function create_shop_promotion()
    {
        $app_promotion = AppPromotionBlogs::select(\DB::raw("CONCAT(`name`, ' ( ', `from`, ' - ', `to`, ' ) ') AS display_name"), 'id')
            ->where('vendor_type', '1')->where('blog_type', '1')->pluck('display_name', 'id');
        return view('vendor.restaurant.blog_promotion.create_shop_promotion', compact('app_promotion'));
    }

    public function create_product_promotion()
    {
        $app_promotion = AppPromotionBlogs::select(\DB::raw("CONCAT(`name`, ' ( ', `from`, ' - ', `to`, ' ) ') AS display_name"), 'id')
            ->where('vendor_type', '1')->where('blog_type', '2')->pluck('display_name', 'id');
        $products      = Product_master::where('product_image', '!=', '')->pluck('product_name', 'id');
        return view('vendor.restaurant.blog_promotion.create_product_promotion', compact('app_promotion', 'products'));
    }


    public function get_positions(Request $request)
    {
        $app_promotion_blog_id = $request->app_promotion_blog_id;
        $vendor_id             = \Auth::guard('vendor')->user()->id;
        $date                  = $request->date;
        $AppPromotionBlogs     = AppPromotionBlogs::find($app_promotion_blog_id);
        if (!isset($AppPromotionBlogs->from))
            return response()->json([
                'status'  => false,
                'message' => ''
            ], 200);


        $date_from                     = mysql_date_time_marge($request->date, $AppPromotionBlogs->from);
        $promotion_time_frame_add_days = config('custom_app_setting.blog_promotion_date_frame_add_days');

        //get "to_date" : add munber of days
        if (isset($promotion_time_frame_add_days[$request->time_frame])) {
            $date_to = mysql_add_days($date_from, $promotion_time_frame_add_days[$request->time_frame]);
            $date_to = mysql_date_time_marge($date_to, $AppPromotionBlogs->to);
        } else
            return response()->json([
                'status'  => false,
                'message' => ''
            ], 200);

//-----------------------------------------------------------------------
        //same request already exists/
        if (AppPromotionBlogBooking::where('app_promotion_blog_id', '=', $request->app_promotion_blog_id)
            ->where('from_date', '=', $date_from)->where('to_date', '=', $date_to)
            ->where('vendor_id', '=', $vendor_id)->exists()) {
            return response()->json([
                'status'  => false,
                'message' => 'Duplicate request'
            ], 200);
        }

        //get current restaurant location
        $lat        = \Auth::guard('vendor')->user()->lat;
        $lng        = \Auth::guard('vendor')->user()->long;
        $vendor_ids = get_restaurant_ids_near_me($lat, $lng);

        //if no vendor found, that means all slotes available for current vendor
        if (empty($vendor_ids)) {
            $slot = AppPromotionBlogSetting::select(\DB::raw("CONCAT(`blog_position`, ' ( Price:', `blog_price`, ' ) ') AS name"), 'blog_position')
                ->where('app_promotion_blog_id', $request->app_promotion_blog_id)->where('is_active', 1)->pluck('name', 'blog_position');
            return \Response::json($slot);
        }

//\DB::enableQueryLog();
        //eliminate already booked slots
        $booked_slot_ids = AppPromotionBlogBooking::where('app_promotion_blog_id', $request->app_promotion_blog_id)
            ->where(function ($q) use ($date_to, $date_from,$AppPromotionBlogs) {
                $q->where(function ($q) use ($date_to, $date_from) {
                    $q->where([['from_date', '>=', $date_from], ['from_date', '<=', $date_to]])
                        ->orWhere([['to_date', '>=', $date_from], ['to_date', '<=', $date_to]]);
                })
                    ->where('from_time',mysql_time($AppPromotionBlogs->from))->where('to_time',mysql_time($AppPromotionBlogs->to));

            })
            ->where('is_active', '=', '1')
            ->whereIn('vendor_id', $vendor_ids)
            ->pluck('app_promotion_blog_setting_id');
//dd($booked_slot_ids);
        $slotMaster = AppPromotionBlogSetting::select(\DB::raw("CONCAT(`blog_position`, ' ( Price:', `blog_price`, ' ) ') AS name"), 'id')
            ->where('app_promotion_blog_id', $request->app_promotion_blog_id)->where('is_active', 1);

        if (!empty($booked_slot_ids)) {
            $slotMaster->whereNotIn('id', $booked_slot_ids);
        }
        $slot = $slotMaster->limit(config('custom_app_setting.blog_promotion_banner_number_of_slides'))->get();
//dd($slot);
        if (isset($slot[0]))
            return \Response::json($slot);
        else
            return response()->json([
                'status'  => false,
                'message' => 'No slots available'
            ], 200);
    }

    public function save_shop_promotion(Request $request)
    {
        $this->validate($request, [
            'date'                  => 'required|after:tomorrow',
            'app_promotion_blog_id' => 'required',
            'booked_for_time'       => 'required',
            'position'              => 'required',
            'slot_image'            => 'required'
        ]);
//        dd($request->all());
        $AppPromotionBlogs = AppPromotionBlogs::find($request->app_promotion_blog_id);

        $date_from                     = mysql_date_time_marge($request->date, $AppPromotionBlogs->from);
        $promotion_time_frame          = $request->booked_for_time;
        $promotion_time_frame_add_days = config('custom_app_setting.blog_promotion_date_frame_add_days');
//dd($promotion_time_frame_add_days[$promotion_time_frame]);
        //get "to_date" : add number of days
        if (isset($promotion_time_frame_add_days[$promotion_time_frame])) {
            $date_to = mysql_add_days($date_from, $promotion_time_frame_add_days[$promotion_time_frame]);
            $date_to = mysql_date_time_marge($date_to, $AppPromotionBlogs->to);
        }

        if (AppPromotionBlogBooking::where('app_promotion_blog_id', $request->app_promotion_blog_id)
            ->where('from_date', '=', $date_from)->where('to_date', '=', $date_to)
            ->where('vendor_id', '=', \Auth::guard('vendor')->user()->id)
            ->exists()) {
            return redirect()->back()->with('error', 'duplicate entry.');
        }

        $AppPromotionBlogSetting             = AppPromotionBlogSetting::find($request->position);
        $slot                                = new AppPromotionBlogBooking;
        $slot->from_date                     = $date_from;
        $slot->to_date                       = $date_to;
        $slot->from_time                     = mysql_time($AppPromotionBlogs->from);
        $slot->to_time                       = mysql_time($AppPromotionBlogs->to);

        $slot->app_promotion_blog_id         = $request->app_promotion_blog_id;
        $slot->price                         = $AppPromotionBlogSetting->blog_price;
        $slot->app_promotion_blog_setting_id = $request->position;
        $slot->is_active                     = 0;
        $slot->vendor_id                     = \Auth::guard('vendor')->user()->id;

        if ($request->has('slot_image')) {
            $filename = time() . '-slot_image-' . rand(100, 999) . '.' . $request->slot_image->extension();
            $request->slot_image->move(public_path('slot-vendor-image'), $filename);
            $slot->image = $filename;
        }

        $slot->save();
//dd($slot);
        $link        = "";
        $msg         = \Auth::guard('vendor')->user()->name . " send promotion request";
        $subscribers = Superadmin::get();
        foreach ($subscribers as $k => $admin)
            $admin->notify(new CreateSlotBookingToAdminNotification($msg, \Auth::guard('vendor')->user()->name, $link)); //With new post
//dd($slot);
//        event(new CreateSlotBooki7ungEvent($slot));
        return redirect()->route('restaurant.shop.promotion')->with('message', 'Successfully booked');
    }

    public function save_product_promotion(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'product_id'            => 'required',
            'date'                  => 'required|after:tomorrow',
            'app_promotion_blog_id' => 'required',
            'booked_for_time'       => 'required',
            'position'              => 'required'
        ]);
//        dd($request->all());
        $AppPromotionBlogs = AppPromotionBlogs::find($request->app_promotion_blog_id);

        $date_from                     = mysql_date_time_marge($request->date, $AppPromotionBlogs->from);
        $promotion_time_frame          = $request->booked_for_time;
        $promotion_time_frame_add_days = config('custom_app_setting.blog_promotion_date_frame_add_days');
//dd($promotion_time_frame_add_days[$promotion_time_frame]);
        //get "to_date" : add number of days
        if (isset($promotion_time_frame_add_days[$promotion_time_frame])) {
            $date_to = mysql_add_days($date_from, $promotion_time_frame_add_days[$promotion_time_frame]);
            $date_to = mysql_date_time_marge($date_to, $AppPromotionBlogs->to);
        }

        if (AppPromotionBlogBooking::where('app_promotion_blog_id', $request->app_promotion_blog_id)
            ->where('from_date', '=', $date_from)->where('to_date', '=', $date_to)
            ->where('vendor_id', '=', \Auth::guard('vendor')->user()->id)
            ->exists()) {
            return redirect()->back()->with('error', 'duplicate entry.');
        }

        $AppPromotionBlogSetting             = AppPromotionBlogSetting::find($request->position);
        $slot                                = new AppPromotionBlogBooking;
        $slot->product_id                    = $request->product_id;
        $slot->from_date                     = $date_from;
        $slot->to_date                       = $date_to;
        $slot->from_time                     = mysql_time($AppPromotionBlogs->from);
        $slot->to_time                       = mysql_time($AppPromotionBlogs->to);

        $slot->app_promotion_blog_id         = $request->app_promotion_blog_id;
        $slot->price                         = $AppPromotionBlogSetting->blog_price;
        $slot->app_promotion_blog_setting_id = $request->position;
        $slot->is_active                     = 1;
        $slot->vendor_id                     = \Auth::guard('vendor')->user()->id;
        $slot->save();

        return redirect()->route('restaurant.product.promotion')->with('message', 'Successfully booked');
    }

}
