<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use DataTables;
use Config;


class MenuController extends Controller
{
    public function index()
    {
        return view('vendor.restaurant.menu.list');
    }
    public function create()
    {
        return view('vendor.restaurant.menu.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        $VendorMenus = new VendorMenus;
        $VendorMenus->menuName = $request->name;
        $VendorMenus->vendor_id = \Auth::guard('vendor')->user()->id;
        $VendorMenus->save();
        return redirect()->route('restaurant.menu.list')->with('success', 'Menu Created Successfully');
        
    }
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            
            $data = VendorMenus::latest()->get();
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
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
}
