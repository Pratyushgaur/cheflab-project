<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\AppPromotionBlogBooking;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Redirect;
use Response;
use Session;

class RazorpayRestaurantController extends Controller
{

    public function razorpay()
    {
        return view('index');
    }

    public function payment(Request $request)
    {
        $input   = $request->all();
        $api     = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {

                $response                               = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $PaymentTransaction                     = new PaymentTransaction();
                $PaymentTransaction->foreign_id         = $request->id;
                $PaymentTransaction->foreign_table_name = "app_promotion_blog_bookings";
                $PaymentTransaction->user_id            = \Auth::guard('vendor')->user()->id;
                $PaymentTransaction->user_table_name    = 'vendors';
                $PaymentTransaction->r_payment_id       = $response->id;
                $PaymentTransaction->amount             = $response->amount/100;
                $PaymentTransaction->currency           = $response->currency;
                $PaymentTransaction->status             = $response->status;
                $PaymentTransaction->method             = $response->method;
                $PaymentTransaction->amount_refunded    = $response->amount_refunded;
                $PaymentTransaction->refund_status      = $response->refund_status;
                $PaymentTransaction->description        = $response->description;

                $PaymentTransaction->save();

                $AppPromotionBlogBooking                 = AppPromotionBlogBooking::find($PaymentTransaction->foreign_id);
                $AppPromotionBlogBooking->payment_status = 1;
                $AppPromotionBlogBooking->save();
                \Session::put('success', 'Payment successful, your request send to admin for approval.');
                return redirect()->back();

//dd($response);
            } catch (\Exception $e) {
                return $e->getMessage();
                \Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }
        \Session::put('success', 'Something went worng.');
        return redirect()->back();
    }
}
