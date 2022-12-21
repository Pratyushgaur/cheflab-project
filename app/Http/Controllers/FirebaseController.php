<?php

namespace App\Http\Controllers;

use App\Events\OrderCreateEvent;
use App\Models\Vendors;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;

class FirebaseController extends Controller
{

    public function index()
    {
        $firebase = (new Factory)->withServiceAccount(__DIR__ . '/chef-leb-firebase-adminsdk-16jo3-61687cdb1b.json')
            //            ->withDatabaseUri('https://laravel-firebase-demo-8b4b1-default-rtdb.firebaseio.com');
            ->withDatabaseUri('https://chef-leb-default-rtdb.firebaseio.com/');

        $database = $firebase->createDatabase();

        $blog = $database->getReference('delivery_boy');

        echo '<pre>';
        print_r($blog->getvalue());
        echo '</pre>';

        //        $database = $firebase->getDatabase();

        $newPost = $database->getReference('delivery_boy')
            ->push(['title' => 'Laravel FireBase Tutorial', 'category' => 'Laravel']);
        echo '<pre>';
        print_r($newPost->getvalue());
    }

    public function updateTokenVendor(Request $request)
    {
        try {
            if (Auth::guard('vendor')->check()) {
                $v            = Vendors::find(\Auth::guard('vendor')->user()->id);
                $v->fcm_token = $request->token;
                $v->save();
            }
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function notification()
    {
        try {

            $order = \App\Models\Order::find(2);
            event(new OrderCreateEvent($order,25, 1, 1));
            dd("sdfdf");
//            dd(\Auth::guard('vendor')->user()->fcm_token);
//            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
//            $fcmTokens[] = auth()->user()->fcm_token;
//            \Illuminate\Support\Facades\Notification::send(null,new SendPushNotification("Test title","Description",$fcmTokens));

            /* or */

//            auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
//            $r=Auth::guard('vendor')->user()->notify(new SendPushNotification("Test title","Description",\Auth::guard('vendor')->user()->fcm_token));
            /* or */
//            dd($fcmTokens);
//            Larafirebase::withTitle('Title')
//                ->withBody('msg')
//                ->sendMessage($fcmTokens);
//dd($r);
//            return redirect()->back()->with('success', 'Notification Sent Successfully!!');

        } catch (\Exception $e) {
            report($e);
            dd($e);
            return redirect()->back()->with('error', 'Something goes wrong while sending notification.');
        }
    }
}
