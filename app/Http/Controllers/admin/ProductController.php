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
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = Product_master::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'Product Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            } 
            
            
            
        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }

    //
    
    public function cheflabProduct()
    {
        return view('admin.product.cheflab-product-list');
    }
    public function createChefLabProduct()
    {
        $categories = Catogory_master::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        $cuisines = Cuisines::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        return view('admin.product.create_cheflab_product',compact('categories','cuisines'));
    }

    public function storeChefLabProduct(Request $request){
        //  return $request->input();die;
          $this->validate($request, [
              'product_name' => 'required',
              'dis' => 'required',
              'product_price' => 'required',
              'product_image' => 'required',
          ]);
          $product = new Product_master;
          $product->product_name = $request->product_name;
          $product->userId = $request->userId_;
          $product->cuisines = $request->cuisines;
          $product->category  = $request->category;
          $product->dis  = $request->dis;
          $product->product_price  = $request->product_price;
          $product->product_for  = 1;
          
          
          if($request->customizable == 'true'){
              $data = [];
              foreach($request->variant_name as $k =>$v){
                  $data[] = array('variant_name' =>$v ,'price' =>$request->variant_price[$k]);
              }
             
              $request->variants = serialize($data);
          }
          $product->type  = $request->type;
          $product->customizable  = $request->customizable;
          if($request->has('product_image')){
              $filename = time().'-chef-product-'.rand(100,999).'.'.$request->product_image->extension();
              $request->product_image->move(public_path('products'),$filename);
              $product->product_image  = $filename;
          }
          $product->save();
          return redirect()->route('admin.product.cheflabProduct')->with('message', 'Chef Product  Registration Successfully');
          
      }
    public function cheflab_product_list(Request $request){
        
       // dd($user);
          if ($request->ajax()) {
            $data = Product_master::select('id','product_name','product_image','product_price','type','created_at');
            $data = $data->where('product_for','=','1');
            $data = $data->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="" class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>  
                            <a href="javascript:void(0);" data-id="" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.product.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('product_image',function($data){
                    return "<img src=".asset('products').'/'.$data->product_image."  style='width: 50px;' />";
                })
                
                
                ->rawColumns(['date'])
                ->rawColumns(['action-js','product_image']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
        
    }
    public function vendorProductList(Request $request){
        return view('admin/product/pendinglist');
    }
    public function rejectProduct(Request $request){
      //  return $request->input();die;
        $this->validate($request, [
            'comment_rejoin' => 'required',
        ]);
        $id = $request->id;
        $product = Product_master::find($id);
        $product->comment_rejoin = $request->comment_rejoin;
        $product->product_activation = 3;
        $product->save();
        return redirect()->route('admin.vendor.pendigProduct')->with('message', 'Product Reject Successfully');
    }
    public function getPendingList(Request $request){
        if ($request->ajax()) {
            
            $data = Product_master::latest()->get();
            if($request->rolename != ''){
               $data =  $data->where('status','=',$request->rolename);
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
                                    <a class="dropdown-item text-info" href="'.route('admin.vendor.product',Crypt::encryptString($data->id)).'"><i class="fa fa-eye"></i> View Product</a>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" data-id="" data-alert-message="Are You Sure to Delete this Vendor" data-action-url="' . route('admin.vendors.ajax.delete') . '" ><i class="fas fa-trash"></i> Delete</a>';
                                    
                                    /*if($data->vendor_type == 'chef'){
                                        $btn .= '<a class="dropdown-item text-danger" href="'.route('admin.chefproduct.view',Crypt::encryptString($data->id)).'"><i class="fa-solid fa-bowl-food"></i>Add/View  Product</a>';    
                                    }*/
                                    
                                    
                               
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
            ->addColumn('product_image',function($data){
                return "<img src=".asset('products').'/'.$data->product_image."  style='width: 50px;' />";
            })
            
            
            ->rawColumns(['date'])
            ->rawColumns(['action-js','product_image']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
            ->make(true);
        }
    }
    public function view_product($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);
        $product = Product_master::findOrFail($id);
        $vendor = vendors::findOrFail($product->userId);
        return view('admin/product/view-vendor',compact('vendor','product'));
    }
    public function venderProduct(Request $request,$id){
        $user = $request->id;
        if ($request->ajax()) {
            $data = Product_master::where('userId','=',$user)->select('id','product_name','category','product_image','status','product_price','type','created_at')->get();
          
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '
                    <a href="javascript:void(0);" data-id="" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.product.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a>
                    <a href="'. route("admin.vendor.productactive",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs">Accept</a> 
                    ';
                            if($data->status == 2){
                                $btn .= '<a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-xs openModal" data-toggle="modal" data-target="#modal-default">
                                Reject
                            </a>
                            
                            
                            
                            '
                            
                            ;    
                            }
                             return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('product_image',function($data){
                    return "<img src=".asset('products').'/'.$data->product_image."  style='width: 50px;' />";
                })
                
                ->addColumn('status', function($data){
                 //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>' 
                 
                    if($data->status == 1){
                        return '<span class="badge badge-success">Active</span>';
                    }elseif($data->status == 2){
                        return '<span class="badge badge-primary">Pending</span>';
                    }elseif($data->status == 0){
                        return '<span class="badge badge-primary">Inactive</span>';
                    }else{
                        return '<span class="badge badge-primary">Reject</span>';
                    }
                })
                ->rawColumns(['date','status'])
                ->rawColumns(['action-js','product_image','status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
        
    }
    public function activeProduct($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);
         $update = \DB::table('products') ->where('id', $id) ->limit(1) ->update( ['product_activation' => 1 ]); 
         return redirect()->route('admin.vendor.pendigProduct')->with('message', 'Product Accept Successfully');
    }
}