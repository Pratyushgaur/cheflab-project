<?php

namespace App\Http\Controllers\Admin;
use App\Models\vendors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables; 
use Illuminate\Support\Facades\Hash;
class UserControllers extends Controller
{
    
    public function index(){
        
        return view('admin/vendors/list');
    }
    public function create_restourant()
    {
        return view('admin/vendors/restourant_create');
    }
    public function get_data_table_of_vendord(Request $request)
    {
        if ($request->ajax()) {
            
            $data = vendors::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
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
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }

    public function checkEmailExist(Request $request)
    {   
        
        if (vendors::where('email','=',$request->email)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function checkMobileExist(Request $request)
    {
        if (vendors::where('mobile','=',$request->phone)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    
    public function store_restourant(Request $request)
    {
        $this->validate($request, [
            'restourant_name' => 'required',
            'email' => 'required|unique:vendors,email',
            'pincode' => 'required',
            'phone' => 'required|unique:vendors,mobile',
            'address' => 'required',
            'fassai_lic_no' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',

        ]);
        $vendors = new vendors;
        $vendors->name = $request->restourant_name;
        $vendors->email = $request->email;
        $vendors->password = Hash::make($request->password);
        $vendors->vendor_type = 'restaurant';
        $vendors->mobile  = $request->phone;
        $vendors->pincode  = $request->pincode;
        $vendors->address  = $request->address;
        $vendors->fassai_lic_no  = $request->fassai_lic_no;
        if($request->has('image')){
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);  
            $vendors->image  = $filePath;
        }
        //
        if($request->has('fassai_image')){
            $filename = time().'_'.$request->file('fassai_image')->getClientOriginalName();
            $filePath = $request->file('fassai_image')->storeAs('public/fassai_lic',$filename);  
            $vendors->licence_image  = $filePath;
        }
        $vendors->save();
        return redirect()->route('admin.restourant.create')->with('message', 'Vendor Registration Successfully');
        

    }
}
