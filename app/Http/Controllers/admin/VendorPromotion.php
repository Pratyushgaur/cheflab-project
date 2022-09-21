<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\SloteMaster;
use App\Models\VendorStorePromotipn;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class VendorPromotion extends Controller
{
    
    public function index(){

        return view('admin/vendors/store/list');
    }
    public function store(Request $request){
        $this->validate($request, [
            'slot_name' => 'required',
            'price' => 'required',
            'position' => 'required',
        ]);
        $banner = new VendorStorePromotipn;
        $banner->slot_name = $request->slot_name;
        $banner->price =  $request->price;
        $banner->position = $request->position;
        $banner->save();
        return redirect()->route('admin.vendor.store')->with('message', 'Store Create Successfully');
          
    }
    public function get_data_table_of_slote(Request $request)
    {
        if ($request->ajax()) {
            
            $data = VendorStorePromotipn::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
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