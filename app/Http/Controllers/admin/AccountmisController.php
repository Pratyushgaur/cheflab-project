<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Models\Product_master;
use App\Models\Vendor_payout_detail;
use App\Models\OrderCommision;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Config;
use Auth;

use Carbon\Carbon;
use App\Models\MonthlyInvoice;
use App\Models\Vendors;
use App\Models\AdminMasters;
use App\Models\Orders;

class AccountmisController extends Controller
{
    public function index()
    {

        return view('admin.mis.list');
    }


    public function get_data_table_of_order(Request $request)
    {
        
        if ($request->ajax()) {


            // $data = Orders::join('order_commisions', 'orders.id', '=', 'order_commisions.order_id')->join('vendors', 'orders.vendor_id', '=', 'vendors.id')->join('users', 'orders.user_id', '=', 'users.id')->join('coupons', 'orders.coupon_id', '=', 'coupons.id')->join('rider_assign_orders', 'order_commisions.order_id', '=', 'rider_assign_orders.order_id')->select('orders.order_id', 'orders.transaction_id', 'orders.coupon_id', 'orders.preparation_time_from', 'orders.preparation_time_to', 'orders.customer_name', 'vendors.name as vendor_name', 'order_commisions.net_amount', 'order_commisions.vendor_commision', 'order_commisions.admin_commision', 'order_commisions.admin_amount', 'orders.created_at', 'users.name', 'orders.platform_charges', 'orders.tex', 'orders.discount_amount', 'orders.wallet_cut', 'vendors.commission', 'rider_assign_orders.earning', 'orders.delivery_charge', 'coupons.code');

            // $data = Orders::
            // join('order_commisions', 'orders.id', '=', 'order_commisions.order_id')
            // ->join('vendors', 'orders.vendor_id', '=', 'vendors.id')
            // ->join('users', 'orders.user_id', '=', 'users.id')
            // ->join('coupons', 'orders.coupon_id', '=', 'coupons.id')
            // ->join('rider_assign_orders', 'order_commisions.order_id', '=', 'rider_assign_orders.order_id')
            // select('orders.order_id', 'orders.transaction_id', 'orders.coupon_id', 'orders.preparation_time_from', 'orders.preparation_time_to', 'orders.customer_name', 'orders.created_at', 'orders.platform_charges', 'orders.tex', 'orders.discount_amount', 'orders.wallet_cut', 'orders.delivery_charge');



            $data = Orders::join('vendors', 'orders.vendor_id', '=', 'vendors.id')->join('users', 'orders.user_id', '=', 'users.id')->join('coupons', 'orders.coupon_id', '=', 'coupons.id')->join('rider_assign_orders', 'orders.order_id', '=', 'rider_assign_orders.order_id')->select('orders.id','orders.order_id', 'orders.transaction_id', 'orders.coupon_id', 'orders.preparation_time_from', 'orders.preparation_time_to', 'orders.customer_name', 'vendors.name as vendor_name', 'orders.created_at', 'users.name', 'orders.platform_charges', 'orders.tex', 'orders.discount_amount', 'orders.wallet_cut', 'vendors.commission', 'rider_assign_orders.earning', 'orders.delivery_charge', 'coupons.code','rider_assign_orders.action', 'orders.total_amount', 'orders.net_amount');
            
            if ($request->status != '') {
                $data = $data->where('payment_status', '=', $request->status);
            }
            if ($request->role != '') {
                $data = $data->where('vendors.vendor_type', '=', $request->role);
            }
            if ($request->vendor != '') {
                $data = $data->where('orders.vendor_id', '=', $request->vendor);
            }
            $data = $data->where('rider_assign_orders.action', '!=', '2');

            $dateSedule = $request->datePicker;

            if (isset($dateSedule)) {
                $packagetime = explode('/', $dateSedule);
                $start_time = $packagetime[0] . ' 00:00:00';
                $end_time = $packagetime[1] . ' 23:59:59';
            }

            if (!empty($start_time) && !empty($end_time)) {
                $data = $data->whereBetween('orders.created_at', [$start_time, $end_time]);
            }


            $data = $data->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('wallet_cut', function($data){
                //     $wallet_cut = 0;
                //     return $wallet_cut;
                // })
                ->addColumn('rider_earning', function ($data) {
                    if ($data->earning == '') {
                        $rider_earning = 0;
                    } else {
                        $rider_earning = $data->earning;
                    }
                    return $rider_earning;
                })

                ->addColumn('date', function($data){
                    $date_with_format = date('d M Y h:i A',strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('admin_earning_vendor', function($data){
                    $ordercommission = OrderCommision::where('order_id', $data->id)->first();
                    if($ordercommission != ''){
                        $admin_earning_vendor = $ordercommission->admin_commision;
                    }else{
                        $admin_earning_vendor = '0';
                    }
                    return $admin_earning_vendor;
                })

                ->addColumn('vendor_settlement', function($data){
                    $vendor_settlement_amount = OrderCommision::where('order_id', $data->id)->first();
                    if($vendor_settlement_amount != ''){
                        $vendor_settlement = $vendor_settlement_amount->net_receivables;
                    }else{
                        $vendor_settlement = '0';
                    }
                    return $vendor_settlement;
                })


                ->addColumn('admin_earning_rider', function($data){

                    $admin_earning_rider = $data->delivery_charge - $data->earning;
                    
                    return $admin_earning_rider;
                })



                

                ->addColumn('admin_erning', function ($data) {
                    $ordercommission = OrderCommision::where('order_id', $data->id)->first();
                    if($ordercommission != ''){
                        $admin_earning_vendor = $ordercommission->admin_commision;
                    }else{
                        $admin_earning_vendor = '0';
                    }
                    $admin_erning = $admin_earning_vendor + $data->delivery_charge - $data->earning;
                    return $admin_erning;
                })


                ->rawColumns(['wallet_cut', 'admin_erning','admin_earning_vendor','date','admin_earning_rider','rider_earning', 'action-js'])

                ->rawColumns(['action-js']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                // ->rawColumns(['status']) // if you want to add two action coloumn than you need to add two coloumn add in array like this

                ->make(true);
        }
    }

    public function getVendorByRole(Request $request)
    {
        return Vendors::where('vendor_type', '=', $request->role)->select('id', 'name')->get();
    }
    public function vieworder($encrypt_id)
    {
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $order_id = $id;
            $order = Orders::findOrFail($id);

            $vendor_id = $order->vendor_id;
            $user_id = $order->user_id;
            $orderProduct = OrderProduct::findOrFail($order_id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id', '=', $product_id)->select('id', 'product_name', 'product_image', 'primary_variant_name', 'product_price', 'type')->get();
            $vendor = Vendors::findOrFail($vendor_id);
            $users = User::findOrFail($user_id);

            return view('admin.order.view', compact('order', 'orderProduct', 'product', 'vendor', 'users'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function invoiceorder($order_id)
    {
        $order = Orders::where('order_id', $order_id)->first();
        $vendor = Vendors::findOrFail($order->vendor_id);
        $users = User::findOrFail($order->user_id);
        $orderProduct = OrderProduct::findOrFail($order_id);
        $product_id = $orderProduct->product_id;
        $product = Product_master::where('id', '=', $product_id)->select('id', 'product_name', 'product_image', 'primary_variant_name', 'product_price', 'type')->get();
        return view('admin.order.invoice', compact('order', 'vendor', 'users', 'product'));
        // echo '<pre>'; print_r($order);die;
    }
    public function status_update(Request $request)
    {

        $status = $request->status;
        $id = $request->id;
        $orders = Orders::where('id', '=',  $id)->first();
        $orders->order_status = $status;
        $orders->save();

        return;
    }

    public function invoice($encrypt_id)
    {
        try {
            $id =  Crypt::decryptString($encrypt_id);
            $order_id = $id;
            $order = Orders::findOrFail($id);
            $vendor_id = $order->vendor_id;
            $orderProduct = OrderProduct::findOrFail($order_id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id', '=', $product_id)->select('id', 'product_name', 'product_image', 'primary_variant_name', 'product_price')->get();
            $vendor = Vendors::findOrFail($vendor_id);
            return view('admin.order.invoice', compact('order', 'orderProduct', 'product', 'vendor'));
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function get_data_table_of_product(Request $request, $id)
    {

        $product_id = $id;
        if ($request->ajax()) {

            //$data = Product_master::join('vendors','orders.vendor_id','=','vendors.id')->select('orders.id','orders.customer_name','orders.order_status','net_amount','payment_type','orders.created_at', 'vendors.name as vendor_name','vendors.vendor_type');
            $data = Product_master::where('id', '=', $product_id)->select('id', 'product_name', 'product_image', 'product_price', 'primary_variant_name')->get();
            return Datatables::of($data)
                ->addIndexColumn()


                ->addColumn('date', function ($data) {
                    $date_with_format = date('d M Y', strtotime($data->created_at));
                    return $date_with_format;
                })

                ->addColumn('product_name', function ($data) {
                    $btn = ' <img src="' . asset('products') . '/' . $data->product_image . '" data-pretty="prettyPhoto" style="width:50px; height:30px;" alt="Trolltunga, Norway"> <div id="myModal" class="modal">
            <img class="modal-content" id="img01">
            </div>' . $data->product_name . '';
                    return $btn;
                })

                ->rawColumns(['date'])
                ->rawColumns(['product_name']) // if you want to add two action coloumn than you need to add two coloumn add in array like this
                ->make(true);
        }
    }


    public function monthly_invoice(Request $request)
    {

        return view('admin.mis.monthly_invoice');
    }

    public function monthly_invoice_list(Request $request)
    {

        if ($request->ajax()) {

            $data = MonthlyInvoice::select('monthly_invoices.*', 'vendors.name')->join('vendors', 'monthly_invoices.vendor_id', '=', 'vendors.id');

            if (!empty($start_time) && !empty($end_time)) {
                $data = $data->whereBetween('monthly_invoices.created_at', [$start_time, $end_time]);
            }
            $data = $data->get();

            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a class="btn btn-xs btn-danger" href="' . asset("$data->invoice_file") . '" download>Download Invoice</a>';
                    return $btn;
                })
                ->addColumn('month_year', function ($data) {
                    $strtotimedata = strtotime($data->month_year);
                    $month_year = date("M - Y", $strtotimedata);
                    return $month_year;
                })
                ->rawColumns(['action','month_year'])
                ->make(true);
        }
    }

    public function genrate_invoice(Request $request)
    {

        $vendorData = Vendors::get();

        // $scheduleTime =\Carbon\Carbon::createFromTimestampUTC($request->datepicker)->diffInSeconds();
        // $month = gmdate("m", $scheduleTime);
        // $year = gmdate("Y", $scheduleTime);
        // $monthYear = gmdate("M - Y", $scheduleTime);

        $month = 02;
        $year = 2023;
        $monthYear = "Jan - 2023";


        $totalAmount = Orders::where(['vendor_id' => $vendorData->id, 'order_status' => "dispatched"])->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get()->sum('total_amount');

        $adminDetail = AdminMasters::select('admin_masters.email', 'admin_masters.phone', 'admin_masters.suport_phone', 'admin_masters.office_addres', 'admin_masters.gstno')->first();

        $vendorDetail = Vendors::where(['vendor_id' => $vendorData->id])->select('vendors.name', 'vendors.owner_name', 'vendors.email', 'vendors.mobile', 'vendors.pincode', 'vendors.address', 'vendors.fssai_lic_no', 'vendors.gst_no', 'vendors.commission')->first();

        $commission = ($totalAmount * $vendorDetail->commission) / 100;

        $sgst = ($commission * 9) / 100;
        $cgst = ($commission * 9) / 100;
        $invoiceNo = rand(99999, 999999);

        $totalAdminCommission = $commission + $sgst + $cgst;

        $invoiceName = rand(9999, 99999) . $vendorData->id . '.pdf';
        $pdf = \PDF::chunkLoadView('<html-separator/>', 'admin.pdf.monthly_invoice', compact('adminDetail', 'vendorDetail', 'commission', 'sgst', 'cgst', 'totalAdminCommission', 'monthYear', 'invoiceNo'));

        $pdf->save(public_path('uploads/invoices/' . $invoiceName));
        $url = 'uploads/invoices/' . $invoiceName;


        $pdfData = new MonthlyInvoice;
        $pdfData->vendor_id = $vendorData->id;
        $pdfData->invoice_number = $invoiceNo;
        $pdfData->invoice_file = $url;
        $pdfData->total_amount = $totalAdminCommission;
        $pdfData->month_year = $monthYear;
        $pdfData->save();
        return true;
    }
}
