<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\SloteBook;
use App\Models\SloteMaster;
use App\Models\Coupon;
use App\Models\Order_time;
use DataTables;
use Config;
use Auth;

class VendorPromotion extends Controller
{
    public function index()
    {
        return view('vendor.restaurant.promotion.list');
    }
    public function create_promotion(){
        $slot =SloteMaster::where('status','=','1')->select('id','price')->get();
        return view('vendor.restaurant.promotion.create',compact('slot'));
    }
    /*public function create_promotion(){
       $vendor_id =  Auth::guard('vendor')->user()->id;
       $slot = SloteBook::where('vendor_id',$vendor_id)->where('slot_status','=','0')->select('id','date')->get();
       // dd($slot);  // @if($vendor->product_image == null)      if(is_null($slot)
       if(sizeof($slot)){
        return redirect()->route('restaurant.promotion.list')->with('message', 'Your Slot is Pending you can not Creat new Slot');
       }else{
    //    echo 'ok';die;
            $slot =SloteMaster::where('status','=','1')->select('id','price')->get();
            return view('vendor.restaurant.promotion.create',compact('slot'));
           /* if($slot == null){
                $slot =SloteMaster::where('status','=','1')->select('id','price')->get();
                return view('vendor.restaurant.promotion.create',compact('slot'));
            }else{
                $slot =SloteMaster::where('status','=','1')->select('id','price')->get();
                return view('vendor.restaurant.promotion.create',compact('slot'));
            }
       }
        
        
    }*/
    public function selctvalue(Request $request){
     //  return  $request->input();die;
        $id =  $request->banner;
       // var_dump($id);die;
        $data =SloteMaster::where('id','=',$id)->select('id','price')->get();
       // dd($slot);
       return response()->json( [$data] );
        //return $data;
    }
    public function store_slot(Request $request){
        $this->validate($request, [
            'date' => 'required',
            'banner' => 'required',
            'slot_image' => 'required',
        ]);
        $slot = new SloteBook;
        $slot->date = $request->date;
        $slot->id = $request->banner;
        $slot->vendor_id = Auth::guard('vendor')->user()->id;
        $slot->banner = $request->banner;
        if($request->has('slot_image')){
            $filename = time().'-slot_image-'.rand(100,999).'.'.$request->slot_image->extension();
            $request->slot_image->move(public_path('slot-vendor-image'),$filename);
            $slot->slot_image  = $filename;
        }
        
        $slot->save();
        return redirect()->route('restaurant.promotion.list')->with('message', 'SlotBook');
    }
    public function get_list_slotbook(Request $request){
        if ($request->ajax()) {
            $vendor_id = Auth::guard('vendor')->user()->id;
            $data = SloteBook::where('vendor_id',$vendor_id)->select('slot_id','date','banner','slot_image','slot_status')->get();
          //  $data = \App\Models\SloteBook::where(['slotbooking_table.slot_status'=>'0'])->join('vendors','slotbooking_table.vendor_id','=','vendors.id')->select('slotbooking_table.banner','slot_id','date','slot_image','slot_status','vendors.name as restaurantName')->get();  
            return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('slot_status', function($data){
                    return $status_class = (!empty($data->slot_status)) && ($data->slot_status == 0) ? '<button class="btn btn-sm btn-success">Active</button>' : '<a  href="'.route('admin.slot.active',Crypt::encryptString($data->slot_id)).'" class="btn btn-sm btn-danger">Pending</a>'; 
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                })
                ->addColumn('slot_image',function($data){
                    return "<img src=".asset('slot-vendor-image').'/'.$data->slot_image."  style='width: 50px;' />";
                })
                ->rawColumns(['date','slot_status','slot_image'])
                ->rawColumns(['slot_status','slot_image']) 
                ->make(true);
        }
    }
    public function checkdate(Request $request){
        $date = $request->id;
        if (SloteBook::where('date','=',$date)->exists()) {
            return \Response::json(false);
          // return redirect()->route('restaurant.promotion.create')->with('message', 'SlotBook');
        } else {
            return \Response::json(true);
        }
    }
}