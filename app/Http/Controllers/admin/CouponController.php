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
       // return  $request->input();die;
        $this->validate($request, [
            'code' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'maximum_order_value' => 'required',
            'minimum_order_value' => 'required',
            'expires_coupon' => 'required',
        ]);
        $coupon = new Coupon;
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
      //  $coupon->vendor_type = 'restaurant';
        $coupon->discount  = $request->discount;
        $coupon->discription  = $request->discription;
        $coupon->type  = $request->type;
        $coupon->maximum_order_value  = $request->maximum_order_value;
        $coupon->minimum_order_value  = $request->minimum_order_value;
        $coupon->type  = $request->type;
        $coupon->expires_coupon  = $request->expires_coupon;
        $coupon->save();
        return redirect()->route('admin.coupon.list')->with('message', 'Coupon Create Successfully');
    }
    public function get_data_table_of_coupon(Request $request)
    {
      //  echo 'ok';die;
        if ($request->ajax()) {
            
            $data = Coupon::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("admin.coupon.edit",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  
                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Category" flash="Category"  data-action-url="' . route('admin.coupon.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                })
               
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js'])
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
        if (Coupon::where('code','=',$request->code)->exists()) {
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
    public function update(Request $request){
        $this->validate($request, [
            'code' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'maximum_order_value' => 'required',
            'minimum_order_value' => 'required',
            'expires_coupon' => 'required',
        ]);
        $coupon = Coupon::find($request->id);
        $coupon->code = $request->code;
        $coupon->discount_type = $request->discount_type;
      //  $coupon->vendor_type = 'restaurant';
        $coupon->discount  = $request->discount;
        $coupon->discription  = $request->discription;
        $coupon->type  = $request->type;
        $coupon->maximum_order_value  = $request->maximum_order_value;
        $coupon->minimum_order_value  = $request->minimum_order_value;
        $coupon->type  = $request->type;
        $coupon->expires_coupon  = $request->expires_coupon;
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