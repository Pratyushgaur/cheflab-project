<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Events\CreateSlotBookingEvent;
use App\Http\Controllers\Controller;
use App\Models\RootImage;
use App\Models\SloteBook;
use App\Models\SloteMaster;
use Auth;
use Config;
use DataTables;
use Illuminate\Http\Request;

class VendorPromotionController extends Controller
{
    public function index()
    {
        return view('vendor.restaurant.promotion.list');
    }

    public function create_promotion()
    {
        $for = [];
        if (@Auth::guard('vendor')->user()->vendor_type == 'chef')
            $for = ['chef' => "Chef Promotion"];
        else if (@Auth::guard('vendor')->user()->vendor_type == 'restaurant')
            $for = ['restaurant' => "Restaurant Promotion"];
//        if (@Auth::guard('vendor')->user()->table_service == 1)
//            $for['dineout'] = "Dine-out Promotion";

        $for["order_traking"] = "Order Tracking Banner";

        $slot = RootImage::where('is_active', '=', '1')->select('id', 'price')->get();
        return view('vendor.restaurant.promotion.create', compact('slot', 'for'));
    }

    public function selctvalue(Request $request)
    {
        //  return  $request->input();die;
        $id = $request->banner;
        // var_dump($id);die;
        $data = SloteMaster::where('id', '=', $id)->select('id', 'price')->get();
        // dd($slot);
        return response()->json([$data]);
        //return $data;
    }

    public function store_slot(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'date'            => 'required|after:tomorrow',
            'booked_for'      => 'required',
            'slot_image'      => 'required',
            'booked_for_time' => 'required',
            'position'        => 'required',
            'for'             => 'required',
            'price'           => 'required'
        ]);
//        dd($request->all());
        $time_frame = explode('-', $request->booked_for_time);

        $date_from                     = mysql_date_time_marge($request->date, $time_frame[0]);
        $promotion_time_frame          = $request->booked_for;
        $promotion_time_frame_add_days = config('custom_app_setting.promotion_date_frame_add_days');

        //get "to_date" : add number of days
        if (isset($promotion_time_frame_add_days[$promotion_time_frame])) {
            $date_to = mysql_add_days($date_from, $promotion_time_frame_add_days[$promotion_time_frame]);
            $date_to = mysql_date_time_marge($date_to, $time_frame[1]);
        }

        if (SloteBook::where('from_date', '=', $date_from)->where('to_date', '=', $date_to)
            ->where('vendor_id', '=', Auth::guard('vendor')->user()->id)->where('from_time', $time_frame[0])
            ->where('to_time', $time_frame[1])->exists()) {
            return redirect()->back()->with('error', 'duplicate entry.');
        }

        $slot                          = new SloteBook;
        $slot->from_date               = $date_from;
        $slot->to_date                 = $date_to;
        $slot->from_time               = $time_frame[0];
        $slot->to_time                 = $time_frame[1];
        $slot->cheflab_banner_image_id = $request->id;
        $slot->price                   = $request->price;
        $slot->cheflab_banner_image_id = $request->position;
        $slot->for                     = $request->for;
        $slot->vendor_id               = Auth::guard('vendor')->user()->id;

        if ($request->has('slot_image')) {
            $filename = time() . '-slot_image-' . rand(100, 999) . '.' . $request->slot_image->extension();
            $request->slot_image->move(public_path('slot-vendor-image'), $filename);
            $slot->slot_image = $filename;
        }

        $slot->save();
        event(new CreateSlotBookingEvent($slot));
        return redirect()->route('restaurant.promotion.list')->with('message', 'Slot successfully booked');
    }

    public function get_list_slotbook(Request $request)
    {
        if ($request->ajax()) {
            $vendor_id = Auth::guard('vendor')->user()->id;
            $data      = SloteBook::join('cheflab_banner_image', 'cheflab_banner_image.id', 'slotbooking_table.cheflab_banner_image_id')
                ->where('vendor_id', $vendor_id)
                ->select('position', 'cheflab_banner_image_id', \DB::raw('DATE_FORMAT(from_date,"%D %b %y") as from_date'), \DB::raw('DATE_FORMAT(to_date,"%D %b %y") as to_date'),
                    \DB::raw('DATE_FORMAT(from_time,"%r") as from_time'), \DB::raw('DATE_FORMAT(to_time,"%r") as to_time'),
                    'name', 'slot_image', 'slotbooking_table.is_active')->get();
            //  $data = \App\Models\SloteBook::where(['slotbooking_table.slot_status'=>'0'])->join('vendors','slotbooking_table.vendor_id','=','vendors.id')->select('slotbooking_table.banner','slot_id','date','slot_image','slot_status','vendors.name as restaurantName')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('is_active', function ($data) {
                    if (!empty($data->is_active) && ($data->is_active == 1))
                        $return = '<span class="badge badge-success">Active</span>';
                    else if (!empty($data->is_active) && ($data->is_active == 2))
                        $return = '<span class="badge badge-danger">Rejected</span>';
                    else
                        $return = '<span class="badge badge-primary">Pending</span>';
                    return $return;
//                    return $status_class = (!empty($data->is_active)) && ($data->is_active) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-primary">Pending</span>';
                    return '<input type="checkbox" name="my-checkbox" checked data-bo/otstrap-switch data-off-color="danger" data-on-color="success">';
                })
                ->addColumn('slot_image', function ($data) {
                    return "<img src=" . asset('slot-vendor-image') . '/' . $data->slot_image . "  style='width: 50px;' />";
                })
//                ->addColumn('payment', function ($appPromotionBlogBooking) {
//                    $btn='';
//                    if (!$appPromotionBlogBooking->payment_status) {
//                        $btn= '<form action = "' . route("payment") . '" method = "POST" >
//                                                    <script src              = "https://checkout.razorpay.com/v1/checkout.js"
//                                                            data-key         = "' . env('RAZOR_KEY') . '"
//                                                            data-amount      = "' . ($appPromotionBlogBooking->app_promotion_setting->blog_price * 100) . '"
//                                                            data-buttontext  = "Pay ' . ($appPromotionBlogBooking->app_promotion_setting->blog_price) . ' INR"
//                                                            data-name        = "' . env('APP_NAME') . '"
//                                                            data-description = "Payment for Promotion :'.$appPromotionBlogBooking->app_promotion_blog->name . ' for position '. $appPromotionBlogBooking->app_promotion_setting->blog_position.'"
//                                                            data-prefill.name = "'.$appPromotionBlogBooking->app_promotion_blog->name.'"
//                                                            data-prefill.email = "'. \Auth::guard('vendor')->user()->email.'"
//                                                            data-prefill.contact = "'.\Auth::guard('vendor')->user()->mobile.'"
//                                                            data-theme.color = "#ff7529">
//                                                    </script >
//                                                    <input type = "hidden" name = "_token" value = "'.csrf_token().'" >
//                                                    <input type = "hidden" name = "id" value = "'.$appPromotionBlogBooking->id.'" >
//
//                                                </form >';
//                    }
//                    return $btn;
//
//                })
//
//                ->rawColumns([ 'from_date', 'is_active', 'slot_image' ])
                ->rawColumns(['is_active', 'slot_image', 'from_date', 'to_date', 'from_time', 'to_time', 'is_active', 'slot_image', 'position'])
                ->make(true);
        }
    }
//    public function checkdate(Request $request){
//         $date = $request->id;
//        $vendor_id = Auth::guard('vendor')->user()->id;
////        var_dump($date);die;
//
////        $from_
//        if (SloteBook::where('date','=',$date)->where('vendor_id','=',$vendor_id)->exists()) {
//            return \Response::json(false);
//          // return redirect()->route('restaurant.promotion.create')->with('message', 'SlotBook');
//        }elseif(SloteBook::where('date','=',$date)->exists()){
//            $wordlist =  \App\Models\SloteBook::where('date', '=', $date)->get();
//
//            foreach($wordlist as $k =>$v){
//               // $data[] = array('variant_name' =>$v ,'price' =>$request->price[$k]);
//
//               $slot =SloteMaster::where('id','!=',$v['id'])->select('id','price','slot_name')->get();
//               return \Response::json($slot);
//
//            }
//           // $wordCount = $wordlist->count();
//
//        }else{
//            $slot =SloteMaster::where('status','=','1')->select('id','price','slot_name')->get();
//            return \Response::json($slot);
//        }
//    }
    public function checkdate(Request $request)
    {
        $promotion_time_frame = $request->id;
        $vendor_id            = Auth::guard('vendor')->user()->id;
        $time                 = explode('-', $request->time);
        if (!isset($time[0]) || !isset($time[1]))
            return response()->json([
                'status'  => false,
                'message' => ''
            ], 200);


        $date_from                     = mysql_date_time_marge($request->date, $time[0]);
        $promotion_time_frame_add_days = config('custom_app_setting.promotion_date_frame_add_days');

        //get "to_date" : add munber of days
        if (isset($promotion_time_frame_add_days[$promotion_time_frame])) {
            $date_to = mysql_add_days($date_from, $promotion_time_frame_add_days[$promotion_time_frame]);
            $date_to = mysql_date_time_marge($date_to, $time[1]);
        } else
            return response()->json([
                'status'  => false,
                'message' => ''
            ], 200);


        //same request already exists/
        if (SloteBook::where('for', '=', $request->banner_for)->where('from_date', '=', $date_from)->where('to_date', '=', $date_to)
            ->where('vendor_id', '=', $vendor_id)->where('from_time', $time[0])->exists()) {
            return response()->json([
                'status'  => false,
                'message' => 'Duplicate request'
            ], 200);

        }

        //get current restaurant location
        $lat        = Auth::guard('vendor')->user()->lat;
        $lng        = Auth::guard('vendor')->user()->long;
        $vendor_ids = get_restaurant_ids_near_me($lat, $lng);

        //if no vendor found, that means all slotes available for current vendor
        if (empty($vendor_ids)) {
            $slot = RootImage::where('is_active', '=', '1')->where('banner_for', '=', $request->banner_for)->select('id', 'price', \DB::raw('name as slot_name'))->get();
            return \Response::json($slot);
        }


        //eliminate already booked slots
        $booked_slot_ids = SloteBook::where('for', '=', $request->banner_for)->where(function ($q) use ($date_to, $date_from, $time) {
            $q->where(function ($q) use ($date_to, $date_from) {
                $q->where([['from_date', '>=', $date_from], ['from_date', '<=', $date_to]])
                    ->orWhere([['to_date', '>=', $date_from], ['to_date', '<=', $date_to]]);
            })
                ->where('from_time', $time[0])->where('to_time', $time[1]);
        })->where('is_active', '=', '1')
            ->whereIn('vendor_id', $vendor_ids)->pluck('cheflab_banner_image_id');

        $slotMaster = RootImage::where('is_active', '=', '1')->where('banner_for', '=', $request->banner_for)->select('id', 'price', \DB::raw('name as slot_name'));

        if (!empty($booked_slot_ids)) {
            $slotMaster->whereNotIn('id', $booked_slot_ids);
        }
        $slot = $slotMaster->limit(config('custom_app_setting.promotion_banner_number_of_slides'))->get();

        if (isset($slot[0]))
            return \Response::json($slot);
        else
            return response()->json([
                'status'  => false,
                'message' => 'No slots available'
            ], 200);
    }

    public function getPrice(Request $request)
    {
        $id = $request->id;
        //  var_dump($id);die;
        $slot = RootImage::where('id', '=', $id)->select('id', 'price', \DB::raw('name as slot_name'), 'position')->first();
        return \Response::json($slot);
    }

    public function getslot(Request $request)
    {
        $date = $request->id;
        // var_dump($date);die;
        if (SloteBook::where('date', '=', $date)->exists()) {
            return \Response::json(false);
            // return redirect()->route('restaurant.promotion.create')->with('message', 'SlotBook');
        } else {
            return \Response::json(true);
        }
    }

//    public function shop_promotion(Request $request)
//    {
//        return view('vendor.restaurant.promotion.shop_promotion');
//    }
//
//    public function crate_shop_promotion()
//    {
//        return view('vendor.restaurant.promotion.create_shop_promotion');
//    }
}
