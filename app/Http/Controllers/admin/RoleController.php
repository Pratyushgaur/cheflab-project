<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;


class RoleController extends Controller
{
    function  index(Request $request) {
        return view('admin.role.list');
    }
    function  create(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:roles,role_name'
        ]);
        $roles = new \App\Models\Roles;
        $roles->role_name = $request->name;
        $roles->save();
        return redirect()->back()->with('message', 'Role Create Successfully');

    }
    public function get_data_table_of_role(Request $request)
    {
        if ($request->ajax()) {
            
            $data = \App\Models\Roles::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function($data){
                    $btn = '
                            <a  href="'.route('admin.role.assign.permission',Crypt::encryptString($data->id)).'" data-id="' . Crypt::encryptString($data->id) . '" class="btn btn-info btn-xs"  flash="City"   title="Assign Permission" >Permission</a> ';
                    return $btn;
                })
                
               
                ->rawColumns(['action-js'])
                //->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
               // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }
    function assignPermission($encrypt_id) {
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $role = \App\Models\Roles::findOrFail($id);
           // dd($city_data);
            return view('admin/role/assign-permission',compact('encrypt_id'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    function assignPermissionPost(Request $request ,$encrypt_id) {
        try {
            $id =  Crypt::decryptString($encrypt_id);  
            $role = \App\Models\Roles::findOrFail($id);
            $data = $request->except('_token');
            \App\Models\Permissions::where('role_id','=',$id)->delete();
            
            if(!empty($data)){
                foreach ($data as $key => $value) {
                    $permission  = new  \App\Models\Permissions;
                    $permission->role_id = $id;
                    $permission->menu_name = $key;
                    $permission->menu_access = $value;
                    $permission->save();
                }
            }
            return redirect()->back()->with('message', 'Role Create Successfully');

        } catch (\Exception $e) {
            return dd($e->getMessage());
        } 
    }
    
}
