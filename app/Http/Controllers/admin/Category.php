<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catogory_master;
use App\Models\Vendors;

use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class Category extends Controller
{
    
    public function index(){
        $data= Catogory_master::all();
        $class_name ='Category';
        return view('admin/category/create',compact('class_name'));
    }
    public function store_catogory(Request $request)
    {
      // echo 'ok';die;
     // return $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'categoryImage' => 'required',
            'position' => 'required',
        ]);
        $catogory = new Catogory_master;
        $catogory->name = $request->name;
        if($request->has('categoryImage')){
            $filename = time().'-categoryImage-'.rand(100,999).'.'.$request->categoryImage->extension();
            $request->categoryImage->move(public_path('categories'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);  
            $catogory->categoryImage  = $filename;
        }
        $catogory->position  = $request->position;;
        
        $catogory->save();
        return redirect()->route('admin.category.store')->with('message', 'Category Registration Successfully');
        

    }
    public function get_data_table_of_category(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Catogory_master::latest()->orderBy('id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("admin.category.edit",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs"><i class="nav-icon fas fa-edit"></i></a>  
                            <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Category" flash="City"  data-action-url="' . route('admin.category.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a>
                            <a taget="_blank" href="'.route('admin.category.restaurant',Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs"  flash="City"   title="View Restaurant" ><i class="fa fa-building"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                })
                ->addColumn('categoryImage', function($data){
                    return "<img src=".asset('categories').'/'.$data['categoryImage']." style='width:100px;height:100px;' />";
                })
                ->addColumn('is_active', function ($data) {
                    //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'

                    if ($data->is_active == 1) {
                        $btn = '<a href="javascript:void(0);" data-action-url="'. route("admin.category.inactive",Crypt::encryptString($data->id)) .'" class="btn btn-success btn-xs inactive-record" data-alert-message="Are You Sure to Inactive this Category" flash="Category"   title="Inactive" >Active</a> ';
                    }else {
                        $btn = '<a href="javascript:void(0);" data-action-url="'. route("admin.category.active",Crypt::encryptString($data->id)) .'" class="btn btn-danger btn-xs active-record" data-alert-message="Are You Sure to Active this Category" flash="Category"   title="Active" >Inactive</a> ';
                    }
                    return $btn;
                })
                ->addColumn('no_of_res', function($data){
                    return Vendors::whereRaw(DB::raw("FIND_IN_SET(".$data->id.", vendors.deal_categories)"))->get()->count();
                })
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js','categoryImage','is_active'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }
    public function fun_edit_category($encrypt_id)
    {
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $city_data = Catogory_master::findOrFail($id);
           // dd($city_data);
            return view('admin/category/edit',compact('city_data'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }

    public function category_restaurant($encrypt_id)
    {
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $vendors =  Vendors::whereRaw(DB::raw("FIND_IN_SET(".$id.", vendors.deal_categories)"))->get();
            $category = Catogory_master::findOrFail($id);
            return view('admin/category/vendor_list',compact('vendors','category'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = Catogory_master::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'Category Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            } 
            
            
            
        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }
    public function check_duplicate_category(Request $request ,$id=null)
    {
        if (Catogory_master::where('name','=',$request->name)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function check_edit_duplicate_category(Request $request,$id)
    {
        $city = Catogory_master::where('name','=',$request->name);
        $city = $city->where('id','!=',$id);
        if ($city->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function update(Request $request){
        //return $request->input();die;
        $this->validate($request, [
           'name' => 'required',
           'position' => 'required',
       ]);
       $catogory = Catogory_master::find($request->id);
       $catogory->name = $request->name;
       if($request->has('categoryImage')){
           $filename = time().'-categoryImage-'.rand(100,999).'.'.$request->categoryImage->extension();
           $request->categoryImage->move(public_path('categories'),$filename);
          // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);  
           $catogory->categoryImage  = $filename;
       }
       $catogory->position  = $request->position;;
       
       $catogory->save();
       return redirect()->route('admin.category.store')->with('message', 'Category Registration Successfully');
       
    }  
    public function inactive($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);  
        $user = Catogory_master::find($id);
        Catogory_master::where('id','=', $user->id)->limit(1)->update( ['is_active' => 0]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Catogory Inactive Successfully' ], 200);
       // return redirect()->back()->with('message', 'User Inactive Successfully.');
    }
    public function active($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);  
        $user = Catogory_master::find($id);
        Catogory_master::where('id','=', $user->id)->limit(1)->update( ['is_active' => 1]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Catogory Active Successfully' ], 200);
    }
}