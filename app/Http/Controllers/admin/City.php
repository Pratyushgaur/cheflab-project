<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City_master;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use DB;
class City extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
        $data= City_master::all();
        $class_name ='City';
        return view('admin/city/city',compact('class_name'));
       // return view('admin/city',compact('class_name'),['members'=>$data]);
    }

    /**
     * This are used to add city .
     *
     * @return \Illuminate\Http\Response
     */
    public function cityAction(Request $request)
    {
       $this->validate($request, [
            'city_name' => 'required'
        ]);
        
        // function used for add single array 
        $City_master = new City_master;

        $check_duplicate_city = City_master::where('city_name', $request->city_name);
        if(!empty($request->txtpkey)){
          $check_duplicate_city =  $check_duplicate_city->where('id','<>', Crypt::decryptString($request->txtpkey));
        }
        $check_duplicate_city = $check_duplicate_city->where('status','<>', 3)->get();
        if($check_duplicate_city->isNotEmpty()){
            return redirect()->route('city')->with('error', 'This city already added.');
        }else{
            if(!empty($request->txtpkey)){
                $msg = "updated";
                $txtpkey =  Crypt::decryptString($request->txtpkey);
                $data = City_master::where('id', $txtpkey)->get();
                if($data->isEmpty()){
                    return redirect()->route('city')->with('message', 'something went wrong');
                }else{
                    $City_master = City_master::find($txtpkey);
                    $City_master->updated_at   = date('Y-m-d h:i:s');
                }
            }else{
                $msg = "Added";
                $City_master->created_at   = date('Y-m-d h:i:s');
            }           
            $City_master->city_name   = $request->city_name;
            $City_master->save();

            // this statement are used for getting the last inserted id
           //  $City_master->id;   

            return redirect()->route('city')->with('message', 'City '. $msg);
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_data_table_of_city(Request $request)
    {
        if ($request->ajax()) {
            
            $data = City_master::where('status', '<>', 3)->select('city_name', 'id', 'created_at','status')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '<a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this City" flash="City"  data-action-url="' . route('admin.city.ajax.delete') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                //<a href="'. route("fun_edit_city",Crypt::encryptString($data->id)) .'" class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>  
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                
                ->rawColumns(['date'])
                ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }


    public function check_duplicate_city(Request $request ,$id=null)
    {
        if (City_master::where('city_name','=',$request->city_name)->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    public function check_edit_duplicate_city(Request $request,$id)
    {
        $city = City_master::where('city_name','=',$request->city_name);
        $city = $city->where('id','!=',$id);
        if ($city->exists()) {
            return \Response::json(false);
        } else {
            return \Response::json(true);
        }
    }
    

    public function fun_edit_city($encrypt_id)
    {
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $city_data = City_master::findOrFail($id);
           // dd($city_data);
            return view('admin/city/editcity',compact('city_data'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 

    }
    public function soft_delete(Request $request)
    {
        try {
            $id =  Crypt::decryptString($request->id);
            $data = City_master::findOrFail($id);
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

    public function update(Request $request){
        // return $request->input();die;
         $data = City_master::find($request->id);
         $data->city_name=$request->city_name;
         $data->save();
         $msg = "City Update";
         return redirect()->route('city')->with('message', 'City '. $msg);
     }

}
