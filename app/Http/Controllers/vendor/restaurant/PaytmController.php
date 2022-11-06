<?php

namespace App\Http\Controllers\vendor\restaurant;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaytmController extends Controller
{


    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function register()
    {
//        return view('register');
    }


    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order(Request $request)
    {


//        $this->validate($request, [
//            'name' => 'required',
//            'mobile_no' => 'required|numeric|digits:10|unique:event_registration,mobile_no',
//            'address' => 'required',
//        ]);


//        $input = $request->all();
        $input['order_id'] = $request->mobile_no.rand(1,100);
        $input['fee'] = 50;


//        EventRegistration::create($input);


        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'cus_ID'=>'123456',
            'order' => 1,
            'user' => 'your paytm user',
            'mobile_number' => 'your paytm number',
            'email' => 'your paytm email',
            'amount' => 5,
            'callback_url' => url('api/payment/status')
        ]);
        return $payment->receive();
    }


    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');


        $response = $transaction->response();
        $order_id = $transaction->getOrderId();


        if($transaction->isSuccessful()){
            EventRegistration::where('order_id',$order_id)->update(['status'=>2, 'transaction_id'=>$transaction->getTransactionId()]);


            dd('Payment Successfully Paid.');
        }else if($transaction->isFailed()){
            EventRegistration::where('order_id',$order_id)->update(['status'=>1, 'transaction_id'=>$transaction->getTransactionId()]);
            dd('Payment Failed.');
        }
    }

}
