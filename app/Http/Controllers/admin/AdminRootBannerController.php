<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RootImage;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class AdminRootBannerController extends Controller
{
 //test vikas   
    public function index(){

        return view('admin/banner/root/list');
    }
    public function get_data_table_of_slote(Request $request){
        if ($request->ajax()) {
            
            $data = RootImage::where('is_active','=',1)->where('banner_for','=',$request->rolename)->select('id','name','bannerImage','position')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("admin.rootimage.edit",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('bannerImage',function($data){
                    return "<img src=".asset('admin-banner').'/'.$data->bannerImage."  style='width: 50px;' />";
                })
               
                ->rawColumns(['date','action-js','bannerImage'])
                ->rawColumns(['action-js','bannerImage']) 
                //'. route("admin.slote.edit",Crypt::encryptString($data->id)) .'
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }   
    public function fun_edit_image($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $root = RootImage::findOrFail($id);
            $vendors = \App\Models\Vendors::where('is_all_setting_done',1)->where('status',1)->select('id','name')->get();
            return view('admin/banner/root/editimage',compact('root','vendors'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    } 
    public function updateBanner(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
        $root = RootImage::find($request->id);
        $root->name = $request->name;
        if($request->has('bannerImage')){
            $filename = time().'-bannerImage-'.rand(100,999).'.'.$request->bannerImage->extension();
            $request->bannerImage->move(public_path('admin-banner'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);  
            $root->bannerImage  = $filename;
        }
        $root->redirect_vendor_id = $request->vendor_id;
        $root->save();
        return redirect()->route('admin.root.banner')->with('message', 'Banner Update Successfully');
    }   
}