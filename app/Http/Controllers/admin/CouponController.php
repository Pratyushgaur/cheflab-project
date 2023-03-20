<?php

namespace App\Http\Controllers\Admin;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Product_master;
use App\Models\Chef_video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Illuminate\Support\Facades\Hash;
class CouponController extends Controller
{
    public function index(){
        return view('admin/coupon/list');
    }
    public function create_coupon(){
        $categories = Catogory_master::where('is_active','=','1')->get();
        return view('admin/coupon/create_coupon',compact('categories'));
    }
    public function store_coupon(Request $request){
       //return  $request->input();die;
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
        ]);
        $coupon = new Coupon;
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount  = $request->discount;
        $coupon->description  = $request->description;
        $coupon->show_in  = $request->show_in;
        $coupon->coupon_valid_x_user  = $request->coupon_valid_x_user;
        $coupon->maxim_dis_amount  = $request->maxim_dis_amount;
        $coupon->minimum_order_amount  = $request->minimum_order_amount;
        $coupon->promo_redeem_count  = $request->promo_redeem_count;
        $coupon->promocode_use  = $request->promocode_use;
        $coupon->create_by  = $request->create_by;
        $coupon->from  = mysql_date_time($request->from);
        $coupon->to  = mysql_date_time($request->to);
        if($request->has('image')){
            $filename = time().'-image-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('coupon-admin'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $coupon->image  = $filename;
        }
        $coupon->save();
        return redirect()->route('admin.coupon.list')->with('message', 'Coupon Create Successfully');
    }
    public function get_data_table_of_coupon(Request $request)
    {
      //  echo 'ok';die;
    //   if(Carbon::now()->between(Carbon::createFromFormat('Y-m-d', $data->from), Carbon::createFromFormat('Y-m-d', $data->to)->addDay())){
    //     echo 'ok';die;
    //      return  $btn =  '<button class="btn btn-xs btn-success">active</button>';

    //  }else{
    //      Coupon::where('id','=', $data->id)->limit(1)->update( ['status' => 0]);
    //      return  $btn =  '<button class="btn btn-xs btn-danger">In active</button>';
    //  }
        if ($request->ajax()) {

            $data = Coupon::latest()->leftJoin('vendors','coupons.vendor_id','=','vendors.id')->select('coupons.*','vendors.name as vendor_name')->where('create_by','=',$request->create_by)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("admin.coupon.edit",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs"><i class="nav-icon fas fa-edit"></i></a>
                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Category" flash="Category"  data-action-url="' . route('admin.coupon.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('discount_type', function($data){
                    if ($data->discount_type) {
                        $btn = '<i class="fa fa-percent" aria-hidden="true"></i>';
                    } else {
                        $btn = '<i class="fas fa-rupee-sign"></i>';
                    }


                    return $btn;
                })
                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>';
                })
                ->addColumn('vendor_name', function($data){
                    if ($data->vendor_id != '') {
                        return '<a target="_blank" href="'. route("admin.vendor.view",Crypt::encryptString($data->vendor_id)) .'" >'.$data->vendor_name.'</a>';
                    } else {
                        return '-';
                    }
                    
                })
                ->addColumn('start_at', function($data){
                    return \Carbon\Carbon::parse($data->from)->format('M d Y');
                    
                })
                ->addColumn('end_at', function($data){
                    return \Carbon\Carbon::parse($data->to)->format('M d Y');
                    
                })

                ->addColumn('running', function($data){
                    if( \Carbon\Carbon::now()->gte($data->to)){
                        return '<a class="text-danger">Expired</a>';
                    }
                    
                    
                })


                ->rawColumns(['date','action-js','status','discount_type'])
                ->rawColumns(['action-js','discount_type','status','vendor_name','running'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function fun_edit_coupon($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $coupon = Coupon::findOrFail($id);
           // dd($city_data);
            return view('admin.coupon.editcoupon',compact('coupon'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public  function checkCoupon(Request $request ,$id=null){
        if (Coupon::where('code','=',$request->code)->whereDate('to','>=',today()->format('Y-m-d'))->exists()) {
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
    public function upercase(Request $request)
    {
        $value = $request->code;
        if(ctype_lower($value)){
            return \Response::json(false);
        }else{
            return \Response::json(true);
        }

        //return strtoupper($value);
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
    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code,'.$request->id,
            'discount_type' => 'required',
            'discount' => 'required',
            'maxim_dis_amount' => 'required',
            'minimum_order_amount' => 'required',
            'promo_redeem_count' => 'required',
            'promocode_use' => 'required',
            'from' => 'required',
            'to' => 'required',
            'description' => 'required',
        ]);
        $coupon = Coupon::findOrFail($request->id);
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount  = $request->discount;
        $coupon->description  = $request->description;
        $coupon->show_in  = (isset($request->show_in)) ? $request->show_in : '0' ;
        $coupon->coupon_valid_x_user  = $request->coupon_valid_x_user;
        $coupon->maxim_dis_amount  = $request->maxim_dis_amount;
        $coupon->minimum_order_amount  = $request->minimum_order_amount;
        $coupon->create_by  = $request->create_by;
        $coupon->from  = mysql_date_time($request->from);
        $coupon->to  = mysql_date_time($request->to);
        if($request->has('image')){
            $filename = time().'-image-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('coupon-admin'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $coupon->image  = $filename;
        }
        $coupon->save();
        return redirect()->route('admin.coupon.list')->with('message', 'Coupon Update Successfully');
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
