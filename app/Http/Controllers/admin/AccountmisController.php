<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Models\Product_master;
use App\Models\Vendor_payout_detail;
use App\Models\OrderCommision;
use App\Models\VendorMonthlyInvoices;

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
        $vendor = Vendors::select('id','name')->orderBy('id','desc')->get();
        return view('admin.mis.list',compact('vendor'));
    }


    public function get_data_table_of_order(Request $request)
    {
        
        if ($request->ajax()) {
            
            $todate = \Carbon\Carbon::parse($request->todate);
            $todate = $todate->addDays(1);
            $data = Orders::join('vendors', 'orders.vendor_id', '=', 'vendors.id')->join('users', 'orders.user_id', '=', 'users.id')->join('rider_assign_orders', 'orders.order_id', '=', 'rider_assign_orders.order_id')->select('orders.id','orders.order_id', 'orders.transaction_id', 'orders.coupon_id', 'orders.preparation_time_from', 'orders.preparation_time_to', 'orders.customer_name', 'orders.created_at', 'orders.platform_charges', 'orders.tex', 'orders.discount_amount', 'orders.wallet_cut', 'orders.delivery_charge', 'orders.total_amount', 'orders.net_amount', 'vendors.name as vendor_name', 'vendors.commission', 'users.name', 'rider_assign_orders.earning','accepted_driver_id');
            if($request->vendor_id != ''){
                $data = $data->where('orders.vendor_id',$request->vendor_id);
            }
            $data = $data->orderBy('orders.id','DESC');
            $data = $data->where('orders.order_status','=','completed');
            if ($request->from != '' &&  $request->todate != '') {
                $data = $data->whereBetween('orders.created_at', [$request->from,$todate]);
            }
            $data = $data->where('rider_assign_orders.action', '!=', '2');

            $data = $data->get(); 
            return Datatables::of($data)
                ->addIndexColumn()
                
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

                ->addColumn('code', function ($data) {
                    
                    if($data->coupon_id != '0' && $data->coupon_id != '' ){
                        $couponCode = Coupon::where('id', $data->coupon_id)->first();
                        if(!empty($couponCode)){
                            $code = $couponCode->code;
                        }else{
                            $code = '-';    
                        }
                    }else{
                        $code = '-';
                    }
                    return $code;
                })

                // ->addColumn('discount_amount', function ($data) {
                    
                //     if($data->coupon_id != '0' && $data->coupon_id != ''){
                //         $couponCode = Coupon::where('id', $data->coupon_id)->first();
                //         if(!empty($couponCode)){
                //             $discount_amount = $couponCode->discount;
                //         }else{
                //             $discount_amount = '0';
                //         }
                //     }else{
                //         $discount_amount = '0';
                //     }
                //     return $discount_amount;
                // })
                
                ->addColumn('rider_name', function ($data) {
                    
                    if ($data->accepted_driver_id != null) {
                        $rider = \App\Models\Deliver_boy::where('id','=',$data->accepted_driver_id)->select('name')->first();
                        if(!empty($rider)){
                            $rider = $rider->name;
                        }else{
                            $rider = '';
                        }
                        
                    } else {
                        $rider = '';
                    }
                    return $rider;
                    
                })
                ->addColumn('net_order_value', function ($data) {
                    return $data->total_amount-$data->discount_amount;
                })
                ->addColumn('gst_per', function ($data) {
                     $net =  $data->total_amount-$data->discount_amount;
                    $gst_per = $data->tex/$net*100;
                    return round($gst_per);
                })
                ->addColumn('order_value_inc_tax', function ($data) {
                    $netorder = $data->total_amount-$data->discount_amount;
                    return $netorder+$data->tex;
                })
                ->addColumn('exclusive_delivery_charge', function ($data) {
                    $tx = $data->delivery_charge*18/100;
                    return round($data->delivery_charge-$tx,2);
                })
                ->addColumn('exclusive_platform_charge', function ($data) {
                    $tx = $data->platform_charges*18/100;
                    return round($data->platform_charges-$tx,2);
                })



                ->rawColumns(['wallet_cut', 'admin_erning', 'code','admin_earning_vendor','date','admin_earning_rider','rider_earning', 'action-js' ,'rider_name','net_order_value','order_value_inc_tax','exclusive_delivery_charge','exclusive_platform_charge'])

                 

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

    // public function monthly_invoice_list(Request $request)
    // {

    //     if ($request->ajax()) {

    //         $data = MonthlyInvoice::select('monthly_invoices.*', 'vendors.name')->join('vendors', 'monthly_invoices.vendor_id', '=', 'vendors.id');

    //         if (!empty($start_time) && !empty($end_time)) {
    //             $data = $data->whereBetween('monthly_invoices.created_at', [$start_time, $end_time]);
    //         }
    //         $data = $data->get();

    //         return Datatables::of($data)

    //             ->addIndexColumn()
    //             ->addColumn('action', function ($data) {
    //                 $btn = '<a class="btn btn-xs btn-danger" href="' . asset("$data->invoice_file") . '" download>Download Invoice</a>';
    //                 return $btn;
    //             })
    //             ->addColumn('month_year', function ($data) {
    //                 $strtotimedata = strtotime($data->month_year);
    //                 $month_year = date("M - Y", $strtotimedata);
    //                 return $month_year;
    //             })
    //             ->rawColumns(['action','month_year'])
    //             ->make(true);
    //     }
    // }

    function monthly_invoice_list(Request $request){
        if ($request->ajax()) {
           // return $request->month;
           $month = $request->month;
           $year = $request->year;
           $statement =   \App\Models\OrderCommision::whereMonth('order_commisions.created_at','=',$request->month)->whereYear('order_commisions.created_at', '=', $request->year);
           $statement =  $statement->join('vendors','order_commisions.vendor_id','=','vendors.id');
           $statement =  $statement->leftJoin('vendor_monthly_invoices', function ($join) use ($month,$year) {
                            $join->on('order_commisions.vendor_id', '=', 'vendor_monthly_invoices.vendor_id');
                            $join->where('vendor_monthly_invoices.month', '=', $month);
                            $join->where('vendor_monthly_invoices.year', '=', $year);
                        });
           $statement =  $statement->where('is_cancel',0);
           $statement =  $statement->groupBy('order_commisions.vendor_id');
           $statement =  $statement->select('vendors.name',\DB::raw('SUM(order_commisions.gross_revenue) as gross_revenue_total'),\DB::raw('SUM(admin_commision) as admin_commision_total'),\DB::raw('sum(tax_on_commission) as tax_on_commission_total'),\DB::raw('sum(convenience_amount) as convenience_amount_total'),\DB::raw('sum(convenience_tax) as convenience_tax_total'),\DB::raw('sum(net_receivables) as net_receivables_total'),'vendor_monthly_invoices.id as vendor_monthly_invoices_id');
           $order = $statement->get();
           


           return Datatables::of($order)->addIndexColumn()
            ->addColumn('action', function ($order) {
                if($order->vendor_monthly_invoices_id == null){
                    $btn = '<a class="btn btn-xs btn-danger" style="color:#fff;">Pending</a>';

                }else{
                    $btn = '<a target="_blank" href="'.route("admin.account.vendor.invoices.print",$order->vendor_monthly_invoices_id).'" class="btn btn-xs btn-success" style="color:#fff;">View Invoice</a>';

                }
                return $btn;
            })
            
            
            ->rawColumns(['action','net_amount'])
            ->make(true);



            // $order = Orders::whereMonth('orders.created_at', '=', $request->month)->whereYear('orders.created_at', '=', $request->year);
            // $order = $order->join('vendors','orders.vendor_id','=','vendors.id');
            // $order = $order->select('vendors.name',\DB::raw('SUM(net_amount) as net_am'),\DB::raw('SUM(total_amount) as item_total'));
            // $order = $order->groupBy('orders.vendor_id');
            // $order = $order->orderBy(\DB::raw('SUM(net_amount)'),'DESC');
            // $order = $order->get();
            // return Datatables::of($order)->addIndexColumn()
            // ->addColumn('action', function ($order) {
            //     $btn = '<a class="btn btn-xs btn-success" style="color:#fff;">Generate Invoice</a>';
            //     return $btn;
            // })
            // ->addColumn('net_amount', function ($order) {
               
            //     return number_format($order->net_am,2);
            // })
            // ->rawColumns(['action','net_amount'])
            // ->make(true);
        }
    }
    function generated_invoice_list(Request $request){
        if ($request->ajax()) {
           $order = VendorMonthlyInvoices::join('vendors','vendor_monthly_invoices.vendor_id','=','vendors.id')->select('vendors.name as vendor_name','vendor_monthly_invoices.*')->get();
           return Datatables::of($order)->addIndexColumn()
           ->addColumn('year_mnth', function ($order) {
               
                return $order->month.'-'.$order->year;
            })->make(true);

        }
    }
    function generateBulkInvoice(Request $request){
        try {
            $this->validate($request, 
                [
                'month' => ['required'],
                'year' => ['required']
                ]
        
            );

            $statement =   \App\Models\OrderCommision::whereMonth('order_commisions.created_at','=',$request->month)->whereYear('order_commisions.created_at', '=', $request->year);
            $statement =   $statement->join('vendors','order_commisions.vendor_id','=','vendors.id');
            $statement =   $statement->groupBy('vendor_id');
            $statement =   $statement->select('vendors.id','vendors.name',\DB::raw('SUM(gross_revenue) as gross_revenue_total'),\DB::raw('SUM(admin_commision) as admin_commision_total'),\DB::raw('sum(tax_on_commission) as tax_on_commission_total'),\DB::raw('sum(convenience_amount) as convenience_amount_total'),\DB::raw('sum(convenience_tax) as convenience_tax_total'),\DB::raw('sum(net_receivables) as net_receivables_total'));
            $order = $statement->get();

            foreach ($order as $key => $value) {
                if(!VendorMonthlyInvoices::where('year','=',$request->year)->where('month','=',$request->month)->where('vendor_id','=',$value->id)->exists()){
                    $VendorMonthlyInvoices = new \App\Models\VendorMonthlyInvoices;
                    $VendorMonthlyInvoices->vendor_id = $value->id;
                    $VendorMonthlyInvoices->year = $request->year;
                    $VendorMonthlyInvoices->month = $request->month;
                    $VendorMonthlyInvoices->invoice_number = "CL/".$request->month.'-'.$request->year.'/'.getInvoiceNumber();
                    $VendorMonthlyInvoices->gross_revenue = $value->gross_revenue_total;
                    $VendorMonthlyInvoices->vendor_commission = $value->admin_commision_total;
                    $VendorMonthlyInvoices->commission_gst = $value->tax_on_commission_total;
                    $VendorMonthlyInvoices->convenience_fee = $value->convenience_amount_total;
                    $VendorMonthlyInvoices->convenience_fee_gst = $value->convenience_tax_total;
                    $VendorMonthlyInvoices->final_amount = $value->net_receivables_total;
                    $VendorMonthlyInvoices->save();
                }
            }
            return redirect()->route('admin.account.vendor.invoices.generate')->with('message', 'Invoice Generated Successfully');



        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
    public function genrate_invoice(Request $request)
    {

        //$vendorData = Vendors::get();
        $vendorData = Vendors::find(1);

        // $scheduleTime =\Carbon\Carbon::createFromTimestampUTC($request->datepicker)->diffInSeconds();
        // $month = gmdate("m", $scheduleTime);
        // $year = gmdate("Y", $scheduleTime);
        // $monthYear = gmdate("M - Y", $scheduleTime);

        $month = 03;
        $year = 2023;
        $monthYearData = "March - 2023";


        $totalAmount = Orders::where(['vendor_id' => $vendorData->id, 'order_status' => "completed"])->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get()->sum('total_amount');

        $adminDetail = AdminMasters::select('admin_masters.email', 'admin_masters.phone', 'admin_masters.suport_phone', 'admin_masters.office_addres', 'admin_masters.gstno')->first();

        $vendorDetail = $vendorData;//Vendors::where(['vendor_id' => $vendorData->id])->select('vendors.name', 'vendors.owner_name', 'vendors.email', 'vendors.mobile', 'vendors.pincode', 'vendors.address', 'vendors.fssai_lic_no', 'vendors.gst_no', 'vendors.commission')->first();

        $commission = ($totalAmount * $vendorDetail->commission) / 100;

        $sgst = ($commission * 9) / 100;
        $cgst = ($commission * 9) / 100;
        $invoiceNo = rand(99999, 999999);

        $totalAdminCommission = $commission + $sgst + $cgst;

        $invoiceName = rand(9999, 99999) . $vendorData->id . '.pdf';
        return view('admin.pdf.monthly_invoice',compact('adminDetail', 'vendorDetail', 'commission', 'sgst', 'cgst', 'totalAdminCommission', 'invoiceNo','vendorData','monthYearData'));
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

    function create_invoice(){
        return view('admin.mis.create_new_invoice');

    }
    function getWeeks(Request $request) {
        $currentDate  =  \Carbon\Carbon::parse("01-$request->month-$request->year");
        $currentMonth = $currentDate->month;
        $firstDayOfMonth = Carbon::createFromDate($currentDate->year, $currentMonth, 1);
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
        $weeks = [];
        $html = '<option value="">Select Week Slot</option>';
        while ($firstDayOfMonth->lte($lastDayOfMonth)) {
            $startOfWeek = $firstDayOfMonth->copy()->startOfWeek();
            $endOfWeek = $firstDayOfMonth->copy()->endOfWeek();
    
            // $weeks[] = [
            //     'start_date' => $startOfWeek->toDateString(),
            //     'end_date' => $endOfWeek->toDateString(),
            // ];
            $html .= '<option value="'.$startOfWeek->format('d-m-Y').'&'.$endOfWeek->format('d-m-Y').'">'.$startOfWeek->format('d-M-Y').' TO ' .$endOfWeek->format('d-M-Y').'</option>';
    
            // Move to the next week
            $firstDayOfMonth->addWeek();
        }
        return $html;
    }
    function weekOfMonth($date) {

        $firstOfMonth = strtotime(date("Y-m-01", $date));
        $lastWeekNumber = (int)date("W", $date);
        $firstWeekNumber = (int)date("W", $firstOfMonth);
        if (12 === (int)date("m", $date)) {
            if (1 == $lastWeekNumber) {
                $lastWeekNumber = (int)date("W", ($date - (7*24*60*60))) + 1;
            }
        } elseif (1 === (int)date("m", $date) and 1 < $firstWeekNumber) {
            $firstWeekNumber = 0;
        }
        return $lastWeekNumber - $firstWeekNumber + 1;
    }
    function printInvoice($id){
        $invoice = \App\Models\VendorMonthlyInvoices::where('id','=',$id)->first();
        $vendorDetail = Vendors::find($invoice->vendor_id);
        $vendorData =$vendorDetail;
        $monthYearData =  date("F", mktime(0, 0, 0, $invoice->month, 10)).'-'.$invoice->year;
        $adminDetail = \App\Models\AdminMasters::select('admin_masters.email', 'admin_masters.phone', 'admin_masters.suport_phone', 'admin_masters.office_addres', 'admin_masters.gstno')->first();
        return view('vendor.restaurant.pdf.monthly_invoice',compact('adminDetail', 'vendorDetail','monthYearData','vendorData','invoice'));
    }
}
