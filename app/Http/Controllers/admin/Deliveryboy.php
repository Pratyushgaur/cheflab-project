<?php

namespace App\Http\Controllers\Admin;
use App\Models\vendors;
use App\Models\User;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Product_master;
use App\Models\Deliver_boy;
use App\Models\DeliveryboySetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use DataTables;
use Illuminate\Support\Facades\Hash;
class Deliveryboy extends Controller
{

    public function index(){
        return view('admin/deliveryboy/list');
    }
    public function create_deliverboy(){
        return view('admin/deliveryboy/deliverboy_create');
    }
    public function deliverboy_reviews(){
        return view('admin/deliveryboy/deliverboy_reviews');
    }
    public function setting(Request $request){
        $id = '1';
        $data = DeliveryboySetting::findOrFail($id);
        return view('admin/deliveryboy/setting',compact('data'));
    }
    /*public function store_deliverboy(Request $request)
    {
     //   $code = $name.rand('aplha',6);
        // $code = Str::random(4);
        // $uname  =  $request->name;
        // $ridercode =  $uname.$code;
        // var_dump($ridercode);die;
       //return $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:vendors,email',
            'city' => 'required',
            'pincode' => 'required',
            'password'  => 'required',
            'confirm_password'  => 'required',
            'phone' => 'required|unique:vendors,mobile',
            'identity_image' => 'required',
            'identity_number' => 'required',
        ]);
      //  $code = $name.rand('aplha',6);
        //$code = str_random('aplha',6);
        //$uname  =  $request->name;
        //$ridercode =  $uname.$code;
        $vendors = new Deliver_boy;
        $vendors->name = $request->name;
        dd($vendors);
        //$vendors = $ridercode;
        $vendors->email = $request->email;
        $vendors->mobile  = $request->phone;
        $vendors->password   = Hash::make($request->password);
        $vendors->pincode  = $request->pincode;
        $vendors->city  = $request->city;
//        $vendors->address  = $request->address;

        if($request->has('image')){
            $filename = time().'-profile-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('dliver-boy'),$filename);
            $vendors->image  = $filename;
        }
        if($request->has('identity_image')){
            $filename = time().'-other-document-'.rand(100,999).'.'.$request->identity_image->extension();
            $request->identity_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->identity_image  = $filename;
            $vendors->identity_number  = $request->identity_number;
        }
        $vendors->save();

        return redirect()->route('admin.deliverboy.list')->with('message', 'Delivery Boy Registration Successfully');
    }*/
    public function store_deliverboy(Request $request)
    {
      // echo 'ok';die;
     // return $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:vendors,email',
            'city' => 'required',
            'pincode' => 'required',
            'password'  => 'required',
            'confirm_password'  => 'required',
            'phone' => 'required|unique:vendors,mobile',
            'identity_image' => 'required',
            'identity_number' => 'required',
        ]);
        $code = Str::random(4);
        $uname  =  $request->name;
        $vendors = new Deliver_boy;
        $ridercode =  $uname.$code;
        $vendors->ridercode   = $ridercode;
        $vendors->name = $request->name;
        $vendors->email = $request->email;
        $vendors->mobile  = $request->phone;
        $vendors->password   = Hash::make($request->password);
        $vendors->pincode  = $request->pincode;
        $vendors->city  = $request->city;
        $vendors->identity_number  = $request->identity_number;
//        $vendors->address  = $request->address;

        if($request->has('image')){
            $filename = time().'-image-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('dliver-boy'),$filename);
            $vendors->image  = $filename;
        }
       
        if($request->has('identity_image')){
            $filename = time().'-identity_image-'.rand(100,999).'.'.$request->identity_image->extension();
            $request->identity_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->identity_image  = $filename;
            $vendors->identity_number  = $request->identity_number;
        }
        $vendors->save();
        return redirect()->route('admin.deliverboy.list')->with('message', 'Delivery Boy Registration Successfully');
        

    }
    public function storeDelivercharge(Request $request){
        $general = DeliveryboySetting::find($request->id);
        $general->a_to_b_charge = $request->a_to_b_charge;
        $general->b_to_c_charge = $request->b_to_c_charge;
        $general->fix_charge_1 = $request->fix_charge_1;
        $general->fix_charge_2 = $request->fix_charge_2;
        $general->incentive_one = $request->incentive_one;
        $general->incentive_to = $request->incentive_to;
        $general->save();
        return redirect()->route('admin.deliverboy.setting')->with('message', 'Update Chargs Successfully');
    }
    public function get_data_table_of_deliverboy(Request $request)
    {
        //echo 'ok';die;
        
        if ($request->ajax()) {
            $data = Deliver_boy::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                $btn = '<ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item text-info" href="'.route('admin.deliverboy.view',Crypt::encryptString($data->id)).'"><i class="fas fa-edit"></i> Edit</a>
                                    
                                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Delivery Boy" flash="City"  data-action-url="' . route('admin.deliverboy.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i> Delete</a> 
                                    <a class="dropdown-item text-info" href="'.route('admin.vendor.view',Crypt::encryptString($data->id)).'"><i class="fa fa-eye"></i> View More</a>';

                                    if($data->vendor_type == 'chef'){
                                        $btn .= '<a class="dropdown-item text-danger" href="'.route('admin.chefproduct.view',Crypt::encryptString($data->id)).'"><i class="fa-solid fa-bowl-food"></i>Add/View  Product</a>';
                                    }



                                $btn .= '</div>
                            </li>
                        </ul>';
                //$btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a><a href="'.route('admin.vendor.product.create',Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs"    title="Add Product" >Add Product</a> ';
                return $btn;
            })

            ->addColumn('date', function($data){
                $date_with_format = date('d M Y',strtotime($data->created_at));
                return $date_with_format;
            })

            ->addColumn('status', function($data){
                return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>';
                return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
            })

            ->addColumn('image',function($data){
                return "<img src=".asset('dliver-boy').'/'.$data->image."  style='width: 50px;' />";
            })

            ->rawColumns(['date','action-js','status','image'])
            //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
           // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
            ->make(true);
       }

    }
    public function fun_edit_deliverboy($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $city_data = Deliver_boy::findOrFail($id);
           // dd($city_data);
            return view('admin/deliveryboy/editdeliverboy',compact('city_data'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function checkEmailExist(Request $request,$id=null)
    {
        if (Deliver_boy::where('email','=',$request->email)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkEmailExistUpdate(Request $request,$id){
        $city = Deliver_boy::where('email','=',$request->email);
        $city = $city->where('id','!=',$id);
        if ($city->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkMobileExist(Request $request,$id=null)
    {
        if (Deliver_boy::where('mobile','=',$request->mobile)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkMobileExistUpdate(Request $request,$id)
    {
        $city = Deliver_boy::where('mobile','=',$request->mobile);
        $city = $city->where('id','!=',$id);
        if ($city->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function update(Request $request){
      //  return $request->input(); die;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:vendors,email',
            'pincode' => 'required',
            'phone' => 'required|unique:vendors,mobile',
            'address' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);
        $vendors = Deliver_boy::find($request->id);
        $vendors->name = $request->name;
        $vendors->email = $request->email;
        $vendors->mobile  = $request->phone;
        $vendors->password   = Hash::make($request->password);
        $vendors->pincode  = $request->pincode;
        $vendors->city  = $request->city;
        $vendors->identity_number  = $request->identity_number;
//        $vendors->address  = $request->address;

        if($request->has('image')){
            $filename = time().'-image-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('dliver-boy'),$filename);
            $vendors->image  = $filename;
        }
       
        if($request->has('identity_image')){
            $filename = time().'-identity_image-'.rand(100,999).'.'.$request->identity_image->extension();
            $request->identity_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->identity_image  = $filename;
            $vendors->identity_number  = $request->identity_number;
        }
        $vendors->save();
        return redirect()->route('admin.deliverboy.list')->with('message', 'Vendor Registration Successfully');
    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = Deliver_boy::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'Category Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            }



        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }
}
