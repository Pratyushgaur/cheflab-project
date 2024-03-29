<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use App\Models\Product_master;
use App\Models\Coupon;
use App\Models\CouponHistory;
use App\Models\Order_time;
use App\Models\Superadmin;
use App\Notifications\VendorCouponNotification;
use DataTables;
use Config;
use Auth;

class VendorCoupon extends Controller
{
    public function index()
    {
        return view('vendor.restaurant.coupon.list');
    }
    public function create_coupon(){
       $vendor_id =  Auth::guard('vendor')->user()->id;
        $product = Product_master::where('status','=','1')->where('userId','=',$vendor_id)->get();
      // $categories = Catogory_master::where('is_active','=','1')->get();
        return view('vendor.restaurant.coupon.create_coupon',compact('product'));
    }
    public function store_coupon(Request $request){
        // return  $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'maxim_dis_amount' => 'required',
            'minimum_order_amount' => 'required',
            'promo_redeem_count' => 'required',
            'promocode_use' => 'required',
            'from' => 'required',
            'to' => 'required',
            'description' => 'required',
            'coupon_valid_x_user'=>'required'
        ]);
        $coupon = new Coupon;
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount  = $request->discount;
        $coupon->description  = $request->description;
        $coupon->coupon_valid_x_user  = $request->coupon_valid_x_user;
        $coupon->promo_redeem_count  = $request->promo_redeem_count;
        $coupon->vendor_id = Auth::guard('vendor')->user()->id;
        $coupon->maxim_dis_amount  = $request->maxim_dis_amount;
        $coupon->minimum_order_amount  = $request->minimum_order_amount;
        $coupon->create_by  = $request->create_by;
        $coupon->from  = mysql_date_time($request->from);
        $coupon->to  = mysql_date_time($request->to);
        $coupon->save();

        // $subscribers = Superadmin::get();
        //     foreach ($subscribers as $k => $admin)
        //         $admin->notify(new VendorCouponNotification($coupon->id,Auth::guard('vendor')->user()->name,
        //         \Auth::guard('vendor')->user()->name." added new coupon.Name : ".$coupon->name." , Code : ".$coupon->code)); //With new post

         return redirect()->route('restaurant.coupon.list')->with('message', 'Coupon Create Successfully');
     }

     public function get_data_table_of_coupon(Request $request)
    {
      //  echo 'ok';die;
        if ($request->ajax()) {
            $vendor_id = \Auth::guard('vendor')->user()->id;
           // $data = Coupon::latest()->get();
           $data = Coupon::where('vendor_id', '=', $vendor_id)->select('name','code', 'id', 'discount_type','discount','from','to','created_at','status')->get();
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
                ->addColumn('discount_type', function($data){
                    if ($data->discount_type) {
                        $btn = ''.$data->discount.'<i class="fa fa-percent fa-sm"></i>';
                    } else {
                        $btn = ''.$data->discount.'<i class="fas fa-rupee-sign fa-sm"></i>';
                    }
                    return $btn;
                })
                ->addColumn('duration', function($data){
                    return $html = "(".date('D M Y',strtotime($data->from)).")".' TO ('.date('D M Y',strtotime($data->to)).")";
                })

                ->addColumn('expired', function($data){
                    if( \Carbon\Carbon::now()->gte($data->to)){
                        return '<b class="text-danger">Expired</b>';
                    }elseif(\Carbon\Carbon::now()->lt($data->from)){
                        return '<b class="text-warning">Waiting</b>';
                    }elseif(\Carbon\Carbon::now()->gte($data->from) && \Carbon\Carbon::now()->lte($data->to)){
                        return '<b class="text-success">Running</b>';
                    }
                })

                

                ->rawColumns(['date','action-js','status','discount_type','duration'])
                ->rawColumns(['action-js','status','discount_type',"expired"])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function inActive(Request $request){
        $id = $request->id;
        $update = \DB::table('coupons')
        ->where('id', $id)
        ->update(['status' => '0']);
       return \Response::json($update);
    }
    public function Active(Request $request){
        $id = $request->id;
        $update = \DB::table('coupons')
        ->where('id', $id)
        ->update(['status' => '1']);
       return \Response::json($update);
    }
    public function fun_edit_coupon($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $coupon = Coupon::findOrFail($id);
           // dd($city_data);
            return view('vendor.restaurant.coupon.editcoupon',compact('coupon'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public  function checkCoupon(Request $request ,$id=null){
        if (Coupon::where('code','=',$request->code)->exists()) {
            $data =Coupon::where('code','=',$request->code)->select('id','to')->get();
            $date = today()->format('Y-m-d');
           // echo $date;die;
            foreach($data as $k =>$v){
             //  echo $v->to;die;
               if($v->to > $date){
                  return \Response::json(false);

                }else{
                    return \Response::json(true);
                }
            }

           // return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkCuponname(Request $request ,$id=null){
        if (Coupon::where('name','=',$request->name)->exists()) {
            $date = today()->format('Y-m-d');
            if(Coupon::where('from', '>=', $date)->exists()){
                echo 'yesh';
            }else{
                echo 'no';
            }
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkCouponUpdate(Request $request,$id){
        $code = Coupon::where('code','=',$request->code);
       // var_dump($code);die;
        $code = $code->where('id','!=',$id);
        if ($code->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkCouponDate(Request $request,$id){
        if (CouponHistory::where('coupon_id','=',$request->id)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'maxim_dis_amount' => 'required',
            'minimum_order_amount' => 'required',
            'promo_redeem_count' => 'required',
            'promocode_use' => 'required',
         //   'coupon_type' => 'required',
            'from' => 'required',
            'to' => 'required',
            'description' => 'required',
        ]);
        $coupon = Coupon::find($request->id);
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount  = $request->discount;
        $coupon->description  = $request->description;
        $coupon->promo_redeem_count  = $request->promo_redeem_count;
        $coupon->coupon_valid_x_user  = $request->coupon_valid_x_user;
        $coupon->vendor_id = Auth::guard('vendor')->user()->id;
        $coupon->maxim_dis_amount  = $request->maxim_dis_amount;
        $coupon->minimum_order_amount  = $request->minimum_order_amount;
        $coupon->create_by  = $request->create_by;
        $coupon->from  = $request->from;
        $coupon->to  = $request->to;
        $coupon->save();
         return redirect()->route('restaurant.coupon.list')->with('message', 'Coupon Create Successfully');
    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = Coupon::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'City Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            }



        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }
}
