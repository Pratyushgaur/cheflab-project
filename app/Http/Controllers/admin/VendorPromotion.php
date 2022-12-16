<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SloteMaster;
use App\Models\VendorStorePromotipn;
use App\Models\AppPromotionBlogs;

use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
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
            'to' => 'required'
        ]);
        $blog = new AppPromotionBlogs;
        $blog->name = $request->name;
        $blog->from = mysql_time($request->from);
        $blog->to = mysql_time($request->to);
        $blog->vendor_type =  $request->position;
        $blog->blog_type = $request->blog_type;
        $blog->save();

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
                        return 'Vendor';
                    } else {
                        return 'Product';
                    }


                })

                ->addColumn('action-js', function($data){
                    $btn = '<a href="' . route("admin.application.blogedit", Crypt::encryptString($data->id)) . '" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a> <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Blog" flash="Blog"  data-action-url="' . route('admin.application.blog.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                ->addColumn('status', function ($data) {
                    //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'

                    if ($data->status == 1) {
                        $btn = '<a href="javascript:void(0);" data-action-url="'. route("admin.application.blog.inactive",Crypt::encryptString($data->id)) .'" class="btn btn-success btn-xs inactive-record" data-alert-message="Are You Sure to Inactive this Category" flash="Category"   title="Inactive" >Active</a> ';
                    }else {
                        $btn = '<a href="javascript:void(0);" data-action-url="'. route("admin.application.blog.active",Crypt::encryptString($data->id)) .'" class="btn btn-danger btn-xs active-record" data-alert-message="Are You Sure to Active this Category" flash="Category"   title="Active" >Inactive</a> ';
                    }
                    return $btn;
                })
                
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js','status'])
                ->make(true);
        }

    }
    function fun_edit_blog($encrypt_id){
        $id         = Crypt::decryptString($encrypt_id);
        $blog    = AppPromotionBlogs::findOrFail($id);
        return view('admin/promotion/edit-blog', compact('blog'));
    }
    public function update(Request $request){
        $this->validate($request, [
            'position' => 'required',
            'blog_type' => 'required',
            'name' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);
        $blog = AppPromotionBlogs::find($request->id);
        $blog->name = $request->name;
        $blog->from = mysql_time($request->from);
        $blog->to = mysql_time($request->to);
        $blog->vendor_type =  $request->position;
        $blog->blog_type = $request->blog_type;
        $blog->save();
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
}
