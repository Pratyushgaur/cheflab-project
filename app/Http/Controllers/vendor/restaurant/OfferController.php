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
           $data = VendorOffers::where('vendor_id', '=', $vendor_id)->select('offer_persentage','from_date','to_date','created_at','status')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("restaurant.coupon.edit",Crypt::encryptString($data->id)) .'"><i class="fa fa-edit"></i></a>
                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '"  data-alert-message="Are You Sure to Delete this Category" flash="Category"  data-action-url="' . route('restaurant.coupon.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
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
            'from_date' => 'required|date|after:tomarrow',
            'end_date' => 'required|date|after:from_date'
        ]);
        // $from_date = $request->from_date;
        // $to_date = $request->end_date;
        
        // return $check = VendorOffers::where("from_date" , '>=' ,mysql_date_time($request->from_date))->where('to_date','<=',mysql_date_time($request->end_date))->where('vendor_id','=', Auth::guard('vendor')->user()->id)
        // ->orWhere(function($q) use($from_date, $to_date){
        //     $q->where('from_date', '<=', $from_date)
        //     ->where('to_date','>=', $to_date)
        //     ->where('vendor_id','=', Auth::guard('vendor')->user()->id);
        // })
        // ->count();
        $coupon = new VendorOffers;
        $coupon->offer_persentage = $request->offer_persentage;
        $coupon->offer_persentage = $request->offer_persentage;
        $coupon->from_date  = mysql_date_time($request->from_date);
        $coupon->to_date  = mysql_date_time($request->end_date);
        $coupon->vendor_id = Auth::guard('vendor')->user()->id;
        $coupon->save();
        return redirect()->route('restaurant.offers.list')->with('message', 'Offer Create Successfully');

    }
}
