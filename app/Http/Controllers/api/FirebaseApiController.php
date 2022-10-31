<?php

namespace App\Http\Controllers\API;

use App\Models\Vendors;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;

class FirebaseApiController extends Controller
{

    public function updateTokenUser(Request $request)
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
//            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
//            $fcmTokens[] = \Auth::guard('vendor')->user()->fcm_token;
//            \Illuminate\Support\Facades\Notification::send(null,new SendPushNotification("Test title","Description",$fcmTokens));

            /* or */

//            auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));
            $r=Auth::guard('vendor')->user()->notify(new SendPushNotification("Test title","Description",\Auth::guard('vendor')->user()->fcm_token));
            /* or */
//            dd($fcmTokens);
//            Larafirebase::withTitle('Title')
//                ->withBody('msg')
//                ->sendMessage($fcmTokens);
//dd($r);
            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'msg'=>$e->getMessage()
            ], 500);
        }
    }
}
