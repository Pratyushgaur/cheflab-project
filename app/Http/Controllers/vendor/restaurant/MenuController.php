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
            
            $data = VendorMenus::latest()->where('vendor_id','=',\Auth::guard('vendor')->user()->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("restaurant.menu.edit",Crypt::encryptString($data->id)) .'"><i class="fa fa-edit"></i></a>
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
    public function menu_edit($encrypt_id){
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $menu_data = VendorMenus::findOrFail($id);
           // dd($city_data);
            return view('vendor.restaurant.menu.editmenu',compact('menu_data'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
        
    }
    public function check_duplicate_menu(Request $request ,$id=null)
    {
        if (VendorMenus::where('menuName','=',$request->name)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function check_edit_duplicate_menu(Request $request,$id)
    {
        $menu = VendorMenus::where('menuName','=',$request->name);

        $menu = $menu->where('id','!=',$id);
        if ($menu->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required'
        ]);
        $VendorMenus = VendorMenus::find($request->id);
        $VendorMenus->menuName = $request->name;
        $VendorMenus->save();
        return redirect()->route('restaurant.menu.list')->with('success', 'Menu Update Successfully');
    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = VendorMenus::findOrFail($id);
            if ($data ) {
                $data->delete();
                return \Response::json(['error' => false,'success' => true , 'message' => 'City Deleted Successfully'], 200);
            }else{
                return \Response::json(['error' => true,'success' => false , 'error_message' => 'Finding data error'], 200);
            } 
            
            
            
        } catch (DecryptException $e) {
            //return redirect('city')->with('error', 'something went wrong');
            return \Response::json(['error' => true,'success' => false , 'error_message' => $e->getMessage()], 200);
        }
    }
}
