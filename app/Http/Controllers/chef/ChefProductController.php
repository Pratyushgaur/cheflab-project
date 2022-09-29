<?php

namespace App\Http\Controllers\chef;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Product_master;
use DataTables;
use Config;
use Auth;


class ChefProductController extends Controller
{
    public function index()
    {
        return view('vendor.chef.products.list');
    }
    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $data = Product_master::join('categories', 'products.category', '=', 'categories.id')->select('products.*', 'categories.name as categoryName')->where('products.userId', '=', Auth::guard('vendor')->user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<a href="#"><i class="fa fa-edit"></i></a>
                            <a  href="#"><i class="fa fa-trash"></i></a>
                    ';
                    return $btn;
                })
                ->addColumn('product_name', function($data){
                    $btn = ' <img src="'.asset('products').'/'.$data->product_image.'" data-pretty="prettyPhoto" style="width:50px; height:30px;" alt="Trolltunga, Norway"> <div id="myModal" class="modal">
                    <img class="modal-content" id="img01">
                  </div>'.$data->product_name.'';
                    return $btn;
                })
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('product_price', function ($data) {
                    $btn = '<i class="fas fa-rupee-sign"></i>' . $data->product_price . '';
                    return $btn;
                })
                ->addColumn('admin_review', function($data){
                    //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>' 
                    
                       if($data->status == 1){
                           return '<span class="badge badge-success">Active</span>';
                       }elseif($data->status == 2){
                           return '<span class="badge badge-primary">Pending</span>';
                       }elseif($data->status == 0){
                           return '<span class="badge badge-primary">Inactive</span>';
                       }else{
                        return '<a href="javascript:void(0)" class="openModal"  data-id="' . $data->comment_rejoin . '"><span class="badge badge-primary" data-toggle="modal" data-target="#modal-8">Reject</span></a>';
                       }
                   })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round offproduct" data-id="' . $data->id . '"></span></label>';
                    } elseif($data->status == 2) {
                        $btn = '<label class="ms-switch"><input type="checkbox" disabled> <span class="ms-switch-slider round"></span></label>';
                    }elseif($data->status == 0){
                        $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round onProduct" data-id="' . $data->id . '"></span></label>';
                    }


                    return $btn;
                })
                ->rawColumns(['date','action-js','product_name','product_price','status','admin_review'])
                ->rawColumns(['action-js','product_name','product_price','status','admin_review'])
                ->make(true);
        }
    }
    public function inActive(Request $request){
        $id = $request->id;
        $update = \DB::table('products')
        ->where('id', $id)
        ->update(['status' => '0']);
       return \Response::json($update);
    }
    public function Active(Request $request){
        $id = $request->id;
        $update = \DB::table('products')
        ->where('id', $id)
        ->update(['status' => '2']);
       return \Response::json($update);
    }
}