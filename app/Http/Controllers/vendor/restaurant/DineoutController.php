<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\TableService;
use App\Models\Vendors;
use App\Models\TableServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DineoutController extends Controller
{
    public function dine_out_globle_setting()
    {
        $table_service = TableService::where('vendor_id', \Auth::guard('vendor')->user()->id)->first();
        if (!$table_service)
            $table_service = new TableService();
        return view('vendor.restaurant.dineout.setting', compact('table_service'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $TableServiceBookings = TableServiceBooking::select('table_service_bookings.*', 'users.name')
            ->join('users', 'user_id', '=', 'users.id')
            ->where('vendor_id', \Auth::guard('vendor')->user()->id)->get();
//dd($TableServiceBookings);
        return view('vendor.restaurant.dineout.index', compact('TableServiceBookings'));
    }

    public function dine_out_accept($id)
    {
        $booking = TableServiceBooking::find($id);
        $booking->booking_status = 'accepted';
        $booking->save();
        return response()->json([
            'status' => 'success',
            'booking_status' => 'Accepted',
            'msg' => "# $id accepted"
        ], 200);
    }


    public function dine_out_reject($id)
    {
        $booking = TableServiceBooking::find($id);
        $booking->booking_status = 'rejected';
        $booking->save();
        return response()->json([
            'status' => 'success',
            'booking_status' => 'Rejected',
            'msg' => "# $id rejected"
        ], 200);
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
            $d = 1;
        } else {
            $msg = 'Dine-out is deactive.';
            $d = 0;
        }
        $table_service = TableService::where('vendor_id', Auth::guard('vendor')->user()->id)->first();
        $table_service->is_active = $d;
        $table_service->save();


        return response()->json([
            'status' => 'success',
            'rest_status' => $d,
            'msg' => $msg
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
        if (isset($request->vendor_table_service) && $request->vendor_table_service == 1) {
            $msg = 'Dine-out enable for your restaurant.';
            $data = '1';
        } else {
            $msg = 'Dine-out disable for your restaurant.';
            $data = '0';
        }
        
        $vendor = Vendors::find(Auth::guard('vendor')->user()->id);

        $vendor->table_service = $data;
        $vendor->save();


        return response()->json([
            'status' => 'success',
            'rest_status' => $request->vendor_table_service,
            'msg' => $msg
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
        $request->validate(
            [
                'no_guest' => 'required|numeric',
                'slot_time' => 'required|numeric',
                'slot_discount' => 'required|numeric'
            ]
        );
//dd($request->all());
        $data = [
            'no_guest' => $request->no_guest,
            'slot_time' => $request->slot_time,
            'slot_discount' => $request->slot_discount,
            'vendor_id' => Auth::guard('vendor')->user()->id
        ];
        TableService::updateOrCreate(['vendor_id' => Auth::guard('vendor')->user()->id], $data);
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
