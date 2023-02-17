<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\Product_master;
use App\Models\MonthlyInvoice;
use App\Models\AdminMasters;
use App\Models\Vendors;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use PDF;

class CronController extends Controller
{
    public function index()
    {

        $month = gmdate("m", strtotime("last month"));
        $year = gmdate("Y");
        $monthYear = $year . "-" . $month . "-01";
        $strtotimedata = strtotime($monthYear);
        $monthYearData = date("M - Y", $strtotimedata);

        $vendorDatas = Vendors::get();

        foreach ($vendorDatas as $vendorData) {

            $checkData = MonthlyInvoice::where(['vendor_id' => 36])->whereMonth('month_year', '=', $month)->whereYear('month_year', '=', $year)->first();

            if ($checkData) {
                return true;
            } else {
                $totalAmount = Orders::where(['vendor_id' => $vendorData->id, 'order_status' => "dispatched"])->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', $year)->get()->sum('total_amount');

                $adminDetail = AdminMasters::select('admin_masters.email', 'admin_masters.phone', 'admin_masters.suport_phone', 'admin_masters.office_addres', 'admin_masters.gstno')->first();
                $commission = ($totalAmount * $vendorData->commission) / 100;

                $sgst = ($totalAmount * 9) / 100;
                $cgst = ($totalAmount * 9) / 100;
                $invoiceNo = rand(99999, 999999);

                $totalAdminCommission = $commission + $sgst + $cgst;

                $invoiceName = rand(9999, 99999) . $vendorData->id . '.pdf';
                $pdf = \PDF::chunkLoadView('<html-separator/>', 'admin.pdf.monthly_invoice', compact('adminDetail', 'vendorData', 'commission', 'sgst', 'cgst', 'totalAdminCommission', 'monthYear', 'invoiceNo','monthYearData'));

                $pdf->save(public_path('uploads/invoices/' . $invoiceName));
                $url = 'uploads/invoices/' . $invoiceName;

                $pdfData = new MonthlyInvoice;
                $pdfData->vendor_id = $vendorData->id;
                $pdfData->invoice_number = $invoiceNo;
                $pdfData->invoice_file = $url;
                $pdfData->total_amount = $totalAdminCommission;
                $pdfData->month_year = $monthYear;
                $pdfData->save();
            }
        }
    }
}