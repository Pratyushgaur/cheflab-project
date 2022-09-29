<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SloteMaster;
use App\Models\vendors;
use App\Models\VendorMenus;
use App\Models\SloteBook;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class BannerController extends Controller
{
    
    public function index(){

        return view('admin/banner/createbanner');
    }
    public function store_banner(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'slote_date' => 'required',
            'max_no_banner' => 'required',
        ]);
        $banner = new Banner;
        $banner->name = $request->name;
        $banner->slote_date =  $request->slote_date;
        $banner->max_no_banner = $request->max_no_banner;
        $banner->banner = implode(',',$request->banner);
        $banner->save();
        return redirect()->route('admin.banner.createbanner')->with('message', 'Slote Create Successfully');
          
    } 
    public function updateSlot(Request $request){
        $this->validate($request, [
            'slot_name' => 'required',
            'price' => 'required',
        ]);
        $slot = SloteMaster::find($request->id);
        $slot->slot_name = $request->slot_name;
        $slot->price =  $request->price;
        $slot->save();
        return redirect()->route('admin.banner.createbanner')->with('message', 'Slote Update Successfully');
    }
    public function slotCheck(Request $request,$id){
        $slot = SloteMaster::where('slot_name','=',$request->slot_name);
        $slot = $slot->where('id','!=',$id);
        if ($slot->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function get_data_table_of_slote(Request $request)
    {
        if ($request->ajax()) {
            
            $data = SloteMaster::where('status','=',1)->select('id','slot_name','position','price')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("admin.slot.edit",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }
    public function getVendorBanner(Request $request,$id){
        $user = $request->id;
        if ($request->ajax()) {
            $data = SloteBook::where('vendor_id','=',$user)->where('slot_status','=','0')->select('slot_id','slot_name','position','price','slot_image','date')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '
                    <a  href="'.route('admin.slot.active',Crypt::encryptString($data->slot_id)).'" class="btn btn-xs btn-success">Accept</a>
                    <a href="javascript:void(0)" data-id="' . $data->slot_id . '" class="btn btn-warning btn-xs openModal" data-toggle="modal" data-target="#modal-default">
                        Reject
                    </a>
                    ';
                    return $btn;
                })
            
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('slot_image',function($data){
                    return "<img src=".asset('slot-vendor-image').'/'.$data->slot_image."  style='width: 50px;' />";
                })
                ->rawColumns(['date','action-js','slot_image'])
                ->rawColumns(['action-js','slot_image']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function fun_edit_slot($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $slot = SloteMaster::findOrFail($id);
            return view('admin/banner/editslote',compact('slot'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    public function slot_book_list(){
        return view('admin/banner/list');
    }
    public function rejectProduct(Request $request){
        $this->validate($request, [
            'comment_reason' => 'required',
        ]);
      //  var_dump($request->slot_id);die;
        $product = SloteBook::find($request->slot_id);
        $product->comment_reason = $request->comment_reason;
        $product->is_active = '0';
        $product->save();
        return redirect()->route('admin.vendor.pendigProduct')->with('message', 'Reject Successfully');
      }
    public function get_list_slotbook(Request $request){
        if ($request->ajax()) {
            
           $data = SloteBook::latest()->orderby('date','DESC')->get();
            if($request->rolename != ''){
                $data =  $data->where('is_active','=',$request->rolename);
             }
           // $data = \App\Models\SloteBook::where(['slotbooking_table.slot_status'=>'0'])->join('vendors','slotbooking_table.vendor_id','=','vendors.id')->orderby('date','DESC')->select('slotbooking_table.banner','slot_id','date','slot_image','slot_status','vendors.name as restaurantName')->get();  
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        
                                        
                                       
                                        <a class="dropdown-item text-info" href="'.route('admin.slot.view',Crypt::encryptString($data->id)).'"><i class="fa fa-eye"></i> View Product</a>
                                       ';
                                        
                                        
                                        
                                   
                                    $btn .= '</div>
                                </li>
                            </ul>';
                    //$btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a><a href="'.route('admin.vendor.product.create',Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs"    title="Add Product" >Add Product</a> ';
                    return $btn;
                })
               /* ->addColumn('action-js', function($data){
                    $btn = '
                    <a  href="'.route('admin.slot.active',Crypt::encryptString($data->slot_id)).'" class="btn btn-xs btn-success">Accept</a>
                    <a href="javascript:void(0)" data-id="' . $data->slot_id . '" class="btn btn-warning btn-xs openModal" data-toggle="modal" data-target="#modal-default">
                        Reject
                    </a>

                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.product.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a>
                    ';
                    return $btn;
                })*/
                ->addColumn('slot_status', function($data){
                    return $status_class = (!empty($data->slot_status)) && ($data->slot_status == 0) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-warning">Pending</button>'; 
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                })

                ->addColumn('slot_image',function($data){
                    return "<img src=".asset('slot-vendor-image').'/'.$data->slot_image."  style='width: 50px;' />";
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns(['date','action-js','slot_status','slot_image'])
                ->rawColumns(['action-js','slot_status','slot_image']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function slotView($encrypt_id){
        $slot_id =  Crypt::decryptString($encrypt_id);
        $slot = SloteBook::findOrFail($slot_id);
        $vendor = vendors::findOrFail($slot->vendor_id);
        $menu = VendorMenus::findOrFail($slot->vendor_id);
        return view('admin/banner/view-vendor',compact('slot','vendor','menu'));
    }
    public function check_duplicate_slotename(Request $request ,$id=null)
    {

        if (Banner::where('name','=',$request->name)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function active($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);
       // $UpdateDetails = SloteBook::where('status', 1)->first();
        $update = \DB::table('slotbooking_table') ->where('slot_id', $id) ->limit(1) ->update( [ 'status' => 1 ]); 
        return redirect()->route('admin.slotebook.list')->with('message', 'Slote Active Successfully');
    }
    public function reject($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);
        // $UpdateDetails = SloteBook::where('status', 1)->first();
         $update = \DB::table('slotbooking_table') ->where('slot_id', $id) ->limit(1) ->update( [ 'status' => 2 ]); 
         return redirect()->route('admin.slotebook.list')->with('message', 'Slote Reject Successfully');
    }
    public function comment($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $comment = SloteBook::findOrFail($id);
            return view('admin/banner/comment',compact('comment'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    public function commentstore(Request $request){
        $vendors = SloteBook::find($request->slot_id);
        $vendors->comment = $request->comment;
        $vendors->save();
        return redirect()->route('admin.slotebook.list')->with('message', 'Slote Comment Successfully');
    }
    public function checktime(Request $request,$id=null){
        // $fm = $request->from_time;
      //   echo $fm;die;
        if (Banner::where('slote_date','=',$request->slote_date)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
}