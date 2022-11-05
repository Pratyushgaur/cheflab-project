<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catogory_master;
use App\Models\Chef_video;
use App\Models\Cuisines;
use App\Models\Order_time;
use App\Models\Product_master;
use App\Models\User;
use App\Models\Variant;
use App\Models\Vendors;
use App\Models\Deliver_boy;
use App\Models\AdminMasters;
use App\Models\Orders;
use App\Rules\VendorOrderTimeRule;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserControllers extends Controller
{

    public function index(Request $request)
    {
        $v = Vendors::select('*');
        if ($request->rolename != '')
            $v->where('vendor_type', '=', $request->rolename);

        if ($request->search != ''){
            $search = $request->search;
            $v->where(function ($q) use ($search) {
                $q->where('vendor_type', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $vendors = $v->paginate(15);
        $wordlist = Vendors::where('vendor_type', '=','restaurant')->get();
        $restaurant = $wordlist->count();
        $re_avtive = Vendors::where('vendor_type', '=','restaurant')->where('status', '=','1')->get();
        $active_resto = $re_avtive->count();
        $delivery = Deliver_boy::all();
        $delivery_boy = $delivery->count();
        $chef = Vendors::where('vendor_type', '=','chef')->get();
        $chef = $chef->count();
        //Orders::where('vendor_id','=', $vendors->id)->where('order_status','=',)select('order_status')->get();
        return view('admin/vendors/list', compact('vendors','restaurant','active_resto','delivery_boy','chef'));
    }

    public function create_restourant()
    {
        $categories = Catogory_master::where('is_active', '=', '1')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->get();
        return view('admin/vendors/restourant_create', compact('categories', 'cuisines'));
    }

    public function create_chef()
    {
        $categories = Catogory_master::where('is_active', '=', '1')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->get();
        return view('admin/vendors/chef_create', compact('cuisines', 'categories'));
    }

    public function get_data_table_of_vendor(Request $request)
    {
        if ($request->ajax()) {

            $data = Vendors::latest()->get();
            if ($request->rolename != '') {
                $data = $data->where('vendor_type', '=', $request->rolename);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                                        
                                        <a class="dropdown-item text-info" href="' . route('admin.vendor.view', Crypt::encryptString($data->id)) . '"><i class="fa fa-eye"></i> View More</a>
                                        <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Vendor" flash="City"  data-action-url="' . route('admin.vendors.ajax.delete') . '" title="Delete" >Delete</a> ';
                    if($data->vendor_type == 'restaurant'){
                        $btn .= '<a class="dropdown-item text-info" href="' . route('admin.chef.edit', Crypt::encryptString($data->id)) . '"><i class="fas fa-edit"></i> Edit</a>';
                    }elseif($data->vendor_type == 'chef'){
                        $btn .= '<a class="dropdown-item text-info" href="' . route('admin.chef.editchef', Crypt::encryptString($data->id)) . '"><i class="fas fa-edit"></i> Edit Chef</a><a class="dropdown-item text-danger" href="' . route('admin.chefproduct.view', Crypt::encryptString($data->id)) . '"><i class="fa-solid fa-bowl-food"></i>Add/View  Product</a>';
                    }                    
                   


                    $btn .= '</div>
                                </li>
                            </ul>';
                    //$btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a><a href="'.route('admin.vendor.product.create',Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs"    title="Add Product" >Add Product</a> ';
                    return $btn;
                })
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->addColumn('status', function ($data) {
                    return $status_class = (!empty($data->status)) && ($data->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>';
                    return '<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">';
                })
                ->addColumn('image', function ($data) {
                    return "<img src=" . asset('vendors') . '/' . $data->image . "  style='width: 50px;' />";
                })
                ->rawColumns([ 'date', 'action-js', 'status', 'image' ])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }

    public function checkEmailExist(Request $request)
    {
        if (Vendors::where('email', '=', $request->email)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }

    public function checkEmailExistUpdate(Request $request, $id)
    {
        $email = Vendors::where('email', '=', $request->email);
        $email = $email->where('id', '!=', $id);
        if ($email->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }

    public function checkMobileExist(Request $request, $id = null)
    {
        if (Vendors::where('mobile', '=', $request->phone)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }

    public function checkMobileExistUpdate(Request $request, $id)
    {
        $mobile = Vendors::where('mobile', '=', $request->phone);
        $mobile = $mobile->where('id', '!=', $id);
        if ($mobile->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }

    public function store_restourant(Request $request)
    {
        $this->validate($request, [
            'restaurant_name'   => 'required',
            'email'             => 'required|unique:vendors,email',
            'pincode'           => 'required',
            'phone'             => 'required|unique:vendors,mobile',
            'address'           => 'required',
            'fssai_lic_no'      => 'required',
            'password'          => 'required',
            'confirm_password'  => 'required',
            'vendor_commission' => 'required',
            'categories'        => 'required',
            'deal_cuisines'     => 'required',
            'tax'               => 'required',
            'pancard_number'   => 'required',
            'pancard_image'   => 'required',
            'aadhar_number'   => 'required',
            'aadhar_card_image'   => 'required',
        ]);
        $vendors                   = new Vendors;
        $vendors->name             = $request->restaurant_name;
        $vendors->email            = $request->email;
        $vendors->password         = Hash::make($request->password);
        $vendors->vendor_type      = 'restaurant';
        $vendors->mobile           = $request->phone;
        $vendors->pincode          = $request->pincode;
        $vendors->address          = $request->address;
        $vendors->fssai_lic_no     = $request->fssai_lic_no;
        $vendors->commission       = $request->vendor_commission;
        $vendors->vendor_food_type = $request->type;
        $vendors->tax              = $request->tax;
        $vendors->pancard_number = $request->pancard_number;
        $vendors->aadhar_number = $request->aadhar_number;
        $vendors->gst_available    = $request->gst_available;
        $vendors->gst_no           = $request->gst_no;
        $vendors->deal_categories  = implode(',', $request->categories);
        $vendors->deal_cuisines    = implode(',', $request->deal_cuisines);

        if ($request->has('image')) {
            $filename = time() . '-profile-' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->move(public_path('vendors'), $filename);
            $vendors->image = $filename;
        } else {
            //$vendors->image  = 'default_restourant_image.jpg';
        }
        if ($request->has('fassai_image')) {
            $filename = time() . '-document-' . rand(100, 999) . '.' . $request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'), $filename);
            $vendors->licence_image = $filename;
        }
        if ($request->has('pancard_image')) {
            $filename = time() . '-pancard_image-' . rand(100, 999) . '.' . $request->pancard_image->extension();
            $request->pancard_image->move(public_path('pancard'), $filename);
            $vendors->pancard_image = $filename;
        }
        if ($request->has('aadhar_card_image')) {
            $filename = time() . '-addar-' . rand(100, 999) . '.' . $request->aadhar_card_image->extension();
            $request->aadhar_card_image->move(public_path('aadhar'), $filename);
            $vendors->aadhar_card_image = $filename;
        }
        if ($request->has('other_document')) {
            $filename = time() . '-other-document-' . rand(100, 999) . '.' . $request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'), $filename);
            $vendors->other_document_image = $filename;
            $vendors->other_document       = $request->other_document_name;
        }
        if ($request->has('banner_image')) {
            $filename = time() . '-banner-' . rand(100, 999) . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('vendor-banner'), $filename);
            $files[]               = $filename;
            $vendors->banner_image = json_encode($files);
        }
        $vendors->save();
        return redirect()->route('admin.restourant.create')->with('message', 'Vendor Registration Successfully');


    }

    public function store_chef(Request $request)
    {

        $this->validate($request, [
            'restourant_name'   => 'required',
            'email'             => 'required|unique:vendors,email',
            'pincode'           => 'required',
            'phone'             => 'required|unique:vendors,mobile',
            'experience'        => 'required',
            'dob'               => 'required',
            'deal_categories'   => 'required',
            'deal_cuisines'     => 'required',
            'address'           => 'required',
            'password'          => 'required',
            'confirm_password'  => 'required',
            'vendor_commission' => 'required',
            'start_time.*'      => 'nullable|date_format:H:i',
            'end_time.*'        => 'nullable|date_format:H:i',
            'available.*'       => [ 'nullable', 'between:0,1', new VendorOrderTimeRule($request) ],
            'lat'               => 'required',
            'long'              => 'required',
        ]);
        $vendors                      = new Vendors;
        $vendors->name                = $request->restourant_name;
        $vendors->email               = $request->email;
        $vendors->dob                 = $request->dob;
        $vendors->experience          = $request->experience;
        $vendors->deal_categories     = implode(',', $request->deal_categories);
        $vendors->deal_cuisines       = implode(',', $request->deal_cuisines);
        $vendors->password            = Hash::make($request->password);
        $vendors->vendor_type         = 'chef';
        $vendors->mobile              = $request->phone;
        $vendors->speciality          = implode(',', $request->speciality);
        $vendors->pincode             = $request->pincode;
        $vendors->address             = $request->address;
        $vendors->bio                 = $request->bio;
        $vendors->is_all_setting_done = 1;
        $vendors->lat                 = $request->lat;
        $vendors->long                = $request->long;
        if ($request->has('image')) {
            $filename = time() . '-profile-' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->move(public_path('vendors'), $filename);
            // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $vendors->image = $filename;
        }/*else{
            $vendors->image  = 'default_chef_image.jpg';
        }*/
        if ($request->has('fassai_image')) {
            $filename = time() . '-document-' . rand(100, 999) . '.' . $request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'), $filename);
            $vendors->licence_image = $filename;
        }
        if ($request->has('other_document')) {
            $filename = time() . '-other-document-' . rand(100, 999) . '.' . $request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'), $filename);
            $vendors->other_document_image = $filename;
            $vendors->other_document       = $request->other_document_name;
        }

        $vendors->save();
        //
        foreach ($request->start_time as $key => $val) {
            if ($request->available[$key] == 1)
                $data[] = [
                    'vendor_id'  => $vendors->id,
                    'day_no'     => $key,
                    'start_time' => $request->start_time[$key],
                    'end_time'   => $request->end_time[$key],
                    'available'  => $request->available[$key],
                ];
            else
                $data[] = [
                    'vendor_id'  => $vendors->id,
                    'day_no'     => $key,
                    'start_time' => null,
                    'end_time'   => null,
                    'available'  => 0,
                ];
        }
        Order_time::insert($data);


        return redirect()->route('admin.chef.create')->with('message', 'Vendor Registration Successfully');


    }

    public function vendors_update(Request $request)
    {
//        return $request->input();die;
        $this->validate($request, [
            'restaurant_name'   => 'required',
            'email'             => 'required',
            'pincode'           => 'required',
            'phone'             => 'required',
            'address'           => 'required',
            'fssai_lic_no'      => 'required',
            'vendor_commission' => 'required',
            //    'categories' => 'required',
            //  'deal_cuisines' => 'required',
            'tax'               => 'required',
        ]);
        $vendors = Vendors::find($request->id);
        //  dd($vendors);
        $vendors->name             = $request->restaurant_name;
        $vendors->email            = $request->email;
        $vendors->vendor_type      = 'restaurant';
        $vendors->mobile           = $request->phone;
        $vendors->pincode          = $request->pincode;
        $vendors->address          = $request->address;
        $vendors->fssai_lic_no     = $request->fssai_lic_no;
        $vendors->commission       = $request->vendor_commission;
        $vendors->vendor_food_type = $request->type;
        $vendors->tax              = $request->tax;
        $vendors->gst_available    = $request->gst_available;
        $vendors->gst_no           = $request->gst_no;
        $vendors->deal_categories  = implode(',', $request->categories);
        $vendors->deal_cuisines    = implode(',', $request->deal_cuisines);
        if ($request->has('image')) {
            $filename = time() . '-profile-' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->move(public_path('vendors'), $filename);
            // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $vendors->image = $filename;
        } else {
            if (!file_exists(public_path('vendors') . '/' . $vendors->image))
                $vendors->image = 'default_restourant_image.jpg';
        }
        if ($request->has('fassai_image')) {
            $filename = time() . '-document-' . rand(100, 999) . '.' . $request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'), $filename);
            $vendors->licence_image = $filename;
        }
        if ($request->has('other_document')) {
            $filename = time() . '-other-document-' . rand(100, 999) . '.' . $request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'), $filename);
            $vendors->other_document_image = $filename;
            $vendors->other_document       = $request->other_document_name;
        }
        if ($request->has('banner_image')) {
            $filename = time() . '-banner-' . rand(100, 999) . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('vendor-banner'), $filename);
            $vendors->banner_image = $filename;
        }
        $vendors->save();
        return redirect()->route('admin.vendors.list')->with('message', 'Vendor Details Update  Successfully');

    }
    public function chef_update(Request $request)
    {
//        return $request->input();die;
        $this->validate($request, [
            'restaurant_name'   => 'required',
            'email'             => 'required',
            'pincode'           => 'required',
            'phone'             => 'required',
            'address'           => 'required',
            'fssai_lic_no'      => 'required',
            'vendor_commission' => 'required',
            //    'categories' => 'required',
            //  'deal_cuisines' => 'required',
        ]);
        $vendors = Vendors::find($request->id);
        //  dd($vendors);
        $vendors->name             = $request->restaurant_name;
        $vendors->email            = $request->email;
        $vendors->vendor_type      = 'chef';
        $vendors->mobile           = $request->phone;
        $vendors->pincode          = $request->pincode;
        $vendors->address          = $request->address;
        $vendors->fssai_lic_no     = $request->fssai_lic_no;
        $vendors->commission       = $request->vendor_commission;
        $vendors->deal_categories  = implode(',', $request->categories);
        $vendors->deal_cuisines    = implode(',', $request->deal_cuisines);
        $vendors->speciality    = implode(',', $request->speciality);
        if ($request->has('image')) {
            $filename = time() . '-profile-' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->move(public_path('vendors'), $filename);
            // $filePath = $request->file('image')->storeAs('public/vendor_image',$filename);
            $vendors->image = $filename;
        } else {
            if (!file_exists(public_path('vendors') . '/' . $vendors->image))
                $vendors->image = 'default_restourant_image.jpg';
        }
        if ($request->has('fassai_image')) {
            $filename = time() . '-document-' . rand(100, 999) . '.' . $request->fassai_image->extension();
            $request->fassai_image->move(public_path('vendor-documents'), $filename);
            $vendors->licence_image = $filename;
        }
        if ($request->has('other_document')) {
            $filename = time() . '-other-document-' . rand(100, 999) . '.' . $request->other_document->extension();
            $request->other_document->move(public_path('vendor-documents'), $filename);
            $vendors->other_document_image = $filename;
            $vendors->other_document       = $request->other_document_name;
        }
        if ($request->has('banner_image')) {
            $filename = time() . '-banner-' . rand(100, 999) . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('vendor-banner'), $filename);
            $vendors->banner_image = $filename;
        }
        $vendors->save();
        return redirect()->route('admin.vendors.list')->with('message', 'Chef Details Update  Successfully');

    }
    public function addVideo(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'sub_title' => 'required',
            'link'      => 'required',
        ]);
        $vendors            = new Chef_video;
        $vendors->title     = $request->title;
        $vendors->userId    = $request->userId;
        $vendors->sub_title = $request->sub_title;
        $vendors->link      = $request->link;
        $vendors->save();
        $vendor = Vendors::findOrFail($request->userId);
        return redirect()->route('admin.vendor.view', Crypt::encryptString($vendor->id))->with('message', 'Video Add Successfully');
    }

    public function updateVideo(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'sub_title' => 'required',
            'link'      => 'required',
        ]);
        $vendors            = Chef_video::find($request->id);
        $vendors->title     = $request->title;
        $vendors->id        = $request->id;
        $vendors->userId    = $request->userId;
        $vendors->sub_title = $request->sub_title;
        $vendors->link      = $request->link;
        $vendors->save();
        $vendor = Vendors::findOrFail($request->userId);
        return redirect()->route('admin.vendor.view', Crypt::encryptString($vendor->id))->with('message', 'Vide Update Successfully');
    }

    public function view_vendor($encrypt_id)
    {
        $id         = Crypt::decryptString($encrypt_id);
        $vendor     = Vendors::findOrFail($id);
        $vendorLike = \App\Models\UserVendorLike::wherevendor_id($id)->count();
        $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        return view('admin/vendors/view-vendor', compact('vendor', 'categories', 'cuisines', 'vendorLike'));
    }

    public function chef_product_list(Request $request, $userId)
    {
        $user = $request->userId;
        // dd($user);
        if ($request->ajax()) {
            $data = Product_master::where('userId', $user)->select('id', 'product_name', 'product_image', 'product_price', 'type', 'created_at')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<a href="' . route("admin.chef.productedit", Crypt::encryptString($data->id)) . '" class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.product.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns([ 'date' ])
                ->rawColumns([ 'action-js' ]) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }

    public function product_list(Request $request, $id)
    {
        $user = $request->id;
        //    dd($user);
        if ($request->ajax()) {
            $data = Product_master::where('userId', $user)->select('id', 'product_name', 'product_image', 'product_price', 'type', 'created_at','status')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<a href="' . route("admin.chef.productedit", Crypt::encryptString($data->id)) . '" class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                            <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                ->addColumn('product_image', function ($data) {
                    return "<img src=" . asset('products') . '/' . $data->product_image . "  style='width: 50px;' />";
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $data->comment_reason . '" class="btn btn-success btn-xs inactive-record"  data-alert-message="Are You Sure to Inactive this Vendor" flash="Inactive" data-action-url="">Active</a>';
                    } elseif ($data->status == 2) {
                        $btn = '<span class="badge badge-primary">Pending</span>';
                    } elseif ($data->status == 0) {
                        $btn = '<a href="javascript:void(0)" data-id="' . $data->comment_reason . '" class="btn btn-danger btn-xs inactive-record"  data-alert-message="Are You Sure to Inactive this Vendor" flash="Inactive" data-action-url="">Active</a>';
                    } else {
                        $btn = '<a href="javascript:void(0)" class="openModal"  data-id="' . $data->comment_reason . '"><span class="badge badge-primary" data-toggle="modal" data-target="#modal-8">Reject</span></a>';
                    }
                    return $btn;
                  /*  $btn = '<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-success btn-xs inactive-record" data-alert-message="Are You Sure to Inactive this Vendor" flash="Inactive"  data-action-url="" title="Delete" >Active</a> 
                            <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="" title="Delete" >Inactive</a> ';
                    return $btn;*/
                })
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns([ 'date','status' ])
                ->rawColumns([ 'action-js', 'product_image','status' ]) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function order_list(Request $request, $id){
        $vendor_id = $request->id;
        //    dd($user);
        if ($request->ajax()) {
            $data = Orders::where('vendor_id', $vendor_id)->select('id', 'customer_name', 'delivery_address', 'order_status', 'total_amount', 'created_at')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.product.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
               
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns([ 'date' ])
                ->rawColumns([ 'action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    public function chef_videolist(Request $request, $id)
    {
        $vendor_id = $request->id;  
        if ($request->ajax()) {
            $data = Chef_video::where('userId', '=', $vendor_id)->select('id', 'userId', 'title', 'sub_title', 'link', 'created_at')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<a href="' . route("admin.chef.videoedit", Crypt::encryptString($data->id)) . '" class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>

                            <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this City" flash="City"  data-action-url="' . route('admin.chef.video.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })
                ->rawColumns([ 'date' ])
                ->rawColumns([ 'action-js' ]) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }

    public function view_chefproduct($encrypt_id)
    {
        $id         = Crypt::decryptString($encrypt_id);
        $vendor     = Vendors::findOrFail($id);
        $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        return view('admin/vendors/chef_product', compact('vendor', 'categories', 'cuisines'));
    }

    public function chef_videoedit($encrypt_id)
    {
        try {
            $id    = Crypt::decryptString($encrypt_id);
            $video = Chef_video::findOrFail($id);
            return view('admin/vendors/edit-chef-video', compact('video'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }

    public function chef_edit($encrypt_id)
    {
        try {
            $id = Crypt::decryptString($encrypt_id);
            //  dd($id);die;
            $vendor = Vendors::findOrFail($id);
            // $vendor =  Vendors::where('vendors.id','=',$id)->join('categories', 'vendors.deal_categories', '=', 'categories.id')->join('cuisines', 'vendors.deal_cuisines', '=', 'cuisines.id')->select('vendors.*', 'categories.name as categoryName','cuisines.name as cuisinesName')->get()->first();
            //dd($vendor);die;
            $categories = @Catogory_master::where('is_active', '=', '1')->pluck('name', 'id')->toArray();;//->get();
            $cuisines = @Cuisines::where('is_active', '=', '1')->pluck('name', 'id')->toArray();          //->get();
            return view('admin/vendors/editvender', compact('vendor', 'categories', 'cuisines'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function chef_editchef($encrypt_id){
        try {
            $id = Crypt::decryptString($encrypt_id);
            //  dd($id);die;
            $vendor = Vendors::findOrFail($id);
            // $vendor =  Vendors::where('vendors.id','=',$id)->join('categories', 'vendors.deal_categories', '=', 'categories.id')->join('cuisines', 'vendors.deal_cuisines', '=', 'cuisines.id')->select('vendors.*', 'categories.name as categoryName','cuisines.name as cuisinesName')->get()->first();
            //dd($vendor);die;
            $categories = @Catogory_master::where('is_active', '=', '1')->pluck('name', 'id')->toArray();;//->get();
            $cuisines = @Cuisines::where('is_active', '=', '1')->pluck('name', 'id')->toArray();          //->get();
            return view('admin/vendors/editchef', compact('vendor', 'categories', 'cuisines'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function chef_product_edit($encrypt_id)
    {
        $id         = Crypt::decryptString($encrypt_id);
        $vendor     = Product_master::findOrFail($id);
        $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        return view('admin/vendors/edit-chef-product', compact('vendor', 'cuisines', 'categories'));
    }

    public function chef_product($encrypt_id)
    {
        // echo 'ok';die;
        $id         = Crypt::decryptString($encrypt_id);
        $vendor     = Vendors::findOrFail($id);
        $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        return view('admin/vendors/chef-create-prodect', compact('vendor', 'categories', 'cuisines'));
    }

    public function chef_videolink($encrypt_id)
    {
        $id         = Crypt::decryptString($encrypt_id);
        $vendor     = Vendors::findOrFail($id);
        $categories = Catogory_master::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        $cuisines   = Cuisines::where('is_active', '=', '1')->orderby('position', 'ASC')->select('id', 'name')->get();
        return view('admin/vendors/chef-video-link', compact('vendor', 'categories', 'cuisines'));
    }

    public function store_chef_product(Request $request)
    {
     //   echo 'ok';die;
  //   return $request->input();die;
        $this->validate($request, [
            'product_name'  => 'required',
            'dis'           => 'required',
            'product_price' => 'required',
            'product_image' => 'required',
        ]);
        $product  = new Product_master;
        $product->product_name  = $request->product_name;
        $product->userId        = $request->userId;
        $product->cuisines      = $request->cuisines;
        $product->category      = $request->category;
        $product->status           = '1';
        $product->dis           = $request->dis;
        $product->product_price = $request->product_price;
        $product->preparation_time = $request->preparation_time;
        $product->product_for   = 2;
        $product->type         = $request->type;
        $product->customizable = $request->customizable;

        if ($request->has('product_image')) {
            $filename = time() . '-cheflab-product-' . rand(100, 999) . '.' . $request->file('product_image')->clientExtension();
            $request->product_image->move(public_path('products'), $filename);
            $product->product_image = $filename;
        }

        $product->save();
        if ($request->custimization == 'true')
            foreach ($request->variant_name as $k => $v) {
                Variant::create(['product_id' => $product->id, 'variant_name' => $v, 'variant_price' => $request->price[$k]]);
        }
        return redirect()->route('admin.vendor.view', Crypt::encryptString($request->userId))->with('message', 'Cheflab Product  Registration Successfully');

    }

    public function soft_delete(Request $request)
    {
        try {
            $id   = Crypt::decryptString($request->id);
            $data = Vendors::findOrFail($id);
            if ($data) {
                $data->delete();
                return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Vendor Deleted Successfully' ], 200);
            } else {
                return \Response::json([ 'error' => true, 'success' => false, 'error_message' => 'Finding data error' ], 200);
            }
        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json([ 'error' => true, 'success' => false, 'error_message' => $e->getMessage() ], 200);
        }
    }

    public function soft_delete_video(Request $request)
    {
        try {
            $id   = Crypt::decryptString($request->id);
            $data = Chef_video::findOrFail($id);
            if ($data) {
                $data->delete();
                return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Video Link Deleted Successfully' ], 200);
            } else {
                return \Response::json([ 'error' => true, 'success' => false, 'error_message' => 'Finding data error' ], 200);
            }


        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json([ 'error' => true, 'success' => false, 'error_message' => $e->getMessage() ], 200);
        }
    }

    public function user_list()
    {
        $users = User::orderBy('id', 'desc')->paginate(15);
        return view('admin/vendors/user_list', compact('users'));
    }
    public function user_inactive($id){
        $id   = decrypt($id);
        $user = User::find($id);
        User::where('id','=', $user->id)->limit(1)->update( ['status' => 0]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'User Inactive Successfully' ], 200);
    }
    public function user_active($id){
        $id   = decrypt($id);
        $user = User::find($id);
        User::where('id','=', $user->id)->limit(1)->update( ['status' => 1]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'User Active Successfully' ], 200);
    }
    public function vendor_inactive($id){
        $id   = decrypt($id);
        $user = Vendors::find($id);
        Vendors::where('id','=', $user->id)->limit(1)->update( ['status' => 0]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Vendor Inactive Successfully' ], 200);
    }
    public function vendor_active($id){
        $id   = decrypt($id);
        $user = Vendors::find($id);
        Vendors::where('id','=', $user->id)->limit(1)->update( ['status' => 1]);
        return \Response::json([ 'error' => false, 'success' => true, 'message' => 'Vendor Active Successfully' ], 200);
        return redirect()->back()->with('message', 'User Active Successfully.');
    }
    public function user_delete($id)
    {
        $id   = decrypt($id);
        $user = User::find($id);
        if (!isset($user->id))
            return redirect()->back()->with('message', 'user does not exist.');
        $user->delete();
        return redirect()->back()->with('message', 'Successfully deleted.');
    }
    public function user_view($id){
        $id = decrypt($id);
        $user = User::find($id);
        $order    = Orders::where('user_id','=',$id)->select('customer_name','delivery_address','city','total_amount')->get();
       //  var_dump($user);die;
        return view('admin/vendors/user_view',compact('user','order'));
    }
    public function refer()
    {
        $user = User::all();
        return view('admin/vendors/refer',compact('user'));
    }
    public function referamount()
    {   
        $id ='1';
        $refer_amount = AdminMasters::find($id);
        return view('admin/vendors/referamount',compact('refer_amount'));
    }
    public function referamountUpdate(Request $request){
        $general = AdminMasters::find($request->id);
        $general->refer_amount = $request->refer_amount;
        $general->refer_earn_msg = $request->refer_earn_msg;
        $general->save();
        return redirect()->route('admin.globle.setting')->with('message', 'Refer Amount  Update Successfully');
    }
}
