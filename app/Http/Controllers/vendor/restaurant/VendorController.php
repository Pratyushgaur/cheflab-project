<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\VendorOffline;
use App\Models\vendors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function set_offline(Request $request)
    {
        // dd(strtotime( "next monday" ));
        if ($request->offline_till == 1) {
            $day[0] = 'sunday';
            $day[1] = 'monday';
            $day[2] = 'Tuesday';
            $day[3] = 'Wednesday';
            $day[4] = 'Thursday';
            $day[5] = 'friday';
            $day[6] = 'saturday';
            $resum_date = '';
            // dd($request->all());
            // dd(Carbon::now()->dayOfWeek);
            $timeSchedule =  \App\Models\VendorOrderTime::where([
                'vendor_id' => Auth::guard('vendor')->user()->id,
                'available' => 1,
            ])->orderBy('day_no')->pluck('start_time', 'day_no')->toArray(); //Array key will be day_no
            // dd(array_key_last($timeSchedule));
            // print_r($timeSchedule);
            if (array_key_last($timeSchedule) > Carbon::now()->dayOfWeek) {
                for ($i = (Carbon::now()->dayOfWeek + 1); $i <= 6; $i++)
                    if (isset($timeSchedule[$i])) {
                        $resum_date = date('Y-m-d H:i:s', strtotime("next " . $day[$i]));
                    }
            } else {
                $day_no = array_key_first($timeSchedule);
                $resum_date = date('Y-m-d H:i:s', strtotime("next " . $day[$day_no]));
            }
            // dd($timeSchedule);

            $vendor_offline=new VendorOffline();
            $vendor_offline->vendor_id=Auth::guard('vendor')->user()->id;
            $vendor_offline->offline_time=now();
            $vendor_offline->resume_date=$resum_date;
            $vendor_offline->is_action_taken=0;

            $vendor_offline->save();

            $msg = 'Now your Restaurant is offline. It will be automatically goes online  on ' . date('d M Y', strtotime($resum_date));
        } else
            $msg = 'Now your Restaurant is offline.';
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 0]);
        $data = ['status' => 'success', 'msg' => $msg];
        return response()->json($data, 200);
        // return redirect()->back()->with('success', $msg);
    }
    /*public function set_online(Request $request)
    {
        vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 1]);
        return redirect()->back()->with('success', 'Now your Restauran is online.');
    }
    */
    public function restaurent_status(Request $request)
    {

        if ($request->restaurent_status == 'on') {
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 1]);
            $data = ['status' => 'success', 'msg' => 'Now your restaurant is online', 'rest_status' => 'on'];
        } else {
            vendors::where('id', Auth::guard('vendor')->user()->id)->update(['is_online' => 0]);
            $data = ['status' => 'success', 'msg' => 'Now your restaurant is offline,you will not able to get orders from mobile app.', 'rest_status' => 'on'];
        }
        return response()->json($data, 200);
    }
    public function restaurent_get_status(Request $request)
    {

        $v = vendors::find(Auth::guard('vendor')->user()->id);
        $data = ['status' => 'success', 'rest_status' => $v->is_online];

        return response()->json($data, 200);
    }
}
