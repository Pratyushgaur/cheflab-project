<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TableService;
use App\Models\TableServiceBooking;
use App\Models\VendorOrderTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Throwable;
use URL;
use Validator;


class DineoutController extends Controller
{

    public function dine_out_booking(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(), [
                'vendor_id' => 'required|numeric',
                'user_id' => 'required|numeric',
                'date' => 'required|date',
                'booked_no_guest' => 'required|numeric',
                'booked_slot_time_from' => 'required',
                'booked_slot_discount' => 'required|numeric',
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
            $booked_slot_time_to = mysql_add_time($booked_slot_time_from, $TableService->slot_time);
            \DB::enableQueryLog();

            //check restaurant is opne during requested time
            $is_restaurant_open = VendorOrderTime::select('day_no', 'start_time', "end_time")
                ->where('vendor_id', $request->vendor_id)
                ->where('day_no', date('w', strtotime($request->date)))
                ->where('available', 1)
                ->where('start_time', '<=', mysql_time($booked_slot_time_from))
                ->where('end_time', '>=', mysql_time($booked_slot_time_to))
                ->exists();
//    dd(\DB::getQueryLog ());

            if (!$is_restaurant_open)
                return response()->json(['status' => false, 'error' => "Restaurant not open during requested time."], 401);
            $booked_table = TableServiceBooking::where('vendor_id', $request->vendor_id)
                ->where('booked_slot_time_from', '<=', $booked_slot_time_from)
                ->where('booked_slot_time_to', '>=', $booked_slot_time_to)
                ->where('booking_status', 'accepted')
                ->exists();
            if ($booked_table) {
                return response()->json(['status' => false, 'error' => "We can not book this for you, already this slot have booking."], 401);
            }
//            dd($booked_table);
            $TableServiceBooking = new TableServiceBooking();
            $s = $TableServiceBooking->create([
                "vendor_id" => $request->vendor_id,
                "user_id" => $request->user_id,
                "booked_no_guest" => $request->booked_no_guest,
                "booked_slot_time_from" => $booked_slot_time_from,
                "booked_slot_time_to" => $booked_slot_time_to,
                "booked_slot_discount" => $request->booked_slot_discount
            ]);
            if (isset($s->id))
                return response()->json(['status' => true, 'message' => 'Your booking request send to restaurant.'], 200);
            else
                return response()->json(['status' => false, 'error' => "something went wrong."], 401);

        } catch (Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }
    }

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
                    $start_time = mysql_date_time_marge($request->date, $order_time['start_time']);//$order_time['start_time'];
                    $end_time = mysql_date_time_marge($request->date, $order_time['end_time']);//$order_time['end_time'];
                    $duration = $tableservice->slot_time;

                    if (date('w') == $order_time['day_no']) {
                        $break = show_time_slots($start_time, date('Y-m-d H:i'), $duration, []);//remove previous time slot
                        $reponce['days']['date'] = date('Y-m-d H:i');
                        $all_all_slots = show_time_slots($start_time, $end_time, $duration, $break);
                    } else {
                        $break = [];
                        $reponce['days']['date'] = date('Y-m-d H:i', strtotime('next ' . $days[$order_time['day_no']]));
                        $all_all_slots = show_time_slots($start_time, $end_time, $duration, $break);
                    }
                }
                \DB::enableQueryLog();

                \Config::set('database.strict',false);

                $booked_slots = TableServiceBooking::query()
                ->select('table_service_bookings.booked_slot_time_from','table_service_bookings.booked_slot_time_to',DB::raw('sum(table_service_bookings.booked_no_guest) as total_booked_no_guest'))
                    ->where('booking_status', 'accepted')
                    ->where('booked_slot_time_from', '>=', '$start_time')
                    ->where('booked_slot_time_to', '<=', '$end_time')
                    ->where('vendor_id', $request->vendor_id)
                    ->groupBy('booked_slot_time_from','booked_slot_time_to')
                    ->groupBy('table_service_bookings.booked_slot_time_from,table_service_bookings.booked_slot_time_to')
//                    ->sum('booked_no_guest')
                    ->get();
//                    ->toArray();
//                    dd(\DB::getQueryLog ());


//                $booked_slots = DB::select("select booked_slot_time_from,booked_slot_time_to,sum(booked_no_guest) as total_booked_no_guest "
//                    . " from `table_service_bookings` "
//                    . " where `booking_status` = 'accepted' "
//                    . " and `booked_slot_time_from` >= '2022-09-28 10:00:00' and `booked_slot_time_to` <= '2022-09-28 23:00:00' "
//                    . " and `vendor_id` = 2  group by `booked_slot_time_from`");
//                dd($booked_slots);
                $i = 0;
                foreach ($all_all_slots as $k => $slot_time) {
                    $i++;
                    $slot_time_to = mysql_add_time($slot_time, $tableservice->slot_time);
//                    echo "loop for $slot_time-$slot_time_to<br/>";

                    foreach ($booked_slots as $k => $booked_table_services) {
                        $booked_from_time = $booked_table_services->booked_slot_time_from;
                        $booked_to_time = $booked_table_services->booked_slot_time_to;
                        if ($booked_from_time == $slot_time) {

                            @$reponce['days']['booking_time'][$i] = [
                                "available_no_guest" => $tableservice->no_guest - $booked_table_services->total_booked_no_guest,
                                'time' => $slot_time,
                                "status" => "Not available"];
                            break;
                        } else if (($booked_from_time <= $slot_time && $slot_time < $booked_to_time) //requested slot time between already booked time
                            || ($booked_from_time <= $slot_time_to && $slot_time_to < $booked_to_time)
                        ) {
                            @$reponce['days']['booking_time'][$i] = ["available_no_guest" => $tableservice->no_guest - $booked_table_services->total_booked_no_guest, 'time' => $slot_time, "status" => "Not available"];
                            break;
                        } else
                            @$reponce['days']['booking_time'][$i] = ["available_no_guest" => $tableservice->no_guest - $booked_table_services->total_booked_no_guest, 'time' => $slot_time, "status" => "Available"];
                    }
                }
//                exit();
//                dd($booked_slots);
                return response()->json(['status' => true, 'message' => 'Dislike Successfully', 'response' => $reponce], 200);
            } else {
                return response()->json(['status' => false, 'error' => 'Restaurant not able to server for you.'], 401);
            }
        } catch (Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }
    }

}
