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
                    $btn = '<a href="#" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>';
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                })

                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js','status'])
                ->make(true);
        }

    }
}
