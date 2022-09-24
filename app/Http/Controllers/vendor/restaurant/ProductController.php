<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Addons;
use App\Models\VendorMenus;
use App\Models\Product_master;
use App\Models\Variant;


use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;

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
        $addons =  Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->get();
        $menus =  VendorMenus::where('vendor_id', '=', Auth::guard('vendor')->user()->id)->get();
        return view('vendor.restaurant.products.create', compact('categories', 'cuisines', 'addons', 'menus'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'dis' => 'required',
            'item_price' => 'required|integer',
            'product_image' => 'required|mimes:jpeg,png,jpg|max:5120',
            'cuisines' => 'required',
            'category' => 'required',
            'menu_id' => 'required',
        ]);
        try {

            //dd($request->all());
            $product = new Product_master;
            $product->product_name = $request->product_name;
            $product->userId = Auth::guard('vendor')->user()->id;
            $product->cuisines = $request->cuisines;
            $product->category  = $request->category;
            $product->menu_id  = $request->menu_id;
            $product->dis  = $request->dis;
            $product->type  = $request->product_type;
            $product->product_price  = $request->item_price;
            $product->customizable  = $request->custimization;
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
                $product->product_image  = $filename;
            }
            $product->product_for = '3';
            $product->save();
            if ($request->custimization == 'true')
                foreach ($request->variant_name as $k => $v) {
                    Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
                }

            return redirect()->route('restaurant.product.list')->with('message', 'Congratulation Product is Created Wait for Admin Review.');
        } catch (\Exception $th) {
            return $th->getMessage();
        }
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
        $product = Product_master::find($id);
        $product->status = 0;
        $product->save();
       // $update = \DB::table('products') ->where('id', $id) ->limit(1) ->update( [ 'status' => 0 ]); 
       // return redirect()->route('admin.slotebook.list')->with('message', 'Slote Active Successfully');
       return \Response::json($product);
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
