<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\AdminMasters;
use App\Models\TableService;
use App\Models\TableServiceBooking;
use App\Models\TableServiceDiscount;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DineoutController extends Controller
{
    public function dine_out_globle_setting()
    {
        $table_service = TableService::where('vendor_id', \Auth::guard('vendor')->user()->id)->first();
        if (!$table_service)
            $table_service = new TableService();

        $TableServiceDiscount = @TableServiceDiscount::where('vendor_id', \Auth::guard('vendor')->user()->id)->get();
        return view('vendor.restaurant.dineout.setting', compact('table_service', 'TableServiceDiscount'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin_master=AdminMasters::select('dine_out_reject_reason')->find(config('custom_app_setting.admin_master_id'));
        $TableServiceBookings = TableServiceBooking::select('table_service_bookings.*', 'users.name')
            ->join('users', 'user_id', '=', 'users.id')
            ->where('vendor_id', \Auth::guard('vendor')->user()->id)->orderBy('id', 'desc')->paginate(15);

        return view('vendor.restaurant.dineout.index', compact('TableServiceBookings','admin_master'));
    }

    public function dine_out_accept($id)
    {
        $booking                 = TableServiceBooking::find($id);
        $booking->booking_status = 'accepted';
        $booking->save();
        return response()->json([
            'status'         => 'success',
            'booking_status' => 'Accepted',
            'msg'            => "# $id accepted"
        ], 200);
    }


    public function dine_out_reject(Request $request, $id)
    {
        $booking                 = TableServiceBooking::find($id);
        $booking->booking_status = 'rejected';
        $booking->reject_reason  = $request->reject_reason;
        $booking->save();
        return redirect()->route('restaurant.dineout.index')->with('success', 'Dien-out booking request rejected');
//        return response()->json([
//            'status'         => 'success',
//            'booking_status' => 'Rejected',
//            'msg'            => "# $id rejected"
//        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dine_out_setting(Request $request)
    {
        if (isset($request->is_active) && $request->is_active == 1) {
            $msg = 'Dine-out is active.';
            $d   = 1;
        } else {
            $msg = 'Dine-out is deactive.';
            $d   = 0;
        }
        $table_service            = TableService::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        $table_service->is_active = $d;
        $table_service->save();


        return response()->json([
            'status'      => 'success',
            'rest_status' => $d,
            'msg'         => $msg
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function vendor_table_setting(Request $request)
    {

        if (isset($request->vendor_table_service) && $request->vendor_table_service == 'true') {
            $msg  = 'Dine-out enable for your restaurant.';
            $data = '1';
        } else {
            $msg  = 'Dine-out disable for your restaurant.';
            $data = '0';
        }

        $vendor = Vendors::find(Auth::guard('vendor')->user()->id);

        $vendor->table_service = $data;
        $vendor->save();


        return response()->json([
            'status'      => 'success',
            'rest_status' => $request->vendor_table_service,
            'msg'         => $msg
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        dd($request->all());
        $request->validate(
            [
                'no_guest'           => 'required|numeric',
                'slot_time'          => 'required|numeric',
                'discount_percent.*' => 'required|numeric'
            ]
        );

        $data = [
            'no_guest'  => $request->no_guest,
            'slot_time' => $request->slot_time,
            'vendor_id' => Auth::guard('vendor')->user()->id
        ];
        TableService::updateOrCreate(['vendor_id' => Auth::guard('vendor')->user()->id], $data);
        foreach ($request->discount_percent as $k => $d) {
            $discount = ['discount_percent' => $d];

            TableServiceDiscount::updateOrCreate(['vendor_id' => Auth::guard('vendor')->user()->id, 'day_no' => $k], $discount);
        }
        return redirect()->route('restaurant.dineout.index')->with('success', 'Dien-out settings update successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
