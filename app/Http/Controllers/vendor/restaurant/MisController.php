<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Product_master;
use App\Models\Paymentsetting;
use App\Models\Vendortransition;
use App\Models\OrderCommision;
use App\Models\Vendor_payout_detail;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Models\MonthlyInvoice;
use App\Models\Vendors;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use DB;
use PDF;
use Illuminate\Support\Facades;

class MisController extends Controller
{

    public function index(Request $request)
    {
        // orderCancel(16);die;

        $vendorId = Auth::guard('vendor')->user()->id;
        $order_sum = OrderCommision::where('vendor_id', $vendorId)->sum('gross_revenue');
        $order_count = OrderCommision::where('vendor_id', $vendorId)->where('is_approve', 1)->count();
        $additions_count = OrderCommision::where('vendor_id', $vendorId)->sum('additions');
        $deductions = OrderCommision::where('vendor_id', $vendorId)->sum('deductions');
        $net_receivables = OrderCommision::where('vendor_id', $vendorId)->sum('net_receivables');

        return view('vendor.mis.renvenue', compact('order_sum', 'order_count', 'additions_count', 'deductions', 'net_receivables'));
    }

    public function renvenue_ajax(Request $request)
    {

        $vendorId = Auth::guard('vendor')->user()->id;

        $date = explode('/', $request->start_date);
        $start_date = date('Y-m-d', strtotime($date[0]));
        $end_date = date('Y-m-d', strtotime($date[1]));

        $admin_commision = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('admin_commision');
        $tax_on_commission = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('tax_on_commission');
        $total_convenience_fee = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('total_convenience_fee');
        $cancel_by_vendor = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('vendor_cancel_charge');

        $deductions = $admin_commision + $tax_on_commission + $total_convenience_fee  + $cancel_by_vendor ;



       

        

        $order_sum = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('gross_revenue');
        // echo '<pre>'; print_r($order_sum);die;

        $order_count = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->count();
        //  echo '<pre>';print_r($order_count);die;
        $additions_count = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('additions');



        $admin_discount_sum = OrderCommision::where(['vendor_id'=> $vendorId, 'is_coupon'=> 1])->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('coupon_amount');

        // $vendor_discount_sum = OrderCommision::where(['vendor_id'=> $vendorId, 'is_coupon'=> 2])->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('coupon_amount');

        $paymentSetting = Paymentsetting::first();
        $vendorData = Vendors::where('id', $vendorId)->first();
        $admin_amount = (($order_sum + $admin_discount_sum) * $vendorData->commission) / 100;
        $tax_amount = ($admin_amount * 18) / 100;
        $convenience_amount = (($order_sum + $admin_discount_sum) * $paymentSetting->convenience_fee) / 100;
        $calceled_order = OrderCommision::where(['vendor_id' => $vendorId, 'cancel_by_vendor' => 1])->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('vendor_cancel_charge');

        

        $net_receivables = ($order_sum + $admin_discount_sum) - ($admin_amount + $tax_amount + $convenience_amount  + $calceled_order);

        $your_settlement = Vendor_payout_detail::where('vendor_id', $vendorId)->whereBetween('vendor_payout_details.created_at', [$start_date, $end_date])->sum('amount');

        return view('vendor.mis.renvenue_ajax', compact('order_sum', 'order_count', 'additions_count', 'deductions', 'net_receivables', 'your_settlement', 'start_date', 'end_date','admin_discount_sum'));
    }
    public function addition_view(Request $request)
    {

        $vendorId = Auth::guard('vendor')->user()->id;
        $additions_count = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$request->start_date, $request->end_date])->sum('additions');

        $discount_sum = OrderCommision::where(['vendor_id'=> $vendorId, 'is_coupon'=> 1])->whereBetween('order_commisions.order_date', [$request->start_date, $request->end_date])->sum('coupon_amount');

        return view('vendor.mis.addition_view', compact('additions_count','discount_sum'));
    }
    public function deductions_view(Request $request)
    {
        $vendorId = Auth::guard('vendor')->user()->id;
        $vendorData = Vendors::where('id', $vendorId)->first();
        $paymentSetting = Paymentsetting::first();

        $admin_commision = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$request->start_date, $request->end_date])->sum('admin_commision');
        $tax_on_commission = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$request->start_date, $request->end_date])->sum('tax_on_commission');
        $total_convenience_fee = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$request->start_date, $request->end_date])->sum('total_convenience_fee');
        $cancel_by_vendor = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$request->start_date, $request->end_date])->sum('vendor_cancel_charge');

        $total = $admin_commision + $tax_on_commission + $total_convenience_fee + $cancel_by_vendor;
        return view('vendor.mis.deductions_view', compact('admin_commision', 'tax_on_commission', 'total_convenience_fee', 'cancel_by_vendor', 'total'));
        

       
    }



    public function order_list()
    {
        return view('vendor.mis.order_list');
    }
    public function order_data(Request $request)
    {
         
        if ($request->ajax()) {

            $data = OrderCommision::where('orders.vendor_id', $request->vendorId)->join('orders', 'order_commisions.order_id', '=', 'orders.id')->select('order_commisions.*', 'orders.payment_type', 'orders.payment_status', 'orders.order_status');


            $dateSedule = $request->datePicker;

            if (isset($dateSedule)) {
                $packagetime = explode('/', $dateSedule);
                $start_time = $packagetime[0];
                $end_time = $packagetime[1];
            }

            if (!empty($start_time) && !empty($end_time)) {
                $data = $data->whereBetween('order_commisions.order_date', [$start_time, $end_time]);
            }


            $data = $data->get();
            // echo '<pre>';print_r($data);die;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action-js', function ($data) {
                    $btn = '<a href="' . route("restaurant.mis.order.view", $data->id) . '"><i class="fa fa-eye"></i></a> ';

                    return $btn;
                })
                ->addColumn('status', function ($data) {
                    if ($data->is_approve == 1) {
                        $btn = '<span class="text-success">Delivered</span>';
                    } elseif ($data->is_cancel == 1) {
                        $btn = '<span class="text-danger">Cancel</span>';
                    } else{
                        $btn = '';
                    } 
                    return $btn;
                })
                ->addColumn('net_receivables', function ($data) {
                    if ($data->net_receivables) {
                        $net_receivables =  number_format($data->net_receivables,2);
                    }else{
                        $net_receivables = '';
                    } 
                    return $net_receivables;
                })
                


                ->rawColumns(['status', 'action-js'])


                ->make(true);
        }
    }
    public function order_detail($id)
    {

        $order = OrderCommision::where('order_commisions.id', $id)->join('orders', 'order_commisions.order_id', '=', 'orders.id')->select('order_commisions.*', 'orders.payment_type', 'orders.payment_status', 'orders.order_status', 'order_commisions.is_approve', 'order_commisions.is_cancel')->first();
         
        return view('vendor.mis.order_detail', compact('order'));

    }

    public function oredr_export(Request $request)
    {
        return Excel::download(new OrderExport($request), 'order.xlsx');
    }

    public function order_invoice()
    {
        $pdf = PDF::loadView('vendor.mis.order_invoice');
        $invoiceName = 'order_' . time() . '.pdf';
        $pdf->save(public_path('invoices/' . $invoiceName));
        return $pdf->download('order_invoice.pdf');
    }

    public function settlements_view(Request $request)
    {
        $vendorId = Auth::guard('vendor')->user()->id;
        $settlements_list = Vendor_payout_detail::where('vendor_payout_details.vendor_id', $vendorId)->join('vendor_order_statements','vendor_payout_details.vendor_order_statements','=','vendor_order_statements.id')->select('vendor_payout_details.*','vendor_order_statements.start_date','vendor_order_statements.end_date','vendor_cancel_deduction')->get();
        return view('vendor.mis.settlements_view', compact('settlements_list'));
    }

    public function monthly_invoice_list(Request $request)
    {
    //    echo "hello";die;
    $settlements_list = 1;
    return view('vendor.mis.monthly_invoice_list', compact('settlements_list'));
    }


    public function monthly_invoice_list_data(Request $request)
    {
        $vendorId = Auth::guard('vendor')->user()->id;
        if ($request->ajax()) {

            // $data = MonthlyInvoice::where('monthly_invoices.vendor_id', $vendorId);
            // $data = $data->get();
            // return Datatables::of($data)
            //     ->addIndexColumn()
            //     ->addColumn('action-js', function ($data) {
            //         $btn = '<a class="btn btn-xs btn-danger invoice_btn" href="' . asset("$data->invoice_file") . '" download=""><i class="fa fa-download" aria-hidden="true"></i>
            //          Invoice</a>';
            //         return $btn;
            //     })
            //     ->addColumn('month_year', function ($data) {
            //         $strtotimedata = strtotime($data->month_year);
            //         $month_year = date("M - Y", $strtotimedata);
            //         return $month_year;
            //     })



            //     ->rawColumns(['month_year', 'action-js'])


            //     ->make(true);


              $data =   \App\Models\VendorMonthlyInvoices::where('vendor_id','=',\Auth::guard('vendor')->user()->id)->orderBy('id','desc')->get();
              return  Datatables::of($data)->addIndexColumn()
              ->addColumn('action-js', function ($data) {
                    $btn = '<a href="'.route('restaurant.mis.print.invoice',$data->id).'" class="btn btn-primary">Download</a>';
                    return $btn;
                })
                ->addColumn('month_year', function ($data) {
                    return $month_name = date("F", mktime(0, 0, 0, $data->month, 10)).'-'.$data->year;
                })
                ->rawColumns(['month_year', 'action-js'])


                ->make(true);

        }
   
    }
    public function download_recipt($id)
    {
        $adminDetail = \App\Models\AdminMasters::select('admin_masters.email', 'admin_masters.phone', 'admin_masters.suport_phone', 'admin_masters.office_addres', 'admin_masters.gstno')->first();
        $vendorData =  Vendors::find(Auth::guard('vendor')->user()->id);
        $payout = Vendor_payout_detail::where('vendor_payout_details.id', $id)->join('vendor_order_statements','vendor_payout_details.vendor_order_statements','=','vendor_order_statements.id')->select('vendor_payout_details.*','vendor_order_statements.start_date','vendor_order_statements.end_date','vendor_cancel_deduction')->first();
        $pdf = PDF::loadView('vendor.restaurant.invoices.payout_recipt',  compact('adminDetail', 'vendorData', 'payout'));
        return $pdf->download('settlement_receipt_'.$id.'.pdf');
    }
    
     function print_invoice($id) {
        $invoice = \App\Models\VendorMonthlyInvoices::where('id','=',$id)->first();
        $vendorDetail = Vendors::find($invoice->vendor_id);
        $vendorData =$vendorDetail;
        $monthYearData =  date("F", mktime(0, 0, 0, $invoice->month, 10)).'-'.$invoice->year;
        $adminDetail = \App\Models\AdminMasters::select('admin_masters.email', 'admin_masters.phone', 'admin_masters.suport_phone', 'admin_masters.office_addres', 'admin_masters.gstno')->first();
        return view('vendor.restaurant.pdf.monthly_invoice',compact('adminDetail', 'vendorDetail','monthYearData','vendorData','invoice'));

        
    }

    


}
