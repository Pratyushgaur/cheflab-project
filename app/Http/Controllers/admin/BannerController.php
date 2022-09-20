<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SloteMaster;
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
    public function get_data_table_of_slote(Request $request)
    {
        if ($request->ajax()) {
            
            $data = SloteMaster::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="#" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                })
               
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }
    public function fun_edit_slot($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $slote = SloteMaster::findOrFail($id);
           // dd($city_data);
            return view('admin/banner/editslote',compact('slote'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    public function slot_book_list(){
        return view('admin/banner/list');
        /*if ($request->ajax()) {
            
            $data = SloteMaster::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="#" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                })
               
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }*/
    }
    public function get_list_slotbook(Request $request){
        if ($request->ajax()) {
            
          //  $data = SloteBook::latest()->get();
            $data = \App\Models\SloteBook::where(['slotbooking_table.slot_status'=>'0'])->join('vendors','slotbooking_table.vendor_id','=','vendors.id')->select('slotbooking_table.banner','slot_id','date','slot_image','slot_status','vendors.name as restaurantName')->get();  
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '
                    <a href="'.route('admin.slot.comment',Crypt::encryptString($data->slot_id)).'" class="edit btn btn-warning btn-xs">Comment</a>
                    <a href="'.route('admin.slot.reject',Crypt::encryptString($data->slot_id)).'" class="edit btn btn-warning btn-xs">Reject</a>
                    ';
                    return $btn;
                })
                ->addColumn('slot_status', function($data){
                    return $status_class = (!empty($data->slot_status)) && ($data->slot_status == 0) ? '<button class="btn btn-xs btn-success">Active</button>' : '<a  href="'.route('admin.slot.active',Crypt::encryptString($data->slot_id)).'" class="btn btn-xs btn-danger">Pending</a>'; 
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                })

                ->addColumn('slot_image',function($data){
                    return "<img src=".asset('slot-vendor-image').'/'.$data->slot_image."  style='width: 50px;' />";
                })
                ->rawColumns(['date','action-js','slot_status','slot_image'])
                ->rawColumns(['action-js','slot_status','slot_image']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
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