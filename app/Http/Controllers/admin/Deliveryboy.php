<?php

namespace App\Http\Controllers\Admin;
use App\Models\vendors;
use App\Models\User;
use App\Models\Catogory_master;
use App\Models\RiderAssignOrders;
use App\Models\Cuisines;
use App\Models\RiderIncentives;
use App\Models\Product_master; 
use App\Models\RiderReviewRatings;
use App\Models\Driver_total_working_perday;
use App\Models\Deliver_boy;
use App\Models\DeliveryboySetting;
use App\Models\RiderbankDetails;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use DataTables;
use Illuminate\Support\Arr;
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
// echo '<pre>';print_r($request->all());die;
        // return $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:deliver_boy,email',
            'city' => 'required',
            'pincode' => 'required',
            'join_date'  => 'required',
            'address'  => 'required',
            //'confirm_password'  => 'required',
            'phone' => 'required|unique:deliver_boy,mobile',
            // 'leader_contact_no' => 'required|mobile',
            // 'identity_image' => 'required',
            // 'identity_number' => 'required',
            'bank_name' =>'required',
            'holder_name' =>'required',
            'account_no' =>'required',
        ]);
        $code = generateDriverUniqueCode();
        $uname  =  $request->name;
        $vendors = new Deliver_boy;
        
        $vendors->username   = $code;
        $vendors->name = $request->name;
        $vendors->email = $request->email;
        $vendors->mobile  = $request->phone;
        $vendors->zone  = $request->zone;
        $vendors->leader_contact_no  = $request->leader_contact_no;
        $vendors->password   = Hash::make('test');
        $vendors->pincode  = $request->pincode;
        $vendors->city  = $request->city;
        $vendors->identity_number  = '001';
        $vendors->join_date  = $request->join_date;
        $vendors->alt_mobile  = $request->alt_phone;
        $vendors->aadhar_number  = $request->aadhar_number;
        
//        $vendors->address  = $request->address;

        if($request->has('image')){
            $filename = time().'-image-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->image  = $filename;
        }
        if($request->has('license_image')){
            $filename = time().'-license-image-'.rand(100,999).'.'.$request->license_image->extension();
            $request->license_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->licence_image  = $filename;
            $vendors->licence_number  = $request->license_number;
        }    
        if($request->has('rc_image')){
            $filename = time().'-rc_image-image-'.rand(100,999).'.'.$request->rc_image->extension();
            $request->rc_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->rc_image  = $filename;
            $vendors->rc_number  = $request->rc_number;
        }
        if($request->has('insurance_image')){
            $filename = time().'-insurance_image-image-'.rand(100,999).'.'.$request->insurance_image->extension();
            $request->insurance_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->insurance_image  = $filename;
            $vendors->insurance_number  = $request->insurance_number;
        }
        if($request->has('pancard_image')){
            $filename = time().'-pancard_image-image-'.rand(100,999).'.'.$request->pancard_image->extension();
            $request->pancard_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->pancard_image  = $filename;
            $vendors->pancard_number  = $request->pancard_number;
        } 
        if($request->has('aadhar_image')){
            $filename = time().'-aadhar_image-image-'.rand(100,999).'.'.$request->aadhar_image->extension();
            $request->aadhar_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->aadhar_image  = $filename;
            $vendors->aadhar_number  = $request->aadhar_number;
        }  
        if($request->has('varification_image')){
            $filename = time().'-varification_image-image-'.rand(100,999).'.'.$request->varification_image->extension();
            $request->varification_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->police_varification_image  = $filename;
        }    
        // if($request->has('identity_image')){
        //     $filename = time().'-identity_image-'.rand(100,999).'.'.$request->identity_image->extension();
        //     $request->identity_image->move(public_path('dliver-boy-documents'),$filename);
        //     $vendors->identity_image  = $filename;
        //     $vendors->identity_number  = $request->identity_number;
        // }


        $vendors->save();
        //$vendors->save();

        if($request->time == 'full_time'){
            $time = 'F'.sprintf("%06d", $vendors->id);
        }else{
            $time = 'P'.sprintf("%06d", $vendors->id);
        }

        $delivery = Deliver_boy::where('id', '=',  $vendors->id)->first();
        $delivery->boy_id = $time;
        $delivery->start_time = $request->start_time;
        $delivery->end_time = $request->end_time;
        $delivery->created_at = date('Y-m-d H:i:s');
        $delivery->updated_at = date('Y-m-d H:i:s');
        $delivery->save();

        $bankdetail = new RiderbankDetails;
        $bankdetail->rider_id = $delivery->id;
        $bankdetail->bank_name = $request->bank_name;      
        $bankdetail->holder_name = $request->holder_name;
        $bankdetail->account_no = $request->account_no;

        if ($request->has('cancel_check')) {
            $filename = time() . '-check-' . rand(100, 999) . '.' . $request->cancel_check->extension();
            $request->cancel_check->move(public_path('dliver-boy-documents'), $filename);
            $files               = $filename;
            $bankdetail->cancel_check = $files;
        }

        $bankdetail->ifsc = $request->ifsc;
        $bankdetail->save();
        return redirect()->route('admin.deliverboy.list')->with('message', 'Delivery Boy Registration Successfully');
        

    }
    public function storeDelivercharge(Request $request){

        // echo '<pre>'; print_r($request->all());die;
        $general = DeliveryboySetting::find($request->id);
        $general->first_three_km_charge_admin = $request->first_three_km_charge_admin;
        $general->first_three_km_charge_user = $request->first_three_km_charge_user;
        $general->first_three_km_charge_admin = $request->first_three_km_charge_admin;
        $general->three_km_to_six_user = $request->three_km_to_six_user;
        $general->three_km_to_six_admin = $request->three_km_to_six_admin;
        $general->six_km_above_user = $request->six_km_above_user;
        $general->six_km_above_admin = $request->six_km_above_admin;
        $general->extra_charges_admin = $request->extra_charges_admin;
        $general->extra_charges_user = $request->extra_charges_user;
        if(isset($request->extra_charge_active)){
            $general->extra_charge_active = '1';
        }else{
            $general->extra_charge_active = '0';
        }
        $general->fifteen_order_incentive_4 = $request->fifteen_order_incentive_4;
        $general->fifteen_order_incentive_5 = $request->fifteen_order_incentive_5;
        $general->sentientfive_order_incentive_4 = $request->sentientfive_order_incentive_4;
        $general->sentientfive_order_incentive_5 = $request->sentientfive_order_incentive_5;
        $general->hundred_order_incentive_4 = $request->hundred_order_incentive_4;
        $general->hundred_order_incentive_5 = $request->hundred_order_incentive_5;
        $general->no_of_order_cancel = $request->no_of_order_cancel;
        $general->below_one_five_km = $request->below_one_five_km;
        $general->above_one_five_km = $request->above_one_five_km;
        $general->save();
        return redirect()->route('admin.deliverboy.setting')->with('message', 'Update Chargs Successfully');
    }

    // public function storeDelivercharge(Request $request){

    //     // echo '<pre>'; print_r($request->all());die;
    //     $general = DeliveryboySetting::find($request->id);
    //     $general->first_three_km_charge_admin = $request->first_three_km_charge_admin;
    //     $general->first_three_km_charge_user = $request->first_three_km_charge_user;
    //     $general->first_three_km_charge_admin = $request->first_three_km_charge_admin;
    //     $general->three_km_to_six_user = $request->three_km_to_six_user;
    //     $general->three_km_to_six_admin = $request->three_km_to_six_admin;
    //     $general->six_km_above_user = $request->six_km_above_user;
    //     $general->six_km_above_admin = $request->six_km_above_admin;
    //     $general->extra_charges_admin = $request->extra_charges_admin;
    //     $general->fifteen_order_incentive_4 = $request->fifteen_order_incentive_4;
    //     $general->fifteen_order_incentive_5 = $request->fifteen_order_incentive_5;
    //     $general->sentientfive_order_incentive_4 = $request->sentientfive_order_incentive_4;
    //     $general->sentientfive_order_incentive_5 = $request->sentientfive_order_incentive_5;
    //     $general->hundred_order_incentive_4 = $request->hundred_order_incentive_4;
    //     $general->hundred_order_incentive_5 = $request->hundred_order_incentive_5;
    //     $general->no_of_order_cancel = $request->no_of_order_cancel;
    //     $general->below_one_five_km = $request->below_one_five_km;
    //     $general->above_one_five_km = $request->above_one_five_km;
    //     $general->save();
    //     return redirect()->route('admin.deliverboy.setting')->with('message', 'Update Chargs Successfully');
    // }
    public function get_data_table_of_deliverboy(Request $request)
    {
        // echo 'ok';die;
        
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
                                    <a class="dropdown-item text-info" href="'.route('admin.deliverboy.viewdetail',Crypt::encryptString($data->id)).'"><i class="fa fa-eye"></i> View More</a>';

                                    



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

            ->addColumn('rating', function($data){
                return $data->rating.' <span class="text-danger">*</span>';
                
            })

            ->addColumn('order_delivered', function($data){
                $data = RiderAssignOrders::join('order_commisions','rider_assign_orders.order_id','=','order_commisions.order_id')
                                        ->where(['rider_assign_orders.id'=> $data->id, 'order_commisions.is_approve' => 1])
                                        ->count();
                return $data;
                // return 1;
            })

            ->addColumn('order_calceled', function($data){
                $data = RiderAssignOrders::join('order_commisions','rider_assign_orders.order_id','=','order_commisions.order_id')
                                        ->where(['rider_assign_orders.id'=> $data->id, 'order_commisions.is_cancel' => 1])
                                        ->count();
                return $data;
            })

            ->addColumn('status', function($data){
                return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success inactiveVendor" data-url="'.route('admin.deliver_boy.inactive',$data->id).'" >Active</button>' : '<button class="btn btn-xs btn-danger inactiveVendor" data-url="'.route('admin.deliver_boy.active',$data->id).'">In active</button>';
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
            })

            ->addColumn('image',function($data){
                return "<img src=".asset('dliver-boy').'/'.$data->image."  style='width: 50px;' />";
            })

            ->rawColumns(['date','action-js','status','image','rating','order_calceled','order_delivered'])
            //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
           // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
            ->make(true);
       }

    }
    public function fun_edit_deliverboy($encrypt_id){
        
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $deliveryboy = Deliver_boy::findOrFail($id);
            $delivery_bankdetails = RiderbankDetails::where('rider_id', '=',  $deliveryboy->id)->first();
          
            return view('admin/deliveryboy/editdeliverboy',compact('deliveryboy','delivery_bankdetails'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:deliver_boy,email,'.$request->id,
            'pincode' => 'required',
            'phone' => 'required|unique:deliver_boy,mobile,'.$request->id,
            // 'address' => 'required',
            'time' => 'required'
        ]);
        $vendors = Deliver_boy::find($request->id);
        $vendors->name = $request->name;
        $vendors->email = $request->email;
        $vendors->mobile  = $request->phone;
        $vendors->zone  = $request->zone;
        $vendors->leader_contact_no  = $request->leader_contact_no;
        $vendors->password   = Hash::make($request->password);
        $vendors->pincode  = $request->pincode;
        $vendors->city  = $request->city;
        $vendors->identity_number  = $request->identity_number;
        $vendors->start_time = $request->start_time;
        $vendors->end_time = $request->end_time;
        $vendors->aadhar_number  = $request->aadhar_number;
//        $vendors->address  = $request->address;

        if($request->has('image')){
            $filename = time().'-image-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('dliver-boy'),$filename);
            $vendors->image  = $filename;
        }
        if($request->has('license_image')){
            $filename = time().'-license-image-'.rand(100,999).'.'.$request->license_image->extension();
            $request->license_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->licence_image  = $filename;
            $vendors->licence_number  = $request->license_number;
        }  
        if($request->has('rc_image')){
            $filename = time().'-rc_image-image-'.rand(100,999).'.'.$request->rc_image->extension();
            $request->rc_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->rc_image  = $filename;
            $vendors->rc_number  = $request->rc_number;
        }
        if($request->has('insurance_image')){
            $filename = time().'-insurance_image-image-'.rand(100,999).'.'.$request->insurance_image->extension();
            $request->insurance_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->insurance_image  = $filename;
            $vendors->insurance_number  = $request->insurance_number;
        }
        if($request->has('pancard_image')){
            $filename = time().'-pancard_image-image-'.rand(100,999).'.'.$request->pancard_image->extension();
            $request->pancard_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->pancard_image  = $filename;
            $vendors->pancard_number  = $request->pancard_number;
        } 
        if($request->has('aadhar_image')){
            $filename = time().'-aadhar_image-image-'.rand(100,999).'.'.$request->aadhar_image->extension();
            $request->aadhar_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->aadhar_image  = $filename;
            $vendors->aadhar_number  = $request->aadhar_number;
        }  
        if($request->has('varification_image')){
            $filename = time().'-varification_image-image-'.rand(100,999).'.'.$request->varification_image->extension();
            $request->varification_image->move(public_path('dliver-boy-documents'),$filename);
            $vendors->police_varification_image  = $filename;
        } 
        // if($request->has('identity_image')){
        //     $filename = time().'-identity_image-'.rand(100,999).'.'.$request->identity_image->extension();
        //     $request->identity_image->move(public_path('dliver-boy-documents'),$filename);
        //     $vendors->identity_image  = $filename;
        //     $vendors->identity_number  = $request->identity_number;
        // }
        
         
        $vendors->save();
        
        $bankdetail = RiderbankDetails::where('rider_id', '=',  $vendors->id)->first();
        $bankdetail->rider_id = $vendors->id;
        $bankdetail->bank_name = $request->bank_name;      
        $bankdetail->holder_name = $request->holder_name;
        $bankdetail->account_no = $request->account_no;

        if ($request->has('cancel_check')) {
            $filename = time() . '-check-' . rand(100, 999) . '.' . $request->cancel_check->extension();
            $request->cancel_check->move(public_path('dliver-boy-documents'), $filename);
            $files               = $filename;
            $bankdetail->cancel_check = $files;
        }

        $bankdetail->ifsc = $request->ifsc;
        $bankdetail->save();
        return redirect()->route('admin.deliverboy.list')->with('message', 'Vendor Registration Successfully');
    }
    public function soft_delete(Request $request)
    {   
        // echo 'yes';
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

    public function deliver_boy_inactive($id){   
        // echo "hello";die;         
        $user = Deliver_boy::find($id);
        Deliver_boy::where('id','=', $user->id)->limit(1)->update( ['status' => '0']);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'User Inactive Successfully' ], 200);
    }

    public function deliver_boy_active($id){
        $user = Deliver_boy::find($id);
        Deliver_boy::where('id','=', $user->id)->limit(1)->update( ['status' => '1']);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'User Active Successfully' ], 200);
    }

    public function fun_view_deliverboy($id){      
        $rider_id =  Crypt::decryptString($id);
        $user = Deliver_boy::find($rider_id);
        // $deliverd_order = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '3'])->count();
        // $canceled_order = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '2'])->count();
        // $total_earning = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '3'])->sum('earning');
        // $total_incentive = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '3'])->sum('earning');
        
        return view('admin/deliveryboy/deliverboy_view',compact('rider_id','user'));
    }

    public function delivery_boy_tab(){   
       $type = $_POST['type'];
       $rider_id = $_POST['rider_id'];
       $user = Deliver_boy::find($rider_id);

        if($type == 'info'){

            $userData = RiderReviewRatings::where(['rider_id' => $rider_id])->count();

            $excellent = RiderReviewRatings::where(['rider_id' => $rider_id,'rating' => '5'])->count();
            $good = RiderReviewRatings::where(['rider_id' => $rider_id,'rating' => '4'])->count();
            $average = RiderReviewRatings::where(['rider_id' => $rider_id,'rating' => '3'])->count();
            $below_average = RiderReviewRatings::where(['rider_id' => $rider_id,'rating' => '2'])->count();
            $poor = RiderReviewRatings::where(['rider_id' => $rider_id,'rating' => '1'])->count();

            if($userData == '0'){
                $rating_arr = ([
                    'excellent_count' => 0,
                    'good_count' => 0,
                    'average_count' => 0,
                    'below_average_count' => 0,
                    'poor_count' => 0,
                    'excellent' => 0,
                    'good' => 0,
                    'average' => 0,
                    'below_average' => 0,
                    'poor' => 0
                ]);   
            }else{
                $rating_arr = ([
                    'excellent_count' => $excellent,
                    'good_count' => $good,
                    'average_count' => $average,
                    'below_average_count' => $below_average,
                    'poor_count' => $poor,
                    'excellent' => ($excellent/$userData * 100),
                    'good' => ($good/$userData * 100),
                    'average' => ($average/$userData * 100),
                    'below_average' => ($below_average/$userData * 100),
                    'poor' => ($poor/$userData * 100)
                ]);
            }
            


            $deliverd_order = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '3'])->count();
            $canceled_order = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '2'])->count();
            $total_earning = RiderAssignOrders::where(['rider_id' => $rider_id,'action' => '3'])->sum('earning');
            $total_incentive = RiderIncentives::where(['rider_id' => $rider_id])->sum('amount');
            $view = view('admin/deliveryboy/deliverboy_information_view',compact('rider_id','deliverd_order','canceled_order','total_earning','total_incentive','user','rating_arr'))->render();
            return json_encode(['type' => $type,'view' => $view ]);
        }else if($type == 'tran'){
            $view = view('admin/deliveryboy/deliverboy_transaction_view',compact('rider_id','user'))->render();
            return json_encode(['type' => $type,'view' => $view ]);
            
        }else if($type == 'time'){
            $view = view('admin/deliveryboy/deliverboy_timelog_view',compact('rider_id','user'))->render();
            return json_encode(['type' => $type,'view' => $view ]);
            
        }else if($type == 'conv'){
            $view = view('admin/deliveryboy/deliverboy_conversations_view',compact('rider_id','user'))->render();
            return json_encode(['type' => $type,'view' => $view ]);
            
         }

    }

    

    public function delivery_boy_review_list(Request $request)
    {
    
        if ($request->ajax()) {

            $data = RiderReviewRatings::Where('rider_review_ratings.rider_id', $request->riderId)->join('users','rider_review_ratings.user_id','=','users.id')->select('rider_review_ratings.review','users.name','rider_review_ratings.created_at','rider_review_ratings.order_id','rider_review_ratings.rating')->get();
      
            return Datatables::of($data)
                ->addIndexColumn()
               
            ->addColumn('date', function($data){
                $date_with_format = date('Y-m-d H:m:s',strtotime($data->created_at));
                return $date_with_format;
            })
            ->rawColumns(['date'])

            ->make(true);
       }

    }

    public function delivery_boy_transaction_list(Request $request)
    {
       
        if ($request->ajax()) {
            $data = RiderAssignOrders::where(['rider_id' => $request->rider_id,'action' => '3'])->get();
   
            return Datatables::of($data)
                ->addIndexColumn()
               
            ->addColumn('date', function($data){
                $date_with_format = date('Y-m-d',strtotime($data->created_at));
                return $date_with_format;
            })
            ->rawColumns(['date'])

            ->make(true);
       }

    }

    public function delivery_boy_timelog_list(Request $request)
    {
       
        if ($request->ajax()) {
            $data = Driver_total_working_perday::where(['rider_id' => $request->rider_id])->get();
   
            return Datatables::of($data)    
                ->addIndexColumn()
               
            ->addColumn('date', function($data){
                $date_with_format = date('Y-m-d',strtotime($data->created_at));
                return $date_with_format;
            })

            ->addColumn('active_time', function($data){
                $active_time = gmdate('H:i:s', $data->total_hr);
                return $active_time;
            })

            ->rawColumns(['date','active_time'])

            ->make(true);
       }

    }

    // public function delivery_boy_status($id){  

    //     $rider = Deliver_boy::find($id);

    //     if($rider->status == 1){
    //         Deliver_boy::where('id', $id)->first()->update([ 'status' => 0]);
    //         return redirect()->route('admin.deliverboy.viewdetail',encrypt($id))->with('message', 'Rider In-Active Successfully');
    //     }else{
    //         Deliver_boy::where('id', $id)->first()->update([ 'status' => 1]);
    //         return redirect()->route('admin.deliverboy.viewdetail',encrypt($id))->with('message', 'Rider Active Successfully');
    //     }
        
    // }
    


    
    
    
}
