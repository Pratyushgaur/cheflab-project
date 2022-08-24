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
        return view('admin/city',compact('class_name'));
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
                    $City_master->updated_by   = session()->get('*$%&%*id**$%#');
                    $City_master->updated_ip_address   = $request->ip();
                }
            }else{
                $msg = "Added";
                $City_master->created_at   = date('Y-m-d h:i:s');
                $City_master->created_by   = session()->get('*$%&%*id**$%#');
                $City_master->created_ip_address   = $request->ip();
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
                    $btn = '<a href="'. url("/edit-city") ."/". Crypt::encryptString($data->id).'" class="edit btn btn-warning btn-xs"><i class="fa fa-pencil"></i></a>  <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-danger btn-xs delete-record" flash="City" table="' . Crypt::encryptString('mangao_city_masters') . '" redirect-url="' . Crypt::encryptString('admin-dashboard') . '" title="Delete" ><i class="fa fa-trash"></i></a> ';
                    return $btn;
                })
                
                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y',strtotime($data->created_at));
                    return $date_with_format;
                })

                
                ->rawColumns(['date'])
                ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }

    }


    public function check_duplicate_city(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->txtpkey;
                if (!empty($id)) {
                    $id =   Crypt::decryptString($request->txtpkey);
                    $city_data = City_master::where('id','<>', $id)->where('city_name', $request->city_name)->where('status', '<>', 3)->get();
                } else {
                    $city_data = City_master::where('city_name', $request->city_name)->where('status', '<>', 3)->get();
                }
                
                if (!empty($city_data[0])) {
                    echo "false";
                } else {
                    echo "true";
                }
            } catch (DecryptException $e) {
                return redirect('city')->with('error', 'something went wrong');
            }
        }else{
            exit('No direct script access allowed');
        }

    }

    public function fun_edit_city($encrypt_id)
    {
        try {
            
            $id =  Crypt::decryptString($encrypt_id);
            $city_data = DB::table(Config::get('constants.MANGAO_CITY_MASTER').'  as MCM')->where('MCM.status', '<>', 3)->where('MCM.id', '=', $id)->select('MCM.city_name', 'MCM.id')->get();

            $city_data[0]->id = Crypt::encryptString($city_data[0]->id);
            $class_name ='Cn_master_city';
           
            if(!empty($city_data[0])){
                return view('admin/city-cityadmin/city_master',compact('class_name','city_data'));
            }else{
               return redirect('city')->with('error', 'something went wrong');
            }
        } catch (DecryptException $e) {
            return redirect('city')->with('error', 'something went wrong');
        }

    }

}
