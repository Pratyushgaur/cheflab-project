<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catogory_master;
use App\Models\Cuisines;
use App\Models\Addons;
use App\Models\VendorMenus;
use App\Models\Product_master;


use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;
class ProductController extends Controller
{
    function index(){
        return view('vendor.restaurant.products.list');
    }
    function addons(){
        return view('vendor.restaurant.addons.list');
    }
    public function create(Type $var = null)
    {
        $categories =Catogory_master::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        $cuisines = Cuisines::where('is_active','=','1')->orderby('position','ASC')->select('id','name')->get();
        $addons =  Addons::where('vendorId','=',Auth::guard('vendor')->user()->id)->get();
        $menus =  VendorMenus::where('vendor_id','=',Auth::guard('vendor')->user()->id)->get();
        return view('vendor.restaurant.products.create',compact('categories','cuisines','addons','menus'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'dis' => 'required',
            'item_price' => 'required|integer',
            'product_image' => 'required|mimes:jpeg,png,jpg|max:5120',
            'cuisines' =>'required',
            'category' =>'required',
            'menu_id' =>'required',
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
            if($request->custimization == 'true'){
                $data = [];
                foreach($request->variant_name as $k =>$v){
                    $data[] = array('varint_name' =>$v ,'price' =>$request->price[$k]);
                }
                $request->variants = serialize($data);
            }
            if(!empty($request->addons)){
                $request->variants = implode(',',$request->addons);
            }
            if($request->has('product_image')){
                $filename = time().'-restaurant-product-'.rand(100,999).'.'.$request->product_image->extension();
                $request->product_image->move(public_path('products'),$filename);
                $product->product_image  = $filename;
            }
            $product->save();
            return redirect()->route('restaurant.product.list')->with('message', 'Congratulation Product is Published.');
        } catch (\Exception $th) {
            return $th->getMessage();
        
        }
        
    }
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Product_master::join('categories','products.category','=','categories.id')->select('products.*','categories.name as categoryName')->where('products.userId','=',Auth::guard('vendor')->user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="#"><i class="fa fa-edit"></i></a>
                            <a  href="#"><i class="fa fa-trash"></i></a>
                    ';
                    return $btn;
                })
                ->addColumn('product_name', function($data){
                    $btn = '<img src="'.asset('products').'/'.$data->product_image.'" style="width:50px; height:30px;"> '.$data->product_name.'';
                    return $btn;
                })
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('product_price', function($data){
                    $btn = '<i class="fas fa-rupee-sign"></i>'.$data->product_price.'';
                    return $btn;
                })
                ->addColumn('status', function($data){
                    if ($data->status) {
                        $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round"></span></label>';
                    } else {
                        $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round"></span></label>';
                    }
                    
                    
                    return $btn;
                })
                ->rawColumns(['date','action-js','product_name','product_price','status'])
                ->rawColumns(['action-js','product_name','product_price','status'])
                ->make(true);
        }
    }

    public function getAddonData(Request $request)
    {
        $data = Addons::where('vendorId','=',Auth::guard('vendor')->user()->id)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action-js', function($data){
                $btn = '<a href="#"><i class="fa fa-edit"></i></a>
                        <a  href="#"><i class="fa fa-trash"></i></a>
                ';
                return $btn;
            })
            ->addColumn('date', function($data){
                $date_with_format = date('d M Y',strtotime($data->created_at));
                return $date_with_format;
            })
            ->rawColumns(['date','action-js'])
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
                'addon'=>$request->name,
                'price'=>$request->price,
                'vendorId'=>Auth::guard('vendor')->user()->id
            ]);
            
            return redirect()->route('restaurant.product.addon')->with('message', 'Addon Create Successfully.');
    }





    
}
