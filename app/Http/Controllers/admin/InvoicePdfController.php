<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderProduct;
use App\Models\Product_master;
use App\Models\Vendors;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use PDF;
class InvoicePdfController extends Controller
{
    public function index()
    {
        $id = 15;
        $order = Orders::where('id',$id)->first();
        $vendor = Vendors::findOrFail($order->vendor_id);
        $users = User::findOrFail($order->user_id);
        $orderProduct = OrderProduct::findOrFail($id);
            $product_id = $orderProduct->product_id;
            $product = Product_master::where('id','=',$product_id)->select('id','product_name','product_image','primary_variant_name','product_price','type')->get();

        $invoiceName = rand(9999,99999).$id.'.pdf'; 
        $pdf = PDF::chunkLoadView('<html-separator/>', 'admin.pdf.pdf_document', compact('order','vendor','users','product'));
        $pdf->save(public_path('uploads/invoices/'. $invoiceName));
        $url = 'uploads/invoices/'. $invoiceName;

        $pdfUrl = Orders::where('id', '=', $id)->first();
        $pdfUrl->pdf_url = $url;
        $pdfUrl->save();
        
    }

    
   
}
