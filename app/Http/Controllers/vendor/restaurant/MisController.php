<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Product_master;
use App\Models\Vendortransition;
use App\Models\OrderCommision;
use App\Models\vendor_payout_detail;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DataTables;
use Illuminate\Http\Request;
use App\Exports\OrderExport;
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
        $order_count = OrderCommision::where('vendor_id', $vendorId)->where('is_approve',1)->count();        
        $additions_count = OrderCommision::where('vendor_id', $vendorId)->sum('additions');
        $deductions = OrderCommision::where('vendor_id', $vendorId)->sum('deductions');
        $net_receivables = OrderCommision::where('vendor_id', $vendorId)->sum('net_receivables');

        return view('vendor.mis.renvenue', compact('order_sum','order_count','additions_count','deductions','net_receivables'));
    } 
    
    public function renvenue_ajax(Request $request)
    {        
       
        $date = explode('/',$request->start_date);
        $start_date = date('Y-m-d',strtotime($date[0]));
        $end_date = date('Y-m-d',strtotime($date[1]));
        
        $vendorId = Auth::guard('vendor')->user()->id;

        $order_sum = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('gross_revenue');
        // echo '<pre>'; print_r($order_sum);die;

        $order_count = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->count();   
            //  echo '<pre>';print_r($order_count);die;
        $additions_count = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('additions');
        $deductions = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('deductions');
        $net_receivables = OrderCommision::where('vendor_id', $vendorId)->whereBetween('order_commisions.order_date', [$start_date, $end_date])->sum('net_receivables');

        $your_settlement = vendor_payout_detail::where('vendor_id', $vendorId)->sum('amount');
// echo '<pre>';print_r($your_settlement);die;
        
        return view('vendor.mis.renvenue_ajax', compact('order_sum','order_count','additions_count','deductions','net_receivables','your_settlement'));
    }
    public function addition_view(Request $request)
    {
        $vendorId = Auth::guard('vendor')->user()->id;
        $additions_count = OrderCommision::where('vendor_id', $vendorId)->sum('additions');
        return view('vendor.mis.addition_view', compact('additions_count'));
    }
    public function deductions_view(Request $request)
    {
        $vendorId = Auth::guard('vendor')->user()->id;
        $admin_amount = OrderCommision::where('vendor_id', $vendorId)->sum('admin_amount');
        $tax_amount = OrderCommision::where('vendor_id', $vendorId)->sum('tax_amount');
        $convenience_amount = OrderCommision::where('vendor_id', $vendorId)->sum('convenience_amount');
        $net_amount = OrderCommision::where('vendor_id', $vendorId)->sum('deductions');
        
        return view('vendor.mis.deductions_view', compact('admin_amount','tax_amount','convenience_amount','net_amount'));
    }

    
    
     public function order_list()
    {
        return view('vendor.mis.order_list');
    }
    public function order_data(Request $request)
    { 
        
        if ($request->ajax()) {
        
            $data = OrderCommision::where('orders.vendor_id', $request->vendorId)->join('orders','order_commisions.order_id','=','orders.id')->select('order_commisions.*','orders.payment_type','orders.payment_status');

       
            $dateSedule = $request->datePicker;
         
            if(isset($dateSedule)){
            $packagetime = explode('/', $dateSedule);
            $start_time = $packagetime[0];
            $end_time = $packagetime[1];
            }
 
            if(!empty($start_time) && !empty($end_time)) {
             $data = $data->whereBetween('order_commisions.order_date', [$start_time, $end_time]);
            }
     
            
            $data = $data->get();
            // echo '<pre>';print_r($data);die;
             return Datatables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action-js', function($data){
                    $btn = '<a href="'. route("restaurant.mis.order.view",$data->id) .'"><i class="fa fa-eye"></i></a> ';
                    
                    return $btn;
                })
                ->addColumn('status', function($data){
                    if ($data->is_approve == 1) {
                        $btn = '<span class="text-success">Delivered</span>';
                    } elseif($data->is_cancel == 1) {
                        $btn = '<span class="text-danger">Cancel</span>';
                    }
                    return $btn;
                })
                
 
                
                 ->rawColumns(['status','action-js']) 
                
                 
                ->make(true);
         }   
    }
    public function order_detail($id)
    {       
        $order = OrderCommision::where('order_commisions.id',$id)->join('orders','order_commisions.order_id','=','orders.id')->select('order_commisions.*','orders.payment_type','orders.payment_status')->first();       
        return view('vendor.mis.order_detail', compact('order'));
       
    }

    public function oredr_export(Request $request)
    {       
       return Excel::download(new OrderExport($request), 'order.xlsx');      
     }

     public function order_invoice()
     {
         $pdf = PDF::loadView('vendor.mis.order_invoice');
         $invoiceName = 'order_'.time().'.pdf';
         $pdf->save(public_path('invoices/'. $invoiceName));
         return $pdf->download('order_invoice.pdf');
     }

     public function settlements_view(Request $request)
    {
        $vendorId = Auth::guard('vendor')->user()->id;
        $settlements_list = vendor_payout_detail::where('vendor_id', $vendorId)->get();
        return view('vendor.mis.settlements_view', compact('settlements_list'));
    }

    // public function settlements_list(Request $request)
    // {
    //    echo "hello";die;
    // }

    
}
