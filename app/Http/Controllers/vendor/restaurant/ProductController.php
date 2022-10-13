<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Addons;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Product_master;
use App\Models\Superadmin;
use App\Models\Variant;
use App\Models\VendorMenus;
use App\Notifications\ProductCreatedNotification;
use Auth;
use Config;
use DataTables;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    function index()
    {
        return view('vendor.restaurant.products.list');
    }

    function addons()
    {
        return view('vendor.restaurant.addons.list');
    }

    public function create(Type $var = null)
    {
        $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $addons = Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->get();
        $menus = VendorMenus::where('vendor_id', '=', Auth::guard('vendor')->user()->id)->get();
        return view('vendor.restaurant.products.create', compact('categories', 'cuisines', 'addons', 'menus'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'dis' => 'required',
            'item_price' => 'required|integer',
          //  'product_image' => 'required',
            'cuisines' => 'required',
            'category' => 'required',
            'menu_id' => 'required',
            'primary_variant_name' => 'required',
        ]);
        try {

          //  dd($request->all());
            $product = new Product_master;
            $product->product_name = $request->product_name;
            $product->userId = Auth::guard('vendor')->user()->id;
            $product->cuisines = $request->cuisines;
            $product->category = $request->category;
            $product->chili_level = $request->chili_level;
            $product->menu_id = $request->menu_id;
            $product->dis = $request->dis;
            $product->type = $request->product_type;
            $product->primary_variant_name = $request->primary_variant_name;
            $product->product_price = $request->item_price;
            $product->customizable = $request->custimization;
            // if($request->custimization == 'true'){
            //     $data = [];
            //     foreach($request->variant_name as $k =>$v){
            //         $data[] = array('variant_name' =>$v ,'price' =>$request->price[$k]);
            //     }
            //     $product->variants = serialize($data);
            // }
            if (!empty($request->addons)) {
                $product->addons = implode(',', $request->addons);
            }
            if ($request->has('product_image')) {
                $filename = time() . '-restaurant-product-' . rand(100, 999) . '.' . $request->file('product_image')->clientExtension();
                $request->product_image->move(public_path('products'), $filename);
                $product->product_image = $filename;
            }
            $product->product_for = '3';
            $product->save();
            if ($request->custimization == 'true')
                foreach ($request->variant_name as $k => $v) {
                    Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
                }
            $subscribers = Superadmin::get();
            foreach ($subscribers as $k => $admin)
                $admin->notify(new ProductCreatedNotification($product->id,Auth::guard('vendor')->user()->name)); //With new post
//            Notification::route('database', $subscribers) //Sending  to subscribers
//            ->notify(new ProductCreatedNotification($product->id)); //With new post

            return redirect()->route('restaurant.product.list')->with('message', 'Congratulation Product is Created Wait for Admin Review.');
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
    public function update(Request $request){
      //  return $request->input();die;
        $this->validate($request, [
            'product_name' => 'required',
            'dis' => 'required',
            'item_price' => 'required',
            'cuisines' => 'required',
            'category' => 'required',
            'menu_id' => 'required',
        ]);

            //dd($request->all());
            $product = Product_master::find($request->id);
            $product->product_name = $request->product_name;
            $product->userId = Auth::guard('vendor')->user()->id;
            $product->cuisines = $request->cuisines;
            $product->category  = $request->category;
            $product->menu_id  = $request->menu_id;
            $product->dis  = $request->dis;
            $product->type  = $request->product_type;
            $product->product_price  = $request->item_price;
            $product->customizable  = $request->custimization;
            if($request->status == '0'){
                $product->status  = 2;
            }
            if (!empty($request->addons)) {
                $product->addons = implode(',', $request->addons);
            }

            if($request->has('product_image')){
                $filename = time().'-product_image-'.rand(100,999).'.'.$request->product_image->extension();
                $request->product_image->move(public_path('products'),$filename);
               // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
                $catogory->product_image  = $filename;
            }


            $product->product_for = '3';
            $product->save();
            if ($request->custimization == 'true')
                foreach ($request->variant_name as $k => $v) {
                    Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
                }

            return redirect()->route('restaurant.product.list')->with('message', 'Congratulation Product is Published.');

    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $data = Product_master::join('categories', 'products.category', '=', 'categories.id')->select('products.*', 'categories.name as categoryName')->where('products.userId', '=', Auth::guard('vendor')->user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    if ($data->status == '1') {
                        $btn = '<a href="#"><i class="fa fa-edit"></i></a> <a  href="#"><i class="fa fa-trash"></i></a>';
                    } elseif($data->status == '0'){
                       // $btn  ='<a href="'. route("vendor.product.edit",Crypt::encryptString($data->id)) .'" class="badge badge-danger">Reuse</a><a  href="#"><i class="fa fa-trash"></i></a>';
                       $btn  ='<a href="#" class="badge badge-danger">Reuse</a><a  href="#"><i class="fa fa-trash"></i></a>';
                    }else{
                        $btn = '<a href="#"><i class="fa fa-edit"></i></a> <a  href="#"><i class="fa fa-trash"></i></a>';
                    }
                    return $btn;

                })
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('product_name', function ($data) {
                    $btn = ' <img src="' . asset('products') . '/' . $data->product_image . '" data-pretty="prettyPhoto" style="width:50px; height:30px;" alt="Trolltunga, Norway"> <div id="myModal" class="modal">
                    <img class="modal-content" id="img01">
                  </div>' . $data->product_name . '';
                    return $btn;
                })
                ->addColumn('product_price', function ($data) {
                    $btn = '<i class="fas fa-rupee-sign fa-sm"></i>' . $data->product_price . '';
                    return $btn;
                })
                ->addColumn('admin_review', function($data){
                    //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'

                       if($data->status == 1){
                        $btn  ='<span class="badge badge-success">Active</span>';
                       }elseif($data->status == 2){
                        $btn = '<span class="badge badge-primary">Pending</span>';
                    } elseif ($data->status == 0) {
                        $btn = '<span class="badge badge-primary">Inactive</span>';
                       }else{
                        $btn = '<a href="javascript:void(0)" class="openModal"  data-id="'. $data->comment_reason .'"><span class="badge badge-primary" data-toggle="modal" data-target="#modal-8">Reject</span></a>';
                       }
                       return $btn;
                   })
                ->addColumn('product_approve', function ($data) {
                    if ($data->product_approve == 1) {
                        $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round offproduct" data-id="' . $data->id . '"></span></label>';
                    } elseif($data->product_approve == 0){
                        $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round onProduct" data-id="' . $data->id . '"></span></label>';
                    }else{
                        $btn = '<label class="ms-switch"><input type="checkbox" disabled> <span class="ms-switch-slider round"></span></label>';
                    }


                    return $btn;
                })
                ->rawColumns(['date','action-js','product_name','product_price','status','admin_review','product_approve'])
                ->rawColumns(['action-js','product_name','product_price','status','admin_review','product_approve']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function fun_edit_product($encrypt_id)
    {
        try {
            $id =  Crypt::decryptString($encrypt_id);
           // $product = Product_master::findOrFail($id);
            $product  =  Product_master::where('products.id','=',$id)->join('categories', 'products.category', '=', 'categories.id')->join('cuisines', 'products.userId', '=', 'cuisines.id')->join('vendor_menus', 'products.userId', '=', 'vendor_menus.id')->select('products.*', 'categories.name as categoryName','cuisines.name as cuisinesName','vendor_menus.menuName')->first();
            $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
            $cuisines = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
            $addons =  Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->get();
            $menus =  VendorMenus::where('vendor_id', '=', Auth::guard('vendor')->user()->id)->get();
            return view('vendor.restaurant.products.edit',compact('product','cuisines','addons','menus','categories'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function inActive(Request $request){
        $id = $request->id;
        $update = \DB::table('products')
        ->where('id', $id)
        ->update(['product_approve' => '0']);
       return \Response::json($update);
    }
    public function Active(Request $request){
        $id = $request->id;
        $update = \DB::table('products')
        ->where('id', $id)
        ->update(['product_approve' => '1']);
       return \Response::json($update);
    }
    public function getAddonData(Request $request)
    {
        $data = Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action-js', function ($data) {
                $btn = '<a href="#"><i class="fa fa-edit"></i></a>
                        <a  href="#"><i class="fa fa-trash"></i></a>
                ';
                return $btn;
            })
            ->addColumn('date', function ($data) {
                $date_with_format = date('d M Y', strtotime($data->created_at));
                return $date_with_format;
            })
            ->rawColumns(['date', 'action-js'])
            ->rawColumns(['action-js'])
            ->make(true);
    }

    public function createAddon()
    {

        return view('vendor.restaurant.addons.create');
    }

    public function storeAddon(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|integer'

        ]);
        $product = new Addons;
        Addons::insert([
            'addon' => $request->name,
            'price' => $request->price,
            'vendorId' => Auth::guard('vendor')->user()->id
        ]);

        return redirect()->route('restaurant.product.addon')->with('message', 'Addon Create Successfully.');
    }


}
