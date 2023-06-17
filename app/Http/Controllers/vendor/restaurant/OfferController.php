<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorOffers;
use Illuminate\Support\Facades\Crypt;

use DataTables;
use Config;
use Auth;
class OfferController extends Controller
{
    public function index(Request $request)
    {
        return view('vendor.restaurant.offers.list');

    }
    public function get_data_table_of_offer(Request $request)
    {
        if ($request->ajax()) {
            $vendor_id = \Auth::guard('vendor')->user()->id;
           // $data = Coupon::latest()->get();
           $data = VendorOffers::where('vendor_id', '=', $vendor_id)->select('id','offer_persentage','from_date','to_date','created_at','status')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("restaurant.offer.edit",Crypt::encryptString($data->id)) .'"><i class="fa fa-edit"></i></a>
                    <a href="' . route('restaurant.offer.delete',Crypt::encryptString($data->id)) . '"    data-action-url="" title="Delete" class="delete-offer"><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('status', function($data){
                    if ($data->status == 1) {
                        $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round couponOff" data-id="' . $data->id . '"></span></label>';
                    } elseif($data->status == 0) {
                        $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round  couponON" data-id="' . $data->id . '""></span></label>';
                    }
                    return $btn;
                })

                ->addColumn('expired', function($data){
                    if( \Carbon\Carbon::now()->gte($data->to_date)){
                        return '<b class="text-danger">Expired</b>';
                    }elseif(\Carbon\Carbon::now()->lt($data->from_date)){
                        return '<b class="text-warning">Waiting</b>';
                    }elseif(\Carbon\Carbon::now()->gte($data->from_date) && \Carbon\Carbon::now()->lte($data->to_date)){
                        return '<b class="text-success">Running</b>';
                    }
                })
                ->addColumn('from_date', function($data){
                    return date('d-m-Y',strtotime($data->from_date));
                })
                ->addColumn('to_date', function($data){
                    return date('d-m-Y',strtotime($data->to_date));
                })
                ->rawColumns(['date','action-js','status','expired','from_date','to_date'])
                ->make(true);
        }
    }
    public function create_offer(){
         return view('vendor.restaurant.offers.create_offer');
     }
    public function store_offer(Request $request)
    {
        $this->validate($request, [
            'offer_persentage' => 'required|numeric|min:1|max:100',
            'from_date' => 'required|date',
            'end_date' => 'required|date'
        ]);
        $startDate = mysql_date($request->from_date);
        $endDate = mysql_date($request->end_date);
        
        $check = VendorOffers::where(function ($query) use ($startDate, $endDate) {
            $query->whereDate('from_date', '<=', $startDate)
                    ->whereDate('to_date', '>=', $endDate)
                    ->where('vendor_id','=', Auth::guard('vendor')->user()->id);

        })
        ->orWhere(function ($query) use ($startDate, $endDate) {
            $query->whereDate('from_date', '>=', $startDate)
                  ->WhereDate('from_date', '<=', $endDate)
                  ->where('vendor_id','=', Auth::guard('vendor')->user()->id);

        })
        ->orWhere(function ($query) use ($startDate, $endDate) {
            $query->whereDate('to_date', '<=', $endDate)
                ->WhereDate('to_date', '>=', $startDate)
                ->where('vendor_id','=', Auth::guard('vendor')->user()->id);

        })->exists();
        if($check){
            //return redirect()->back()->withErro('Already Exist Offer in this time');
            return \Redirect::back()->withErrors(['msg' => 'Already Exist Offer in this time Interval']);

        }
        $coupon = new VendorOffers;
        $coupon->offer_persentage = $request->offer_persentage;
        $coupon->offer_persentage = $request->offer_persentage;
        $coupon->from_date  = mysql_date_time($request->from_date);
        $coupon->to_date  = mysql_date_time($request->end_date);
        $coupon->vendor_id = Auth::guard('vendor')->user()->id;
        $coupon->status ="1";
        $coupon->save();
        return redirect()->route('restaurant.offers.list')->with('message', 'Offer Create Successfully');

    }
    public function editOffer($encrypt_id){
        try {
            $id =  \Crypt::decryptString($encrypt_id);
            $VendorOffers = VendorOffers::findOrFail($id);
           // dd($city_data);
            return view('vendor.restaurant.offers.edit_offer',compact('VendorOffers'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
        
    }
    function updateOffer(Request $request,$id) {
        
        $this->validate($request, [
            'offer_persentage' => 'required|numeric|min:1|max:100',
            'from_date' => 'required|date',
            'end_date' => 'required|date'
        ]);
        $startDate = mysql_date($request->from_date);
        $endDate = mysql_date($request->end_date);
        $check = VendorOffers::where(function ($query) use ($startDate, $endDate ,$id) {
            $query->whereDate('from_date', '<=', $startDate)
                    ->whereDate('to_date', '>=', $endDate)
                    ->where('vendor_id','=', Auth::guard('vendor')->user()->id)
                    ->where('id','!=', $id);

        })
        ->orWhere(function ($query) use ($startDate, $endDate ,$id) {
            $query->whereDate('from_date', '>=', $startDate)
                  ->WhereDate('from_date', '<=', $endDate)
                  ->where('vendor_id','=', Auth::guard('vendor')->user()->id)
                  ->where('id','!=', $id);

        })
        ->orWhere(function ($query) use ($startDate, $endDate,$id) {
            $query->whereDate('to_date', '<=', $endDate)
                ->WhereDate('to_date', '>=', $startDate)
                ->where('vendor_id','=', Auth::guard('vendor')->user()->id)
                ->where('id','!=', $id);

        })->exists();
        if($check){
            return \Redirect::back()->withErrors(['msg' => 'Already Exist Offer in this time Interval']);
        }
        $coupon = VendorOffers::findOrFail($id);
        $coupon->offer_persentage = $request->offer_persentage;
        $coupon->from_date  = mysql_date_time($request->from_date);
        $coupon->to_date  = mysql_date_time($request->end_date);
        
        $coupon->save();
        return redirect()->route('restaurant.offers.list')->with('message', 'Offer Updated Successfully');
    }

    function delete ($encrypt_id){
        try {
            $id =  \Crypt::decryptString($encrypt_id);
            $VendorOffers = VendorOffers::findOrFail($id);
            $VendorOffers->delete();
           // dd($city_data);
            return redirect()->route('restaurant.offers.list')->with('message', 'Offer Updated Successfully');

        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
}
