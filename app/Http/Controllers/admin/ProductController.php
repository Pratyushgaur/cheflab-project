<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product_master;
use App\Models\Catogory_master;
use App\Models\Variant;
use App\Models\Cuisines;
use App\Models\VendorMenus;
use App\Models\Vendors;

use App\Notifications\ProductReviewNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use DataTables;
class ProductController extends Controller
{

    public function index($encrypt_id){

        try {
            $id =  Crypt::decryptString($encrypt_id);
            $vendor = Vendors::findOrFail($id);
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
              'preparation_time'=>"required"
          ]);
          $product = new Product_master;
          $product->product_name = $request->product_name;
          $product->userId = $request->userId_;
          $product->cuisines = $request->cuisines;
          $product->category  = $request->category;
          $product->dis  = $request->dis;
          $product->product_price  = $request->product_price;
          $product->product_for  = 1;
          $product->preparation_time  = $request->preparation_time;

          $product->type  = $request->type;
          $product->customizable  = $request->customizable;
          if($request->has('product_image')){
              $filename = time().'-chef-product-'.rand(100,999).'.'.$request->product_image->extension();
              $request->product_image->move(public_path('products'),$filename);
              $product->product_image  = $filename;
          }
          $product->save();
          //
         /*if ($request->custimization == 'true')
                foreach ($request->variant_name as $k => $v) {
                    Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
                }*/
            if ($request->custimization == 'true')
                foreach ($request->variant_name as $k => $v) {
                    Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
            }
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
                    <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.product.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
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
        $vendor = vendors::where('vendor_type','=','restaurant')->where('status','1')->select('id','name')->get();
        // $v =  Product_master::where('product_for','=','3')->where('products.status','=','2')->join('categories', 'products.category', '=', 'categories.id')->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.*', 'categories.name as categoryName','vendors.name as restaurantName','vendor_type','email')->get();
        // if ($request->rolename != '')
        //     $v->where('status', '=', $request->rolename);
        // if ($request->search != ''){
        //     $search = $request->search;
        //     $v->where(function ($q) use ($search) {
        //         $q->where('status', 'like', '%' . $search . '%')
        //             ->orWhere('name', 'like', '%' . $search . '%')
        //             ->orWhere('email', 'like', '%' . $search . '%');
        //     });
        // }
        // $vendors = $v;
        return view('admin/product/pendinglist',compact('vendor'));
    }
    public function rejectProduct(Request $request){
        $this->validate($request, [
            'cancel_reason' => 'required',
        ]);
        $product = Product_master::find($request->id);
        $product->cancel_reason = $request->cancel_reason;
        $product->status = '3';
        $product->save();
        $vendor=Vendors::find($product->userId);
        $vendor->notify(new ProductReviewNotification($product->id,\Auth::guard('admin')->user()->name,"$product->product_name product rejected by admin.Reason: $request->cancel_reason")); //With new post
        return redirect()->route('admin.vendor.pendigProduct')->with('message', 'Product Reject Successfully');
    }
    public function getPendingList(Request $request){
       // $data1 = Product_master::where('product_for','=','3')->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.*',  'vendors.name as restaurantName')->get();
       // $data = Product_master::where('product_for','=','3')->join('categories', 'products.category', '=', 'categories.id')->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.*', 'categories.name as categoryName')->get();
       // echo $data1;die;
        if ($request->ajax()) {
            $data = Product_master::where('product_for','=','3')->where('products.status','=','2')->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.*','vendors.name as restaurantName')->get();
            if($request->rolename != ''){
                $data =  Product_master::where('products.status','=',$request->rolename)->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.*','vendors.name as restaurantName')->get();
             }elseif($request->restaurant != ''){
                $data =  Product_master::where('userId','=',$request->restaurant)->join('vendors', 'products.userId', '=', 'vendors.id')->select('products.*','vendors.name as restaurantName')->get();
             }
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action-js', function($data){
                $btn = '
                <a href="javascript:void(0)" data-id="' . $data->id . '" class="btn btn-danger btn-xs openModal" data-toggle="modal" data-target=".bd-example-modal-lg">
                    View
                </a>';
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
    public function view_product($encrypt_id){
        $id =  Crypt::decryptString($encrypt_id);
        $product = Product_master::findOrFail($id);
        $vendor = vendors::findOrFail($product->userId);
        $menu = VendorMenus::findOrFail($product->userId);
      //  $vendor = vendors::join('categories', 'vendors.deal_categories', '=', 'categories.id')->where(['vendors.id' => $product->userId])->select('vendors.*', 'categories.name as categoryName')->get();

        return view('admin/product/view-vendor',compact('vendor','product','menu'));
    }
    public function venderId(Request $request){
        $id = $request->id;
        $product = Product_master::findOrFail($id);
        $category = Product_master::where('userId','=',$product->userId)->join('categories', 'products.category', '=', 'categories.id')->select('products.*', 'categories.name as categoryName')->get();
        $cuisines = Product_master::where('userId','=',$product->userId)->join('cuisines', 'products.cuisines', '=', 'cuisines.id')->select('products.*', 'cuisines.name as cuisinesName')->get();
        $vendor = vendors::findOrFail($product->userId);
     //   $menu = VendorMenus::findOrFail($vendor->userId);
       // var_dump($vendor);die;
        return \Response::json(['product' => $product,'category' => $category,'cuisines' => $cuisines,'cuisines' => $cuisines,'vendor' => $vendor], 200);
    }
    public function venderProduct(Request $request,$id){
        $user = $request->id;
        if ($request->ajax()) {
          //  $data = Product_master::where('userId','=',$user)->where('status','=','2')->select('id','product_name','category','product_image','status','product_price','type','created_at')->get();
          $data = Product_master::where('userId','=',$user)->where('status','=','2')->join('categories', 'products.category', '=', 'categories.id')->select('products.*', 'categories.name as categoryName')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '

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
    public function activeProduct(Request $request){
        $id =  $request->id;
      //  $product = Product_master::where('id','=', $id)->update(['status' => '1']);
        $product = Product_master::where('id','=', $id);
        $product = $product->first();
        Product_master::where('id','=', $id) ->limit(1)->update( ['status' => 1 ,'product_approve' => 1]);
        //var_dump($product->userId);die;
        $vendor = Vendors::where('id','=',$product->userId)->select('deal_categories','deal_cuisines')->first();
        $categories  = explode(',',$vendor->deal_categories);
        if(!in_array($product->category,$categories)){
            array_push($categories,$product->category);
            Vendors::where('id','=',$product->userId)->update(['deal_categories'=>implode(',',$categories)]);
        }
        $cuisines  = explode(',',$vendor->deal_cuisines);
        if(!in_array($product->cuisines,$cuisines)){
            array_push($cuisines,$product->cuisines);
            Vendors::where('id','=',$product->userId)->update(['deal_cuisines'=>implode(',',$cuisines)]);
        }
        //return $product;
        $vendor=Vendors::find($product->userId);

        $vendor->notify(new ProductReviewNotification($product->id,\Auth::guard('admin')->user()->name,"$product->product_name product approved by admin.")); //With new post
        return true;
        return redirect()->route('admin.vendor.pendigProduct')->with('message', 'Product Accept Successfully');
    }
    public function active($id){
        $id   = decrypt($id);
        $user = Product_master::find($id);
        Product_master::where('id','=', $user->id)->limit(1)->update( ['status' => 1 ,'product_approve' => 1]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Product Active Successfully' ], 200);
    }
    public function reject($id){
        $id   = decrypt($id);
        $user = Product_master::find($id);
        Product_master::where('id','=', $user->id)->limit(1)->update( ['status' => 3 ,'product_approve' => 3]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Product Reject Successfully' ], 200);
    }
}
