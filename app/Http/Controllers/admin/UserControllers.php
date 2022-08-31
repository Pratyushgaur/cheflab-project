<?php

namespace App\Http\Controllers\Admin;
use App\Models\vendors;
use App\Models\User;
use App\Models\Catogory_master;
use App\Models\Cuisines;

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
    public function create_chef()
    {
        return view('admin/vendors/chef_create');
    }
    public function get_data_table_of_vendor(Request $request)
    {
        if ($request->ajax()) {
            
            $data = vendors::latest()->get();
            if($request->rolename != ''){
               $data =  $data->where('vendor_type','=',$request->rolename);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item text-info" href="#"><i class="fas fa-edit"></i> Edit</a>
                                        <a class="dropdown-item text-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
                                        <a class="dropdown-item text-info" href="'.route('admin.vendor.view',Crypt::encryptString($data->id)).'"><i class="fa fa-eye"></i> View More</a>';
                                        
                                        if($data->vendor_type == 'chef'){
                                            $btn .= '<a class="dropdown-item text-danger" href="'.route('admin.vendor.product.create',Crypt::encryptString($data->id)).'"><i class="fa-solid fa-bowl-food"></i>Add/View  Product</a>';    
                                        }
                                        
                                        
                                   
                                    $btn .= '</div>
                                </li>
                            </ul>';
                    //$btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a><a href="'.route('admin.vendor.product.create',Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs"    title="Add Product" >Add Product</a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                })

                ->addColumn('image',function($data){
                    return "<img src=".asset('vendors').'/'.$data->image."  style='width: 50px;' />";
                })
                
                ->rawColumns(['date','action-js','status','image'])
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
            'restaurant_name' => 'required',
            'email' => 'required|unique:vendors,email',
            'pincode' => 'required',
            'phone' => 'required|unique:vendors,mobile',
            'address' => 'required',
            'fssai_lic_no' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'vendor_commission' => 'required',

        ]);
        $vendors = new vendors;
        $vendors->name = $request->restaurant_name;
        $vendors->email = $request->email;
        $vendors->password = Hash::make($request->password);
        $vendors->vendor_type = 'restaurant';
        $vendors->mobile  = $request->phone;
        $vendors->pincode  = $request->pincode;
        $vendors->address  = $request->address;
        $vendors->fssai_lic_no  = $request->fssai_lic_no;
        $vendors->commission  = $request->vendor_commission;
        
        if($request->has('image')){
            $filename = time().'-profile-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('vendors'),$filename);
            $vendors->image  = $filename;
        }else{
            $vendors->image  = 'default_restourant_image.jpg';
        }
        if($request->has('fassai_image')){
            $filename = time().'-document-'.rand(100,999).'.'.$request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'),$filename);
            $vendors->licence_image  = $filename;
        }
        if($request->has('other_document')){
            $filename = time().'-other-document-'.rand(100,999).'.'.$request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'),$filename);
            $vendors->other_document_image  = $filename;
            $vendors->other_document  = $request->other_document_name;
        }
        $vendors->save();
        return redirect()->route('admin.restourant.create')->with('message', 'Vendor Registration Successfully');
        

    }
    public function store_chef(Request $request)
    {
        $this->validate($request, [
            'restourant_name' => 'required',
            'email' => 'required|unique:vendors,email',
            'pincode' => 'required',
            'phone' => 'required|unique:vendors,mobile',
            'address' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'vendor_commission' => 'required',

        ]);
        $vendors = new vendors;
        $vendors->name = $request->restourant_name;
        $vendors->email = $request->email;
        $vendors->password = Hash::make($request->password);
        $vendors->vendor_type = 'chef';
        $vendors->mobile  = $request->phone;
        $vendors->pincode  = $request->pincode;
        $vendors->address  = $request->address;
        if($request->has('image')){
            $filename = time().'-profile-'.rand(100,999).'.'.$request->image->extension();
            $request->image->move(public_path('vendors'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);  
            $vendors->image  = $filename;
        }else{
            $vendors->image  = 'default_chef_image.jpg';
        }
        if($request->has('fassai_image')){
            $filename = time().'-document-'.rand(100,999).'.'.$request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'),$filename);
            $vendors->licence_image  = $filename;
        }
        if($request->has('other_document')){
            $filename = time().'-other-document-'.rand(100,999).'.'.$request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'),$filename);
            $vendors->other_document_image  = $filename;
            $vendors->other_document  = $request->other_document_name;
        }
        //
        // if($request->has('fassai_image')){
        //     $filename = time().'_'.$request->file('fassai_image')->getClientOriginalName();
        //     $filePath = $request->file('fassai_image')->storeAs('public/fassai_lic',$filename);  
        //     $vendors->licence_image  = $filename;
        // }
        $vendors->save();
        return redirect()->route('admin.chef.create')->with('message', 'Vendor Registration Successfully');
        

    }
    public function view_vendor($encrypt_id)
    {
        $id =  Crypt::decryptString($encrypt_id);
        $vendor = vendors::findOrFail($id);
        $categories = Catogory_master::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        $cuisines = Cuisines::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        return view('admin/vendors/view-vendor',compact('vendor','categories','cuisines'));
    }
    public function tetsapi(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user ||  $request->password !=$user->password) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }

    public function getData(Request $request)
    {
         return response($request->user(), 201);
    }

    
}
