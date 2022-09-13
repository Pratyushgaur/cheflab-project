<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
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
      //  return  $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'max_no_banner' => 'required',
        ]);
        $data = Banner::latest()->get();
        //dd($request->from_time);
        foreach($data as $k =>$v){
            if($v->to_time < $request->to_time){
                $banner = new Banner;
                $banner->name = $request->name;
                $banner->from_time = date('H:i',strtotime($request->from_time));
                $banner->to_time = date('H:i',strtotime($request->to_time));
                $banner->max_no_banner = $request->max_no_banner;
                $banner->banner = implode(',',$request->banner);
                $banner->save();
                return redirect()->route('admin.banner.createbanner')->with('message', 'Slote Create Successfully');
            }else{
                return redirect()->route('admin.banner.createbanner')->with('message', 'Slote Is Allredy Book');
            }
        }
        
        
        
    }
    public function get_data_table_of_slote(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Banner::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="#" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>';
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
    public function check_duplicate_slotename(Request $request ,$id=null)
    {

        if (Banner::where('name','=',$request->name)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checktime(Request $request,$id=null){
        // $fm = $request->from_time;
      //   echo $fm;die;
        if (Banner::where('from_time','=',$request->from_time)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
}