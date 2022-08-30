<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product_master;
use App\Models\Catogory_master;
use App\Models\Cuisines;

use App\Models\vendors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables; 
class ProductController extends Controller
{
    
    public function index($encrypt_id){
       
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $vendor = vendors::findOrFail($id);
            $categories = Catogory_master::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
            $cuisines = Cuisines::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        
            if($vendor->vendor_type == 'restaurant'){
                return view('admin/product/create_restaurant_product',compact('vendor','categories','cuisines'));
            }elseif($vendor->vendor_type == 'chef'){
                return view('admin/category/edit',compact('vendor'));
            }else{
                return 'Wrong Route';
            }
            
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
        return view('admin/product/createproduct');
    }
    public function addProduct(Request $request)
    {
      // return $request->input();die;
       /*$this->validate($request, [
            'category' => 'required',
            'product_name' => 'required',
            'dis ' => 'required',
            'type ' => 'required',
            'product_owner ' => 'required',
            'product_keyword ' => 'required',
            'customisation ' => 'required'
        ]);*/
        $filename = '';
        if($request->has('product_image')){
            $filename = time().'_'.$request->file('product_image')->getClientOriginalName();
            $filePath = $request->file('product_image')->storeAs('public/product_image',$filename);  
        }else{
            $filePath = $request->admin_image_old;
        }
        $Product_master = new Product_master;
        $Product_master->product_name   = $request->product_name;
        $Product_master->category   = $request->category;
        $Product_master->dis   = $request->dis;
        $Product_master->userId   = $request->userId;
        $Product_master->status   = $request->status;
        $Product_master->type   = $request->type;
        $Product_master->product_owner   = $request->product_owner;
        $Product_master->product_keyword   = $request->product_keyword;
        $Product_master->customisation   = $request->customisation;
        $Product_master->product_image   = $filePath;
     //   var_dump($Product_master);die;
        $Product_master->save();
        return redirect()->route('admin-product')->with('message', 'City '. $msg);
    }
    /*function getProduct(Request $request){
        $list = Product_master::all();
         /* response()->json([
            'list'=>$list ,
        ]);
       return view('admin.product.list',compact($list));
      // return response()->json(['view' => View::make('admin.product.list', $list)->render(), 'list'=>$list]);
    }*/
    function list(Request $request){
         $data = Product_master::all();
       // var_dump($data);
        ;/*$data = response()->json([
            'list'=>$lists
        ]);*/
       // var_dump($data);die;
        return view('admin.product.list',['list'=>$data]);
     /*  if ($request->ajax()) {
            
        $data = Product_master::all();
        
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action-js', function($data){
                $btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('products') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                return $btn;
            })
            
            ->addColumn('date', function($data){
                $date_with_format = date('d M Y',strtotime($data->created_at));
                return $date_with_format;
            })

            
            ->rawColumns(['date'])
            ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
            ->make(true);
            return view('admin.product.list');
    }*/
    }   
   
    public function edit_product($id){
        $data = Product_master::find($id);
        return view('admin.product.edit',['data'=>$data]);
    }
    public function update(Request $request){
        $filename = '';
        if($request->has('product_image')){
            $filename = time().'_'.$request->file('product_image')->getClientOriginalName();
            $filePath = $request->file('product_image')->storeAs('public/product_image',$filename);  
        }else{
            $filePath = $request->admin_image_old;
        }
        $data = Product_master::find($request->$id);
        $data->product_name=$request->product_name;
        $data->product_name   = $request->product_name;
        $data->category   = $request->category;
        $data->dis   = $request->dis;
        $data->userId   = $request->userId;
        $data->status   = $request->status;
        $data->type   = $request->type;
        $data->product_owner   = $request->product_owner;
        $data->product_keyword   = $request->product_keyword;
        $data->customisation   = $request->customisation;
        $data->product_image   = $filePath;
        $data->save();
        return redirect('admin/product-list');
    }
    
    

}