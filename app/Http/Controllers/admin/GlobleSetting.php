<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product_master;
use App\Models\Catogory_master;
use App\Models\City_master;
use App\Models\Globle_master;
use App\Models\AdminMasters;
use App\Models\Dynamic;
use App\Models\Cuisines;
use App\Models\User_faq;
use App\Models\vendors;
use App\Models\UserFeedback;
use App\Models\VendorFeedback;
use App\Models\DeliveryboyFeedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class GlobleSetting extends Controller
{

    public function index(){
      //  $city = City_master::where('status','=','1')->select('id','city_name')->get();
       /* try {
            $id =  Crypt::decryptString($encrypt_id);
            $vendor = vendors::findOrFail($id);
            $categories = Catogory_master::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
            $cuisines = Cuisines::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();

            if($vendor->vendor_type == 'restaurant'){
                return view('admin/product/create_restaurant_product',compact('vendor','categories','cuisines'));
            }elseif($vendor->vendor_type == 'chef'){
                return view('admin/category/edit',compact('vendor'));
            }else{
                return 'Wrong Route';
            }

        } catch (\Exception $e) {
            return dd($e->getMessage());
        } */
        return view('admin/setting/settingpage');
    }
    public function delivery_charge(){
        $id = '1';
        $data = AdminMasters::findOrFail($id);
        return view('admin/setting/delivery_charge',compact('data'));
    }
    public function general(){
        $id = '1';
        $data = AdminMasters::findOrFail($id);
        return view('admin/setting/general',compact('data'));
    }
    public function staticpage(){
        $id = '1';
        $data = AdminMasters::findOrFail($id);
        return view('admin/setting/staticpage',compact('data'));
    }
    public function payment(){
        $id = '1';
        $data = AdminMasters::findOrFail($id);
        return view('admin/setting/payment',compact('data'));
    }
    public function defaulttimeset(){
        $id = '1';
        $data = AdminMasters::findOrFail($id);
        return view('admin/setting/defaulttimeset',compact('data'));
    }
    public function user_faq(){
        return view('admin/setting/faq');
    }
    public function feedbacklist(){
        return view('admin/setting/feedbacklist');
    }
    public function vendorfeedbacklist(){
        return view('admin/setting/vendorfeedback');
    }
    public function DeliveryBoyfeedbacklist(){
        return view('admin/setting/deliveryboyfeedback');
    }
    public function storeDefaultTime(Request $request){
        $general = AdminMasters::find($request->id);
        $general->default_cooking_time = $request->default_cooking_time;
        $general->default_delivery_time = $request->default_delivery_time;
        $general->save();
        return redirect()->route('admin.globle.defaulttime')->with('message', 'Default Time Update Successfully');
    }
    public function store_faq(Request $request){
        $this->validate($request, [
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);
        $faq = new User_faq;
        $faq->faq_question = $request->faq_question;
        $faq->faq_answer = $request->faq_answer;
        $faq->save();
        return redirect()->route('admin.user.faq')->with('message', 'FAQ Create Successfully');
    }
    public function storePaytm(Request $request){
        $general = AdminMasters::find($request->id);
        $general->razorpay_publish_key = $request->razorpay_publish_key;
        $general->paytm_publish_key = $request->paytm_publish_key;
        $general->save();
        return redirect()->route('admin.globle.storePaytm')->with('message', 'Update Payment setting Successfully');
    }
    public function storeDelivery(Request $request){
        $general = AdminMasters::find($request->id);
        $general->delivery_charges_fix = $request->delivery_charges_fix;
        $general->delivery_charges_per_km = $request->delivery_charges_per_km;
        $general->save();
        return redirect()->route('admin.globle.payment.setting')->with('message', 'Update Chargs Successfully');
    }
    public function storeGernel(Request $request){
        $general = AdminMasters::find($request->id);
        $general->company_name = $request->company_name;
        $general->goofle_map_key = $request->goofle_map_key;
        $general->aboutus = $request->aboutus;
        $general->order_limit_amout = $request->order_limit_amout;
        if($request->has('logo')){
            $filename = time().'-document-'.rand(100,999).'.'.$request->logo->extension();
            $request->logo->move(public_path('logo'),$filename);
            $general->logo  = $filename;
        }
        if($request->has('favicon')){
            $filename = time().'-other-document-'.rand(100,999).'.'.$request->favicon->extension();
            $request->favicon->move(public_path('logo'),$filename);
            $general->favicon  = $filename;
        }
        $general->save();
        return redirect()->route('admin.globle.general')->with('message', 'Update Successfully');
    }
    public function storePrivacy(Request $request){
        $general = AdminMasters::find($request->id);
        $general->privacy_policy = $request->privacy_policy;
        $general->save();
        return redirect()->route('admin.globle.staticpage')->with('message', 'Privacy Policy  Update Successfully');
    }
    public function storeVendorTC(Request $request){
        $general = AdminMasters::find($request->id);
        $general->terms_conditions_vendor = $request->terms_conditions_vendor;
        $general->save();
        return redirect()->route('admin.globle.staticpage')->with('message', 'Vendor Terms & Condition  Update Successfully');
    }
    public function storeCheflabTC(Request $request){
        $general = AdminMasters::find($request->id);
        $general->terms_conditions_cheflab = $request->terms_conditions_cheflab;
        $general->save();
        return redirect()->route('admin.globle.staticpage')->with('message', 'Cheflab Terms & Condition  Update Successfully');
    }
    public function storeDeliveryTC(Request $request){
        $general = AdminMasters::find($request->id);
        $general->terms_conditions_deliverboy = $request->terms_conditions_deliverboy;
        $general->save();
        return redirect()->route('admin.globle.staticpage')->with('message', 'Delivery Boy Terms & Condition  Update Successfully');
    }
    public function storeRefund(Request $request){
        $general = AdminMasters::find($request->id);
        $general->refund_cancellation_cheflab = $request->refund_cancellation_cheflab;
        $general->save();
        return redirect()->route('admin.globle.staticpage')->with('message', 'Refund Cancellation  Update Successfully');
    }
    public function store_catogory(Request $request)
    {
      // echo 'ok';die;
    //  return $request->input();die;
        $this->validate($request, [
            'city_id' => 'required',
            'lend_mark' => 'required',
        ]);
        $city = new Globle_master;
        $city->lend_mark = $request->lend_mark;
        $city->city_id = $request->city_id;
        $city->save();
        return redirect()->route('admin.globle.store')->with('message', 'City Registration Successfully');
    }
    public function get_data_table_of_globle(Request $request)
    {
        if ($request->ajax()) {

            $data = Globle_master::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("admin/edit-globle") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('categories') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
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
                ->rawColumns(['action-js','categoryImage'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }
    public function getFeedback(Request $request){
        if ($request->ajax()) {

            $data = UserFeedback::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'.route('admin.user.feedbackedit',Crypt::encryptString($data->id)).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="FAQ" table="' . Crypt::encryptString('user_faq') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

               
               
                ->rawColumns(['date','action-js'])
                ->rawColumns(['action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function getVendorFeedback(Request $request){
        if ($request->ajax()) {
            
            $data = VendorFeedback::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'.route('admin.user.feedbackedit',Crypt::encryptString($data->id)).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="FAQ" table="' . Crypt::encryptString('user_faq') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

               
               
                ->rawColumns(['date','action-js'])
                ->rawColumns(['action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function getDeliveryboyFeedback(Request $request){
        if ($request->ajax()) {
            
            $data = DeliveryboyFeedback::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'.route('admin.user.feedbackedit',Crypt::encryptString($data->id)).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="FAQ" table="' . Crypt::encryptString('user_faq') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })



                ->rawColumns(['date','action-js'])
                ->rawColumns(['action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function getFaq(Request $request){
        if ($request->ajax()) {

            $data = User_faq::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'.route('admin.user.faqedit',Crypt::encryptString($data->id)).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="FAQ" table="' . Crypt::encryptString('user_faq') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })



                ->rawColumns(['date','action-js'])
                ->rawColumns(['action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function fun_edit_category($encrypt_id)
    {
        $city = City_master::where('status','=','1')->select('id','city_name')->get();
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $city_data = Globle_master::findOrFail($id);
           // dd($city_data);
            return view('admin/globle/edit',compact('city_data'),['city'=>$city]);
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function fun_edit_faq($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $faq = User_faq::findOrFail($id);
           // dd($city_data);
            return view('admin/setting/editfaq',compact('faq'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function update_faq(Request $request){
        $this->validate($request, [
            'faq_question' => 'required',
            'faq_answer' => 'required',
        ]);
        $faq = User_faq::find($request->id);
        $faq->faq_question = $request->faq_question;
        $faq->faq_answer = $request->faq_answer;
        $faq->save();
        return redirect()->route('admin.user.faq')->with('message', 'FAQ Update Successfully');
    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = User_faq::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'FAQ Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            }



        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }
    function dyanmicimage(Request $request){
        return view('admin/globle/creatImage');
    }
    function fun_edit_image($encrypt_id){
        $city = Dynamic::where('status','=','1')->select('id','chef_image','restorent_image','dine_image')->get();
      //  dd($city);
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $city_data = Dynamic::findOrFail($id);
           // dd($city_data);
            return view('admin/globle/editimage',compact('city_data'),['city'=>$city]);
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    function updateImage(Request $request){

    }
    function store_image(Request $request){
        $this->validate($request, [
            'chef_image' => 'required',
            'restorent_image' => 'required',
            'dine_image' => 'required',
        ]);
        $dynamic = new Dynamic;

        if($request->has('chef_image')){
            $filename = time().'-profile-'.rand(100,999).'.'.$request->chef_image->extension();
            $request->chef_image->move(public_path('dynamic'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $dynamic->chef_image  = $filename;
        }
        if($request->has('restorent_image')){
            $filename = time().'-document-'.rand(100,999).'.'.$request->restorent_image->extension();
            $request->restorent_image->move(public_path('dynamic'),$filename);
            $dynamic->restorent_image  = $filename;
        }
        if($request->has('dine_image')){
            $filename = time().'-other-document-'.rand(100,999).'.'.$request->dine_image->extension();
            $request->dine_image->move(public_path('dynamic'),$filename);
            $dynamic->dine_image  = $filename;
            $dynamic->dine_image  = $request->dine_image;
        }

        $dynamic->save();
        return redirect()->route('admin.restouren.image')->with('message', 'Image Trgister Successfully');

    }
    public function get_data_table_of_image(Request $request)
    {
        if ($request->ajax()) {

            $data = Globle_master::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("admin/edit-dynamic") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('categories') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>';
                })
                ->addColumn('chef_image',function($data){
                    return "<img src=".asset('dynamic').'/'.$data->chef_image."  style='width: 50px;' />";
                })
                ->addColumn('restorent_image',function($data){
                    return "<img src=".asset('dynamic').'/'.$data->restorent_image."  style='width: 50px;' />";
                })
                ->addColumn('dine_image',function($data){
                    return "<img src=".asset('dynamic').'/'.$data->dine_image."  style='width: 50px;' />";
                })
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js','categoryImage'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }

}
