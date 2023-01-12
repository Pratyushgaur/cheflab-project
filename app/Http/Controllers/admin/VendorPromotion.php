<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SloteMaster;
use App\Models\VendorStorePromotipn;
use App\Models\AppPromotionBlogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;

class VendorPromotion extends Controller
{

    public function index(){

        return view('admin/promotion/app-blog');
    }
    public function store(Request $request){
      //  dd($request->all());
        $this->validate($request, [
            'position' => 'required',
            'blog_type' => 'required',
            'name' => 'required',
            'from' => 'required',
            'to' => 'required',
            'master_blog' => 'required',
            "first_position_price_for_week" => "required",
            "first_position_price_for_two_week" => "required",
            "first_position_price_for_month" => "required",
            "second_position_price_for_week" => "required",
            "second_position_price_for_two_week" => "required",
            "second_position_price_for_month" => "required",
            "third_position_price_for_week" => "required",
            "third_position_price_for_two_week" => "required",
            "third_position_price_for_month" => "required",
            "fourth_position_price_for_week" => "required",
            "fourth_position_price_for_two_week" => "required",
            "fourth_position_price_for_month" => "required",
            "fifth_position_price_for_week" => "required",
            "fifth_position_price_for_two_week" => "required",
            "fifth_position_price_for_month" => "required",
            "sixth_position_price_for_week" => "required",
            "sixth_position_price_for_two_week" => "required",
            "sixth_position_price_for_month" => "required",
            "seventh_position_price_for_week" => "required",
            "seventh_position_price_for_two_week" => "required",
            "seventh_position_price_for_month" => "required",
            "eighth_position_price_for_week" => "required",
            "eighth_position_price_for_two_week" => "required",
            "eighth_position_price_for_month" => "required",
            "ninth_position_price_for_week" => "required",
            "ninth_position_price_for_two_week" => "required",
            "ninth_position_price_for_month" => "required",
            "tenth_position_price_for_week" => "required",
            "tenth_position_price_for_two_week" => "required",
            "tenth_position_price_for_month" => "required",

        ]);
        //dd($request->all());
        DB::beginTransaction();
        $blog = new AppPromotionBlogs;
        $blog->name = $request->name;
        $blog->from = mysql_time($request->from);
        $blog->to = mysql_time($request->to);
        $blog->vendor_type =  $request->position;
        $blog->blog_type = $request->blog_type;
        $blog->blog_for = $request->master_blog;
        $blog->duration = '2';
        $blog->save();
        $id = $blog->id;
        blogPromotionPriceSetup($request->all(),$id);
        
        DB::commit();
        return redirect()->route('admin.application.blog')->with('message', 'Blog Created Successfully');

    }
    public function get_data_table_of_slote(Request $request)
    {
        if ($request->ajax()) {

            $data = AppPromotionBlogs::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('vendor_type', function($data){
                    if ($data->vendor_type == 1) {
                        return 'Restaurant';
                    } else {
                        return 'Chef';
                    }


                })
                ->addColumn('blog_type', function($data){
                    if ($data->blog_type == 1) {
                        return 'Vendor List';
                    } else {
                        return 'Product List';
                    }


                })

                ->addColumn('action-js', function($data){
                    $btn = '<a href="' . route("admin.application.blogedit", Crypt::encryptString($data->id)) . '" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  
                    <a href="'.route("admin.application.blog.history",Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs " data-alert-message="Are You Sure to Delete this Blog" flash="Blog"   title="Booking History" >Book History</a>
                    <a href="'.route("admin.application.blog.activecontent",Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs " data-alert-message="Are You Sure to Delete this Blog" flash="Blog"   title="Booking History" >Active Content</a>
                    ';
                    //<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Blog" flash="Blog"  data-action-url="' . route('admin.application.blog.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a>
                    return $btn;
                })
                ->addColumn('from_to', function ($data) {
                    //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'
                    
                    return date('h:i A',strtotime($data->from)).' TO '.date('h:i A',strtotime($data->to));
                })
                
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js','status'])
                ->make(true);
        }

    }
    function fun_edit_blog($encrypt_id){
        $id         = Crypt::decryptString($encrypt_id);
        $blog    = AppPromotionBlogs::findOrFail($id);
        $blogSettingforWeek = \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$blog->id,'blog_promotion_date_frame'=>'7'])->orderBy('blog_position','ASC')->get()->pluck('blog_price');
        $blogSettingforTwoWeek = \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$blog->id,'blog_promotion_date_frame'=>'14'])->orderBy('blog_position','ASC')->get()->pluck('blog_price');
        $blogSettingforMonth = \App\Models\AppPromotionBlogSetting::where(['app_promotion_blog_id'=>$blog->id,'blog_promotion_date_frame'=>'30'])->orderBy('blog_position','ASC')->get()->pluck('blog_price');
        
        return view('admin/promotion/edit-blog', compact('blog','blogSettingforWeek','blogSettingforTwoWeek','blogSettingforMonth'));
    }
    public function update(Request $request){
        $this->validate($request, [
            'position' => 'required',
            'blog_type' => 'required',
            'name' => 'required',
            'from' => 'required',
            'to' => 'required',
            'master_blog' => 'required',
            "first_position_price_for_week" => "required",
            "first_position_price_for_two_week" => "required",
            "first_position_price_for_month" => "required",
            "second_position_price_for_week" => "required",
            "second_position_price_for_two_week" => "required",
            "second_position_price_for_month" => "required",
            "third_position_price_for_week" => "required",
            "third_position_price_for_two_week" => "required",
            "third_position_price_for_month" => "required",
            "fourth_position_price_for_week" => "required",
            "fourth_position_price_for_two_week" => "required",
            "fourth_position_price_for_month" => "required",
            "fifth_position_price_for_week" => "required",
            "fifth_position_price_for_two_week" => "required",
            "fifth_position_price_for_month" => "required",
            "sixth_position_price_for_week" => "required",
            "sixth_position_price_for_two_week" => "required",
            "sixth_position_price_for_month" => "required",
            "seventh_position_price_for_week" => "required",
            "seventh_position_price_for_two_week" => "required",
            "seventh_position_price_for_month" => "required",
            "eighth_position_price_for_week" => "required",
            "eighth_position_price_for_two_week" => "required",
            "eighth_position_price_for_month" => "required",
            "ninth_position_price_for_week" => "required",
            "ninth_position_price_for_two_week" => "required",
            "ninth_position_price_for_month" => "required",
            "tenth_position_price_for_week" => "required",
            "tenth_position_price_for_two_week" => "required",
            "tenth_position_price_for_month" => "required",
        ]);
        $blog = AppPromotionBlogs::find($request->id);
        $blog->name = $request->name;
        $blog->from = mysql_time($request->from);
        $blog->to = mysql_time($request->to);
        $blog->vendor_type =  $request->position;
        $blog->blog_type = $request->blog_type;
        $blog->save();
        blogPromotionPriceUpdate($request->all(),$request->id);
        return redirect()->route('admin.application.blog')->with('message', 'Blog Update Successfully');
    }
    public function inactive($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);  
        $user = AppPromotionBlogs::find($id);
        AppPromotionBlogs::where('id','=', $user->id)->limit(1)->update( ['status' => 0]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Blog Inactive Successfully' ], 200);
       // return redirect()->back()->with('message', 'User Inactive Successfully.');
    }
    public function active($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);  
        $user = AppPromotionBlogs::find($id);
        AppPromotionBlogs::where('id','=', $user->id)->limit(1)->update( ['status' => 1]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Blog Active Successfully' ], 200);
    }
    public function soft_delete(Request $request)
    {
        try {
            $id   = Crypt::decryptString($request->id);
            $data = AppPromotionBlogs::findOrFail($id);
            if ($data) {
                $data->delete();
                return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Blog Deleted Successfully' ], 200);
            } else {
                return \Response::json([ 'error' => true, 'success' => false, 'error_message' => 'Finding data error' ], 200);
            }


        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json([ 'error' => true, 'success' => false, 'error_message' => $e->getMessage() ], 200);
        }
    }

    public function blogBookingHistory($encrypt_id)
    {
        try {
            $id   = Crypt::decryptString($encrypt_id);
            $blog = AppPromotionBlogs::findOrFail($id);
            $booking = \App\Models\AppPromotionBlogBooking::where('app_promotion_blog_bookings.app_promotion_blog_id','=',$id);
            $booking = $booking->join('app_promotion_blog_settings','app_promotion_blog_bookings.app_promotion_blog_setting_id','=','app_promotion_blog_settings.id');
            $booking = $booking->join('vendors','app_promotion_blog_bookings.vendor_id','=','vendors.id');
            $booking = $booking->select('app_promotion_blog_bookings.*','app_promotion_blog_settings.blog_position','app_promotion_blog_settings.blog_name','blog_price','blog_promotion_date_frame','vendors.name');
            $booking = $booking->where('app_promotion_blog_bookings.payment_status','=','1');
            $booking = $booking->orderBy('app_promotion_blog_bookings.id','desc');
            if($blog->blog_type == '2'){
                $booking = $booking->join('products','app_promotion_blog_bookings.product_id','=','products.id');
                $booking = $booking->addSelect('products.product_name',DB::raw('CONCAT("' . asset('products') . '/", product_image) AS product_image'));


            }
            $booking = $booking->get();
            
            return view('admin/promotion/booking-list',compact('booking','blog'));
            
            

        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json([ 'error' => true, 'success' => false, 'error_message' => $e->getMessage() ], 200);
        }
    }
    public function blogActiveContent($encrypt_id)
    {
        try {
            $id   = Crypt::decryptString($encrypt_id);
            $blog = AppPromotionBlogs::findOrFail($id);
            $booking = \App\Models\AppPromotionBlogBooking::where('app_promotion_blog_bookings.app_promotion_blog_id','=',$id);
            $booking = $booking->join('app_promotion_blog_settings','app_promotion_blog_bookings.app_promotion_blog_setting_id','=','app_promotion_blog_settings.id');
            $booking = $booking->join('vendors','app_promotion_blog_bookings.vendor_id','=','vendors.id');
            $booking = $booking->select('app_promotion_blog_bookings.*','app_promotion_blog_settings.blog_position','app_promotion_blog_settings.blog_name','blog_price','blog_promotion_date_frame','vendors.name');
            $booking = $booking->where('app_promotion_blog_bookings.payment_status','=','1');
            $booking = $booking->orderBy('app_promotion_blog_bookings.id','desc');
            if($blog->blog_type == '2'){
                $booking = $booking->join('products','app_promotion_blog_bookings.product_id','=','products.id');
                $booking = $booking->addSelect('products.product_name',DB::raw('CONCAT("' . asset('products') . '/", product_image) AS product_image'));


            }
            $booking = $booking->where('from_date','<=',\Carbon\Carbon::now());
            $booking = $booking->where('to_date','>=',\Carbon\Carbon::now());
            $booking = $booking->where('from_time','<=',mysql_time());
            $booking = $booking->where('to_time','>=',mysql_time());

            $booking = $booking->get();
            
            return view('admin/promotion/booking-list',compact('booking','blog'));
            
            

        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json([ 'error' => true, 'success' => false, 'error_message' => $e->getMessage() ], 200);
        }
    }

    public function create_blog()
    {
        return view('admin/promotion/create-app-blog');
    }
}
