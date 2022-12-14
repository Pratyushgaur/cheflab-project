<?php

namespace App\Http\Controllers\api;

use App\Events\DineOutBookingEvent;
use App\Http\Controllers\Controller;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\TableService;
use App\Models\TableServiceBooking;
use App\Models\TableServiceDiscount;
use App\Models\VendorDineoutTime;
use App\Models\VendorOrderTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use URL;
use Validator;


class DineoutApiController extends Controller
{

    public function dine_out_booking(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'vendor_id'                 => 'required|numeric',
                'user_id'                   => 'required|numeric',
                'date'                      => 'required|date',
                'booked_no_guest'           => 'required|numeric',
                'booked_for_customer_phone' => 'required',
                'booked_for_customer_name'  => 'required',
                'booked_slot_time_from'     => 'required',
                'booked_slot_discount'      => 'required|numeric',
            ]);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $TableService = TableService::select('slot_time')
                ->where('vendor_id', $request->vendor_id)
                ->where('is_active', 1)
                ->first();
            if (!isset($TableService->slot_time)) {
                return response()->json(['status' => false, 'error' => "Restaurant not able to accept your booking."], 401);
            }
            $responce = [];

            $booked_slot_time_from = mysql_date_time_marge($request->date, $request->booked_slot_time_from);
            $booked_slot_time_to   = mysql_add_time($booked_slot_time_from, $TableService->slot_time);
            \DB::enableQueryLog();

            //check restaurant is opne during requested time
            $is_restaurant_open = VendorOrderTime::select('day_no', 'start_time', "end_time")
                ->where('vendor_id', $request->vendor_id)
                ->where('day_no', date('w', strtotime($request->date)))
                ->where('available', 1)
                ->where('start_time', '<=', mysql_time($booked_slot_time_from))
                ->where('end_time', '>=', mysql_time($booked_slot_time_to))
                ->exists();
//dd(DB::getQueryLog());
            if (!$is_restaurant_open)
                return response()->json(['status' => false, 'error' => "Restaurant not open during requested time."], 401);

            //get remaining tables
            $booked_table = @TableServiceBooking::where('table_service_bookings.vendor_id', $request->vendor_id)
                ->join('table_services', 'table_services.vendor_id', '=', 'table_service_bookings.vendor_id')
                ->where('booked_slot_time_from', '<=', $booked_slot_time_from)
                ->where('booked_slot_time_to', '>=', $booked_slot_time_to)
                ->where('booking_status', 'accepted')
                ->groupBy('booking_status')
                ->selectRaw('(table_services.no_guest-sum(booked_no_guest)) as available_tables')->first();

            if (isset($booked_table->available_tables) && $booked_table->available_tables <= $request->booked_no_guest) {
                return response()->json(['status' => false, 'error' => "Sorry! $request->booked_no_guest tables not available during this time slot."], 401);
            }

            $TableServiceBooking = new TableServiceBooking();
            $TableServiceBooking = $TableServiceBooking->create([
                "vendor_id"                 => $request->vendor_id,
                "user_id"                   => $request->user_id,
                "booked_no_guest"           => $request->booked_no_guest,
                "booked_slot_time_from"     => $booked_slot_time_from,
                "booked_slot_time_to"       => $booked_slot_time_to,
                "booked_slot_discount"      => $request->booked_slot_discount,
                "booked_for_customer_name"  => $request->booked_for_customer_name,
                "booked_for_customer_phone" => $request->booked_for_customer_phone
            ]);

            if (isset($TableServiceBooking->id)) {
                event(new DineOutBookingEvent($TableServiceBooking, $request->user_id, $request->vendor_id));
                return response()->json(['status' => true, 'message' => 'Your booking request is sent to the restaurant.'], 200);
            } else
                return response()->json(['status' => false, 'error' => "something went wrong."], 401);
        } catch (Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getTrace()], 500);
        }
    }

    /*
    public function get_dine_out_slot(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'vendor_id' => 'required|numeric',
                'date' => 'required|date'
            ]);
            if ($validateUser->fails()) {
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }


            $reponce = [];

            $vendor_order_time = VendorOrderTime::select('day_no', 'start_time', "end_time")
                ->where('vendor_id', $request->vendor_id)
                ->where('day_no', date('w', strtotime($request->date)))
                ->where('available', 1)
                ->get()->toArray();
            $tableservice = TableService::where('vendor_id', $request->vendor_id)->where('is_active', 1)->first();

            //            dd($vendor_order_time);
            if (isset($tableservice->no_guest) && $tableservice->no_guest != 0) {
                //get booked tables'=
                //                $total = TableServiceBooking::select(DB::raw('table_service_bookings.*,DATE_FORMAT(booked_slot_time_from,"%Y-%m-%d") as only_date'))
                //                    ->where('vendor_id', $request->vendor_id)
                //                    ->where('booking_status', 'accepted')
                //                    ->having('only_date', mysql_date($request->date))
                //                    ->groupBy('booked_slot_time_from')
                //                    ->sum('booked_no_guest');
                //dd($total);


                $days[0] = "sunday";
                $days[1] = "monday";
                $days[2] = "tuesday";
                $days[3] = "wednesday";
                $days[4] = "thursday";
                $days[5] = "friday";
                $days[6] = "saturday";

                foreach ($vendor_order_time as $k => $order_time) {
                    $start_time = mysql_date_time_marge($request->date, $order_time['start_time']); //$order_time['start_time'];
                    $end_time = mysql_date_time_marge($request->date, $order_time['end_time']); //$order_time['end_time'];
                    $duration = $tableservice->slot_time;

                    if (date('w') == $order_time['day_no']) {

                        $break = show_time_slots($start_time, date('Y-m-d H:i'), $duration, []); //remove previous time slot
                        // $reponce['days']['date'] = date('Y-m-d H:i');
                        $all_all_slots = show_time_slots($start_time, $end_time, $duration, $break);
                    } else {
                        $break = [];
                        // $reponce['days']['date'] = date('Y-m-d H:i', strtotime('next ' . $days[$order_time['day_no']]));
                        $all_all_slots = show_time_slots($start_time, $end_time, $duration, $break);
                    }
                }
                // dd($all_all_slots);
                \DB::enableQueryLog();

                \Config::set('database.strict', false);

                $booked_slots = TableServiceBooking::query()
                    ->select('table_service_bookings.booked_slot_time_from', 'table_service_bookings.booked_slot_time_to', DB::raw('sum(table_service_bookings.booked_no_guest) as total_booked_no_guest'))
                    ->where('booking_status', 'accepted')
                    ->where('booked_slot_time_from', '>=', $start_time)
                    ->where('booked_slot_time_to', '<=', $end_time)
                    ->where('vendor_id', $request->vendor_id)
                    ->groupBy('booked_slot_time_from', 'booked_slot_time_to')
                    // ->groupBy('table_service_bookings.booked_slot_time_from,table_service_bookings.booked_slot_time_to')
                    //    ->sum('booked_no_guest')
                    ->get();
                //                    ->toArray();
                //                    dd(\DB::getQueryLog ());


                //                $booked_slots = DB::select("select booked_slot_time_from,booked_slot_time_to,sum(booked_no_guest) as total_booked_no_guest "
                //                    . " from `table_service_bookings` "
                //                    . " where `booking_status` = 'accepted' "
                //                    . " and `booked_slot_time_from` >= '2022-09-28 10:00:00' and `booked_slot_time_to` <= '2022-09-28 23:00:00' "
                //                    . " and `vendor_id` = 2  group by `booked_slot_time_from`");
                //    dd($booked_slots->toArray());
                $i = 0;
                $carry_forword = 0;
                foreach ($all_all_slots as $k => $slot_time) {
                    $i++;
                    $slot_time_to = mysql_add_time($slot_time, $tableservice->slot_time);

                    @$reponce['days']['booking_time'][$i] = [
                        "available_no_guest" => $tableservice->no_guest,
                        'time' => $slot_time,
                        "available" => true
                    ];
                    $appoiment_from_second = strtotime($slot_time);
                    $appoinment_to_second = strtotime($slot_time_to);
                    echo "<br/><br/>$slot_time_to";
                    foreach ($booked_slots as $k => $booked_table_services) {

                        $booked_from_time = $booked_table_services->booked_slot_time_from;
                        $booked_to_time = $booked_table_services->booked_slot_time_to;
                        echo "<br/>------------------------- $booked_from_time,---------$booked_to_time<br/>";

                        $booked_time_from_second = strtotime($booked_from_time);
                        $booked_time_to_second = strtotime($booked_to_time);


                        if ($booked_from_time == $slot_time) {
                            echo "$booked_from_time == $slot_time <br>";

                            // $carry_forword = 0;
                            $available_tables = $tableservice->no_guest - $booked_table_services->total_booked_no_guest;
                            if ($available_tables > 0) {
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => $available_tables,
                                    'time' => $slot_time,
                                    "available" => true
                                ];
                            } else if ($available_tables <= 0) {

                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => 0,
                                    'time' => $slot_time,
                                    "available" => false
                                ];
                                if ($booked_from_time == $slot_time && $booked_to_time == $slot_time_to)
                                    unset($booked_slots[$k]);
                                break 1;
                            }
                        } else if ($booked_to_time == $slot_time_to && $booked_from_time != $slot_time) {
                            $available_tables = $tableservice->no_guest - $booked_table_services->total_booked_no_guest;
                            if ($available_tables > 0) {
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => $available_tables,
                                    'time' => $slot_time,
                                    "available" => true
                                ];
                            } else if ($available_tables <= 0) {
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => 0,
                                    'time' => $slot_time,
                                    "available" => false
                                ];
                                unset($booked_slots[$k]);
                        }}
                        //already booked time falls slot current slot
                        else if (in_between($booked_time_from_second, $appoiment_from_second, $appoinment_to_second) && in_between($booked_time_to_second, $appoiment_from_second, $appoinment_to_second)) {
                            echo "already booked time falls slot current slot ----$slot_time,$slot_time_to===================     $booked_from_time,$booked_to_time<br/>";
                            // $carry_forword = 0;
                            $available_tables = $tableservice->no_guest - $booked_table_services->total_booked_no_guest;
                            if ($available_tables > 0)
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => $available_tables,
                                    'time' => $slot_time,
                                    "available" => true
                                ];
                            else
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => 0,
                                    'time' => $slot_time,
                                    "available" => false
                                ];
                            unset($booked_slots[$k]);
                            break 1;
                        }
                        //alredy booked_slot cover more then current_slot
                        else if (in_between($booked_time_from_second, $appoiment_from_second, $appoinment_to_second) || in_between($booked_time_to_second, $appoiment_from_second, $appoinment_to_second)) {
                            // echo "alredy booked_slot cover more then current_slot ----$slot_time,$slot_time_to ----------    $booked_from_time,$booked_to_time<br/>";
                            $available_tables = $tableservice->no_guest - $booked_table_services->total_booked_no_guest;
                            // $available_tables = $available_tables - $carry_forword;
                            // $carry_forword = $booked_table_services->total_booked_no_guest;
                            if ($available_tables <= 0)
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => 0,
                                    'time' => $slot_time,
                                    "available" => false
                                ];
                            else
                                @$reponce['days']['booking_time'][$i] = [
                                    "available_no_guest" => $available_tables,
                                    'time' => $slot_time,
                                    "available" => true
                                ];

                            if (in_between($booked_time_to_second, $appoiment_from_second, $appoinment_to_second)) {
                                unset($booked_slots[$k]);
                                // $carry_forword=0;
                            }

                            break 1;
                        }
                    }
                }
                dd($reponce);
                //                dd($booked_slots);
                return response()->json(['status' => true, 'message' => 'Successfully', 'response' => $reponce], 200);
            } else {
                return response()->json(['status' => false, 'error' => 'Restaurant not able to server for you.'], 401);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }
    }*/


    public function get_dine_out_slot(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'vendor_id' => 'required|numeric',
                'date'      => 'required|date'
            ]);
            if ($validateUser->fails()) {
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }


            $reponce = [];

            $vendor_order_time = @VendorDineoutTime::select('day_no', 'start_time', "end_time")
                ->where('vendor_id', $request->vendor_id)
                ->where('day_no', date('w', strtotime($request->date)))
                ->where('available', 1)
                ->get();
//                ->toArray();
//dd($vendor_order_time[0]);
            if (isset($vendor_order_time[0])) {
//                dd($vendor_order_time);
                $vendor_order_time = $vendor_order_time->toArray();
            } else {
                return response()->json(['status' => false, 'error' => 'Restaurant is not available for today.'], 401);
            }

            $tableservice = TableService::where('vendor_id', $request->vendor_id)->where('is_active', 1)->first();

            if (isset($tableservice->no_guest) && $tableservice->no_guest != 0) {
                //get booked tables'=
                //                $total = TableServiceBooking::select(DB::raw('table_service_bookings.*,DATE_FORMAT(booked_slot_time_from,"%Y-%m-%d") as only_date'))
                //                    ->where('vendor_id', $request->vendor_id)
                //                    ->where('booking_status', 'accepted')
                //                    ->having('only_date', mysql_date($request->date))
                //                    ->groupBy('booked_slot_time_from')
                //                    ->sum('booked_no_guest');
                //dd($total);
                $tableservice_discount = @TableServiceDiscount::select('discount_percent')->where('vendor_id', $request->vendor_id)->where('day_no', date('w', strtotime($request->date)))->first()->toArray();

                $reponce = $tableservice_discount;


                $days[0] = "sunday";
                $days[1] = "monday";
                $days[2] = "tuesday";
                $days[3] = "wednesday";
                $days[4] = "thursday";
                $days[5] = "friday";
                $days[6] = "saturday";
                $all_all_slots=[];
                foreach ($vendor_order_time as $k => $order_time) {
                    $start_time = mysql_date_time_marge($request->date, $order_time['start_time']); //$order_time['start_time'];
                    $end_time   = mysql_date_time_marge($request->date, $order_time['end_time']);   //$order_time['end_time'];
                    $duration   = $tableservice->slot_time;

                    if (date('w') == $order_time['day_no']) {

                        $break = show_time_slots($start_time, date('Y-m-d H:i'), $duration, []); //remove previous time slot
                        // $reponce['days']['date'] = date('Y-m-d H:i');
                        $all_all_slots1 = show_time_slots($start_time, $end_time, $duration, $break);
                    } else {
                        $break = [];
                        // $reponce['days']['date'] = date('Y-m-d H:i', strtotime('next ' . $days[$order_time['day_no']]));
                        $all_all_slots1 = show_time_slots($start_time, $end_time, $duration, $break);
                    }
                    $all_all_slots=array_merge($all_all_slots,$all_all_slots1);
                }
                // dd($all_all_slots);
                \DB::enableQueryLog();

                \Config::set('database.strict', false);


                $booked_slots  = TableServiceBooking::query()
                    ->select('table_service_bookings.booked_slot_time_from', 'table_service_bookings.booked_slot_time_to',
                        DB::raw('sum(table_service_bookings.booked_no_guest) as total_booked_no_guest'))
                    ->where('booking_status', 'accepted')
                    ->where('booked_slot_time_from', '>=', $start_time)
                    ->where('booked_slot_time_to', '<=', $end_time)
                    ->where('vendor_id', $request->vendor_id)
                    ->groupBy('booked_slot_time_from', 'booked_slot_time_to')
                    ->get();
                $i             = 0;
                $carry_forword = 0;
//                dd($all_all_slots);
                foreach ($all_all_slots as $k => $slot_time) {
                    $i++;
                    $slot_time_to = mysql_add_time($slot_time, ($tableservice->slot_time - 1));

                    @$reponce['days']['booking_time'][$i] = [
                        "available_no_guest" => $tableservice->no_guest,
                        'time_from'          => $slot_time,
                        'time_to'            => $slot_time_to,
                        "available"          => true
                    ];

                    // echo "<br/><br/>".mysql_time($slot_time)."-".mysql_time($slot_time_to);
                    foreach ($booked_slots as $k => $booked_table_services) {

                        $booked_from_time = ($booked_table_services->booked_slot_time_from);
                        $booked_to_time   = ($booked_table_services->booked_slot_time_to);


                        if (($slot_time <= $booked_from_time && $booked_from_time <= $slot_time_to)
                            || ($slot_time <= $booked_to_time && $booked_to_time <= $slot_time_to)
                        ) {
//                            echo "($slot_time <= $booked_from_time && $booked_from_time <= $slot_time_to)
//                            || ($slot_time <= $booked_to_time && $booked_to_time <= $slot_time_to)
//                        )";
//                            echo boolval($slot_time <= $booked_from_time && $booked_from_time <= $slot_time_to)
//                            ."|| ".boolval($slot_time <= $booked_to_time && $booked_to_time <= $slot_time_to). "<br/>";


                            @$reponce['days']['booking_time'][$i]['available_no_guest'] = @$reponce['days']['booking_time'][$i]['available_no_guest'] - $booked_table_services->total_booked_no_guest;


                            if (in_between_equal_to($booked_to_time, $slot_time, $slot_time_to))
                                unset($booked_slots[$k]);

                            // echo "<br/>($slot_time <= $booked_from_time && $booked_from_time <= $slot_time_to)<br/>
                            // || ($slot_time <= $booked_to_time && $booked_to_time <= $slot_time_to)---------------------available=" . $reponce['days']['booking_time'][$i]['available_no_guest'];
                        }
                    }
                    if (@$reponce['days']['booking_time'][$i]['available_no_guest'] <= 0)
                        @$reponce['days']['booking_time'][$i]['available'] = false;
                }
//                 dd($reponce);
                return response()->json(['status' => true, 'message' => 'Successfully', 'response' => $reponce], 200);
            } else {
                return response()->json(['status' => false, 'error' => 'Restaurant not able to server for you.'], 401);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }
    }

    public function get_dineout_restaurant(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'lat'           => 'required|numeric',
                    'lng'           => 'required|numeric',
                    'vendor_offset' => 'required|numeric',
                    'vendor_limit'  => 'required|numeric',
                ]
            );
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json([
                    'status' => false,
                    'error'  => $validateUser->errors()->all()

                ], 401);
            }
            $userid = request()->user()->id;

            $where        = ['table_service' => '1', 'vendor_type' => 'restaurant'];
            $vendors      = get_restaurant_near_me($request->lat, $request->lng, $where, request()->user()->id)
                ->addSelect('table_service_discounts.discount_percent')
                ->join('table_services', function ($join) {
                    $join->on('table_services.vendor_id', '=', 'vendors.id')
                        ->where('table_services.is_active', '=', 1);
                })
                ->join('table_service_discounts', function ($join) {
                    $join->on('table_service_discounts.vendor_id', '=', 'vendors.id')
                        ->where('table_service_discounts.day_no', '=', Carbon::now()->dayOfWeek);

                });
            $vendors1     = $vendors;
            $vendor_count = $vendors1->count();
            $vendors      = $vendors->offset($request->vendor_offset)->limit($request->vendor_limit)->get();


//dd($vendors);

//            $products = Product_master::where(['products.status' => '1', 'product_for' => '3'])->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.product_name', 'product_price', 'customizable', \DB::raw('CONCAT("' . asset('products') . '/", product_image) AS image'),'vendors.name as restaurantName','products.id',\DB::raw('if(user_product_like.user_id is not null, true, false)  as is_like'));
//            $products = $products->leftJoin('user_product_like',function($join){
//                $join->on('products.id', '=', 'user_product_like.product_id');
//                $join->where('user_product_like.user_id', '=',request()->user()->id );
//            });
//            $products = $products->orderBy('products.id', 'desc')->get();
//            dd($vendors);
            foreach ($vendors as $key => $value) {
                $vendors[$key]->cuisines       = Cuisines::whereIn('cuisines.id', explode(',', $value->deal_cuisines))->pluck('name');
                $category                      = Catogory_master::whereIn('id', explode(',', $value->deal_categories))->pluck('name');
                $vendors[$key]->categories     = $category;
                $vendors[$key]->next_available = next_available_day($value->id);
            }

            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => [
                    'vendor_total_records' => $vendor_count,
                    'vendors'              => $vendors]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }


    public function get_booked_dineout_detail(Request $request)
    {

        try {
            $validateUser = Validator::make($request->all(), ['vendor_id' => 'required|numeric']);
            if ($validateUser->fails()) {
                $error = $validateUser->errors();
                return response()->json(['status' => false, 'error' => $validateUser->errors()->all()], 401);
            }
            $table_service_booking = TableServiceBooking::select('vendor_id', 'user_id', 'booking_status', 'booked_no_guest', 'booked_slot_time_from', 'booked_slot_time_to', 'booked_slot_discount')->where('user_id', auth()->user()->id)->where('vendor_id', $request->vendor_id)->first();


            return response()->json([
                'status'   => true,
                'message'  => 'Data Get Successfully',
                'response' => ['table_service_booking' => $table_service_booking]

            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'error'  => $th->getMessage()
            ], 500);
        }
    }

}
