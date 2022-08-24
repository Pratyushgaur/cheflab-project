<?php

namespace App\Http\Controllers\admin;

use App\Models\MangaoStaticUseradmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo $password = Hash::make('123456');
        
        // $response = Gate::inspect('isSuperAdmin');
        
        // Gate::authorize('isSuperAdmin');
 
        // if (Gate::allows('isSuperAdmin')) {

        //    echo "you are admin";

        // } else {

        //     echo "you are not admin";

        // }

        // return $response;
        // if (Gate::denies('isSuperAdmin')) {
        //         abort(403);
        //     }

        // die();
        return view('admin.dashbord.dash');
    }
}
