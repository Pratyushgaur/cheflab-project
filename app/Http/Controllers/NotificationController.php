<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use App\Models\pushNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;

class NotificationController extends Controller
{
    public function index()
    {

        $notifications = [];
        if (Auth::guard('admin')->check()) {
            $notifications = Auth::guard('admin')->user()->notifications()->paginate(25);
        } elseif (Auth::guard('vendor')->check()) {
            $notifications = Auth::guard('vendor')->user()->notifications()->paginate(5);
        } elseif (Auth::guard('chef')->check()) {
            $notifications = Auth::guard('chef')->user()->notifications()->paginate(25);
        }
        //dd(Auth::guard('vendor')->check());

        return view('notification.index', compact('notifications'));
    }
    public function admin_index()
    {
        // echo "hello";die;
        $notifications = [];
        $user = Superadmin::find(Auth::guard('admin')->user()->id);
        if (Auth::guard('admin')->check()) {
            //$notifications = $user->unreadNotifications->notifications()->paginate(25);
            //$notifications = Auth::guard('admin')->user()->notifications()->paginate(25);

            $page = 2; /* Actual page */

            $limit = 4; /* Limit per page*/

            $notifications = [];
        }
        //dd(Auth::guard('admin')->user()->id);
        return view('admin.notification.index', compact('notifications'));
    }

    public function create()
    {
        return 'under developement';
    }

    public function notification_list(Request $request)
    {
        if ($request->ajax()) {
            $data = pushNotification::get();
   
            return Datatables::of($data)    
                ->addIndexColumn()
               
            // ->addColumn('date', function($data){
            //     $date_with_format = date('Y-m-d',strtotime($data->created_at));
            //     return $date_with_format;
            // })

            // ->addColumn('active_time', function($data){
            //     $active_time = gmdate('H:i:s', $data->total_hr);
            //     return $active_time;
            // })

            ->rawColumns([''])

            ->make(true);
       }
    }


    
}
