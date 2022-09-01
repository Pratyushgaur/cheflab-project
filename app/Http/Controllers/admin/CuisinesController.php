<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuisines;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class CuisinesController extends Controller
{
    public function index(){
        
        $data= Cuisines::all();
        $class_name ='Category';
        return view('admin/cuisiness/create',compact('class_name'));
        
    }
    public function store_cuisines(Request $request)
    {
      // echo 'ok';die;
     // return $request->input();die;
        $this->validate($request, [
            'name' => 'required',
            'categoryImage' => 'required',
            'position' => 'required',
        ]);
        $catogory = new Cuisines;
        $catogory->name = $request->name;
        if($request->has('categoryImage')){
            $filename = time().'-categoryImage-'.rand(100,999).'.'.$request->categoryImage->extension();
            $request->categoryImage->move(public_path('cuisines'),$filename);
           // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);  
            $catogory->cuisinesImage  = $filename;
        }
        $catogory->position  = $request->position;;
        
        $catogory->save();
        return redirect()->route('admin.cuisines.create')->with('message', 'Cuisines Registration Successfully');
        

    }
    public function get_data_table_of_cuisines(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Cuisines::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. url("admin/edit-category") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fas fa-eye"></i></a>  
                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Cuisines" flash="Category"  data-action-url="' . route('admin.cuisines.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('status', function($data){
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'; 
                })
                ->addColumn('cuisinesImage', function($data){
                    return "<img src=".asset('cuisines').'/'.$data['cuisinesImage']." style='width:100px;height:100px;' />";
                })
                ->rawColumns(['date','action-js','status'])
                ->rawColumns(['action-js','cuisinesImage'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = Cuisines::findOrFail($id);
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
}
