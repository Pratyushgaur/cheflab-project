<?php

namespace App\Http\Controllers;

use App\Models\Superadmin;
use App\Models\PushNotification;
use App\Models\Deliver_boy;
use App\Models\DeliveryBoyTokens;
use App\Models\User;
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
            $data = PushNotification::get();
   
            return Datatables::of($data)    
                ->addIndexColumn()
               
            ->addColumn('date', function($data){
                $date_with_format = date('Y-m-d',strtotime($data->created_at));
                return $date_with_format;
            })

            ->addColumn('type', function($data){
                if($data->send_to == 1){ 
                    return "Rider"; 
                }else{
                    return "User";    
                }
                
            })

            ->addColumn('image', function($data){
                $image = "<img src=" . asset('push_notify_banner') . '/' . $data->notification_banner . "  style='width: 50px;' />";
                return $image;
            })
            

            ->rawColumns(['type','image'])

            ->make(true);
       }
    }

    
    public function push_notification_store(Request $request)
    {
        $this->validate($request, [
            'title'   => 'required',
            'zone'   => 'required',
            'send_to'   => 'required',
           
        ]);
        $notification = new PushNotification;
        $notification->title = $request->title;
        $notification->zone = $request->zone;
        $notification->send_to = $request->send_to;
        $notification->description = $request->description;
       

        if ($request->has('notification_banner')) {
            $filename = time() . '-notification-' . rand(100, 999) . '.' . $request->notification_banner->extension();
            $request->notification_banner->move(public_path('push_notify_banner'), $filename);
            $notification->notification_banner = $filename;
        } 
        $notification->save();

        if($request->send_to == 1){
            $send_data = "Rider";
            $allToken = Deliver_boy::where('status' , 1)->where('token', '!=' , NULL)->join('delivery_boy_tokens', 'deliver_boy.id', '=', 'delivery_boy_tokens.rider_id')->select('deliver_boy.id','delivery_boy_tokens.token')->orderBy('id','desc')->get()->pluck('token');

        }else{
            $send_data = "User";
            $allToken = User::where('status' , 1)->where('fcm_token', '!=' , NULL)->orderBy('id','desc')->get()->pluck('fcm_token');
        }
        
        $title = $request->title;
        $body = $request->description;

        sendNotification($title, $body, $allToken);
       
        return redirect()->route('admin.notification.view')->with('message', 'Notification Send To '. $send_data .' Successfully');
 

    }

    

    // public function sendNotification($notifyData, $sendToken){
    //     $url = "https://fcm.googleapis.com/fcm/send";
    //     $token = $sendToken;
    //     $serverKey = env('FIREBASE_SERVER_KEY');
    //     $title = "Notification title";
    //     $body = "Hello I am from Your php server";
    //     $notification = $notifyData;
    //     $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
    //     $json = json_encode($arrayToSend);
    //     $headers = array();
    //     $headers[] = 'Content-Type: application/json';
    //     $headers[] = 'Authorization: key='. $serverKey;
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    //     //Send the request
    //     $response = curl_exec($ch);
    //     //Close request
    //     if ($response === FALSE) {
    //     die('FCM Send Error: ' . curl_error($ch));
    //     }
    //     curl_close($ch);
    //     //return $noti = new SendPushNotification('test','msg','ekElJ6_hR9ez2Y9PDIm5SX:APA91bFrhilpGDE1KEB4QlXSYGQ04dYbz-aB6G8A7F5Fsaw5DnHUVL6ttcewpOyvHRM2Uih2lk4TXmk-DiZfotrLGkfRxN2VFVPjn_8BpvNIFopRnJrEQfyJLGo6O_7J7MFX0u4SYGlY');

    // }

    
}
