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
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;


class ProductController extends Controller
{
    function index(Request $request)
    {
        //$products = Product_master::join('categories', 'products.category', '=', 'categories.id')
        $products = Product_master::where('products.userId', '=', Auth::guard('vendor')->user()->id);

        $products->where(function ($q) use ($request) {

            if ($request->name != '')
                $q->orWhere('product_name', 'like', "%" . $request->name . "%");

            if ($request->price != '')
                $q->orWhere('product_price', '=', $request->price);

            if ($request->status != '')
                $q->orWhere('status', '=', $request->status);

            if ($request->approve != '')
                $q->orWhere('product_approve', '=', $request->approve);

            if ($request->category != '')
                $q->orWhere('category', '=', $request->category);

        });
        $products = $products->paginate(15);
//dd(\DB::getqueryLog());
//        dd($_GET);
        $request->session()->put('product_last_param', $_GET);
//        $request->session()->put('product_last_url', url()->full());
        $product_count=Product_master::where('userId',\Auth::guard('vendor')->user()->id)->count();
        $categories = Catogory_master::where('is_active', '=', '1')->whereIn('id', explode(',', \Auth::guard('vendor')->user()->deal_categories))->orderby('position', 'ASC')->pluck('name', 'id');

//dd($products);
        return view('vendor.restaurant.products.list', compact('products', 'categories','product_count'));
    }

    function addons()
    {
        return view('vendor.restaurant.addons.list');
    }

    public function create(Type $var = null)
    {
        $categories = Catogory_master::where('is_active', '=', '1')->whereIn('id', explode(',', \Auth::guard('vendor')->user()->deal_categories))->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->whereIn('id', explode(',', \Auth::guard('vendor')->user()->deal_cuisines))->orderby('position', 'ASC')->select('id', 'name')->get();
//        $addons     = Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->get();
        $addons = Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->select(\DB::raw('CONCAT(`addon`," - Rs ",`price`) as addon'), 'id')->pluck('addon', 'id');

        $menus = VendorMenus::where('vendor_id', '=', Auth::guard('vendor')->user()->id)->get();
        return view('vendor.restaurant.products.create', compact('categories', 'cuisines', 'addons', 'menus'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_name'         => 'required',
            //'dis'                  => 'required',
            'item_price'           => 'required|integer',
            //  'product_image' => 'required',
            //'cuisines'             => 'required',
            //'category'             => 'required',
            'menu_id'              => 'required',
            'primary_variant_name' => 'required',
        ]);
        try {

            if ($request->custimization == 'true') {
                if ($request->addons == '')
                    foreach ($request->variant_name as $k => $v)
                        if ($v == '' || $request->price[$k] == '')
                            return redirect()->back()->with('error', 'variant or addon, at least one of the filed must be required.');
            }

            //  dd($request->all());
            $product                       = new Product_master;
            $product->product_name         = $request->product_name;
            $product->userId               = Auth::guard('vendor')->user()->id;
            //$product->cuisines             = $request->cuisines;
            //$product->category             = $request->category;
            $product->chili_level          = $request->chili_level;
            $product->menu_id              = $request->menu_id;
            $product->dis                  = $request->dis;
            //$product->type                 = $request->product_type;
            $product->primary_variant_name = $request->primary_variant_name;
            $product->product_price        = $request->item_price;
            $product->customizable         = $request->custimization;
            $product->preparation_time     = $request->preparation_time;
            if (isset($request->product_type))
                $product->type = $request->product_type;

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
            Variant::create(['product_id' => $product->id, 'variant_name' => $request->primary_variant_name, 'variant_price' => $request->item_price]);
            if ($request->custimization == 'true')
                foreach ($request->variant_name as $k => $v) {
                    if ($v != '' && $request->price[$k] != '')
                        Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
                }
            $subscribers = Superadmin::get();
            foreach ($subscribers as $k => $admin)
                $admin->notify(new ProductCreatedNotification($product->id, Auth::guard('vendor')->user()->name)); //With new post
//            Notification::route('database', $subscribers) //Sending  to subscribers
//            ->notify(new ProductCreatedNotification($product->id)); //With new post

            return redirect()->route('restaurant.product.list')->with('success', 'Congratulation Product is Created Wait for Admin Review.');
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'product_name'     => 'required',
            //'dis'              => 'required',
            'item_price'       => 'required',
            //'cuisines'         => 'required',
            //'category'         => 'required',
            'menu_id'          => 'required',
            'preparation_time' => 'required',
        ]);
//dd($request->all());
        if ($request->custimization == 'true') {
            if ($request->addons == '')
                foreach ($request->variant_name as $k => $v)
                    if ($v == '' || $request->price[$k] == '')
                        return redirect()->back()->with('error', 'variant or addon, at least one of the filed must be required.');
        }

        $product                       = Product_master::find($request->id);
        $product->product_name         = $request->product_name;
        $product->userId               = Auth::guard('vendor')->user()->id;
       // $product->cuisines             = $request->cuisines;
        //$product->category             = $request->category;
        $product->menu_id              = $request->menu_id;
        $product->dis                  = $request->dis;
   //     $product->type                 = $request->product_type;
        $product->product_price        = $request->item_price;
        $product->customizable         = $request->custimization;
        $product->preparation_time     = $request->preparation_time;
        $product->chili_level          = $request->chili_level;
        $product->primary_variant_name = $request->primary_variant_name;
        $product->product_approve      = 2;


        if (isset($request->product_type))
            $product->type = $request->product_type;
            $product->addons = @implode(',', @$request->addons);
        if ($request->has('product_image')) {
            $old_image = public_path('products/') . $product->product_image;
            $filename  = time() . '-product_image-' . rand(100, 999) . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('products'), $filename);
            // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $product->product_image = $filename;

            @unlink($old_image);
        }
        $product->product_for = '3';

        $product->save();
        if ($request->custimization == 'true') {
            $save  = [];
            $count = 0;
//           
            $primary = Variant::where('product_id','=',$product->id)->orderBy('id','ASC')->limit(1)->select('id')->first();
            Variant::where('id','=',$primary->id)->update(['variant_name' => $request->primary_variant_name, 'variant_price' => $request->item_price]);
            $ids[] = $primary->id;
            if (isset($request->variant_name) && count($request->variant_name) > 0) {
                foreach ($request->variant_name as $k => $v) {
                    $save[$count] = ['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]];
                    if (isset($request->variant_id[$k])) {
//                        dd($request->variant_id[$k]);
                        Variant::where('id', $request->variant_id[$k])->update($save[$count]);
                        $ids[] = (int)$request->variant_id[$k];
//                        print_r($save[$count]);
                    } else {
                        $vari  = Variant::create($save[$count]);
                        $ids[] = (int)$vari->id;
//                        print_r($vari);
                    }
                    $count++;
                }
                \DB::enableQueryLog();
//dd($ids);
                $ids = Variant::where('product_id', $product->id)->whereNotIn('id', array_values($ids))->delete();
//                dd(\DB::getQueryLog ());

            }
        }
//dd($product);

        $product_last_url=$request->session()->get('product_last_param');
        if($product_last_url!='')
            return redirect()->route('restaurant.product.list',$product_last_url)->with('success', 'Congratulation Product is Published.');
//        return redirect()->back()->with('success', 'Congratulation Product is Published.');
        return redirect()->route('restaurant.product.list')->with('success', 'Congratulation Product is Published.');

    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $data = Product_master::join('categories', 'products.category', '=', 'categories.id')
                ->select('products.*', 'categories.name as categoryName')
                ->where('products.userId', '=', Auth::guard('vendor')->user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    if ($data->status == '1') {
                        $btn = '<a href="' . route('vendor.product.edit', ['id' => Crypt::encryptString($data->id)]) . '"><i class="fa fa-edit"></i></a> <a  href="#"><i class="fa fa-trash"></i></a>';
                    } elseif ($data->status == '0') {
                        // $btn  ='<a href="'. route("vendor.product.edit",Crypt::encryptString($data->id)) .'" class="badge badge-danger">Reuse</a><a  href="#"><i class="fa fa-trash"></i></a>';
                        $btn = '<a href="#" class="badge badge-danger">Reuse</a><a  href="#"><i class="fa fa-trash"></i></a>';
                    } else {
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
                ->addColumn('admin_review', function ($data) {
                    //   return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'

                    if ($data->status == 1) {
                        $btn = '<span class="badge badge-success">Active</span>';
                    } elseif ($data->status == 2) {
                        $btn = '<span class="badge badge-primary">Pending</span>';
                    } elseif ($data->status == 0) {
                        $btn = '<span class="badge badge-primary">Inactive</span>';
                    } else {
                        $btn = '<a href="javascript:void(0)" class="openModal"  data-id="' . $data->comment_reason . '"><span class="badge badge-primary" data-toggle="modal" data-target="#modal-8">Reject</span></a>';
                    }
                    return $btn;
                })
                ->addColumn('product_approve', function ($data) {
                    if ($data->product_approve == 1) {
                        $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round offproduct" data-id="' . $data->id . '"></span></label>';
                    } elseif ($data->product_approve == 0) {
                        $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round onProduct" data-id="' . $data->id . '"></span></label>';
                    } else {
                        $btn = '<label class="ms-switch"><input type="checkbox" disabled> <span class="ms-switch-slider round"></span></label>';
                    }


                    return $btn;
                })
                ->rawColumns(['date', 'action-js', 'product_name', 'product_price', 'status', 'admin_review', 'product_approve'])
                ->rawColumns(['action-js', 'product_name', 'product_price', 'status', 'admin_review', 'product_approve']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }

    public function fun_edit_product($encrypt_id)
    {
        try {

            $id = Crypt::decryptString($encrypt_id);
//            dd($id);
            // $product = Product_master::findOrFail($id);
            $product = Product_master::where('products.id', '=', $id)->with('product_variants')
//                ->leftJoin('categories', 'products.category', '=', 'categories.id')
//                ->leftJoin('cuisines', 'products.userId', '=', 'cuisines.id')
//                ->join('vendor_menus', 'products.userId', '=', 'vendor_menus.id')
//                ->select('products.*', 'categories.name as categoryName', 'cuisines.name as cuisinesName', 'vendor_menus.menuName')
                ->first();
//            dd($product);
//            $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->pluck('name', 'id');
//            $cuisines   = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->pluck('name', 'id');
            $categories = Catogory_master::where('is_active', '=', '1')->whereIn('id', explode(',', \Auth::guard('vendor')->user()->deal_categories))->orderby('position', 'ASC')->pluck('name', 'id');//->select('id', 'name')->get();
            $cuisines   = Cuisines::where('is_active', '=', '1')->whereIn('id', explode(',', \Auth::guard('vendor')->user()->deal_cuisines))->orderby('position', 'ASC')->pluck('name', 'id');//->select('id', 'name')->get();

//            $addons     = Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->get();
            $addons = Addons::where('vendorId', '=', Auth::guard('vendor')->user()->id)->select(\DB::raw('CONCAT(`addon`," - Rs ",`price`) as addon'), 'id')->pluck('addon', 'id');
//            $menus      = VendorMenus::where('vendor_id', '=', Auth::guard('vendor')->user()->id)->get();
            $menus = VendorMenus::where('vendor_id', '=', Auth::guard('vendor')->user()->id)->pluck('menuName', 'id')->toArray();
//            dd($menus);
            return view('vendor.restaurant.products.edit', compact('product', 'cuisines', 'addons', 'menus', 'categories'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }

    public function inActive(Request $request)
    {
        $id     = $request->id;
        $update = \DB::table('products')
            ->where('id', $id)
            ->update(['product_approve' => '0']);
        return \Response::json($update);
    }

    public function Active(Request $request)
    {
        $id     = $request->id;
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
                $btn = '<a href="'. route("restaurant.product.addon.edit",Crypt::encryptString($data->id)) .'"><i class="fa fa-edit"></i></a>
                        <a  href="'. route("restaurant.product.addon.delete",Crypt::encryptString($data->id)) .'"
                        onclick="return confirm('."'Are you sure!You wnt to delete this addon?'".')"><i class="fa fa-trash"></i></a>';
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
    public function updateAddon(Request $request){
        $this->validate($request, [
            'name'  => 'required',
            'price' => 'required|integer'

        ]);
        $catogory = Addons::find($request->id);
        $catogory->addon = $request->name;
        $catogory->price = $request->price;
        $catogory->save();
        return redirect()->route('restaurant.product.addon')->with('success', 'Addon Update Successfully.');
    }
    public function editAddon($encrypt_id){
        try {

            $id = Crypt::decryptString($encrypt_id);
//            dd($id);
            // $product = Product_master::findOrFail($id);
            $addons    = Addons::findOrFail($id);
//            dd($menus);
            return view('vendor.restaurant.addons.edit', compact('addons'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function createAddon()
    {

        return view('vendor.restaurant.addons.create');
    }

    public function storeAddon(Request $request)
    {

        $this->validate($request, [
            'name'  => 'required',
            'price' => 'required|integer'

        ]);
        $product = new Addons;
        Addons::insert([
            'addon'    => $request->name,
            'price'    => $request->price,
            'vendorId' => Auth::guard('vendor')->user()->id
        ]);

        return redirect()->route('restaurant.product.addon')->with('success', 'Addon Create Successfully.');
    }

    public function delete(Request $request)
    {
        try {
            $id   = Crypt::decryptString($request->id);
            $data = Product_master::findOrFail($id);
            if ($data) {
                $data->delete();
                return redirect()->route('restaurant.product.list')->with('success', 'Product deleted successfully.');
            } else {

                return redirect()->route('restaurant.product.list')->with('error', 'Something went wrong.');
            }


        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return redirect()->route('restaurant.product.list')->with('error', 'Something wen wrong.');
        }
    }


    public function delete_addon(Request $request)
    {
        try {
            $id   = Crypt::decryptString($request->id);
            $data = Addons::findOrFail($id);
            if ($data) {
                $data->delete();
                return redirect()->route('restaurant.product.addon')->with('success', 'Addon deleted successfully.');
            } else {

                return redirect()->route('restaurant.product.addon')->with('error', 'Something went wrong.');
            }


        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return redirect()->route('restaurant.product.list')->with('error', 'Something wen wrong.');
        }
    }

}
