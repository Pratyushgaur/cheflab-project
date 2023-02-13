<!DOCTYPE html>
<html>

<head>
   <title>Order Invoice</title>
   <style type="text/css">
      .invoice_logo {
         width: 300px;
      }

      .table-condensed {
         /*border: 1px solid #656565;*/
         width: 100%;
         font-size: 10px;
      }

      .table-condensed .tableRow td {
         border: 1px solid #656565;
         padding-left: 6px;
      }

      .invoice-title {
         /* width: 100%; */
         /* float: left; */
      }

      .invoice-title .invoice_logo {
         /* width: 50%; */
         /* float: left; */
      }

      .invoice_body {
         max-width: 1000px;
         margin: 0 auto;
         background: white;
         padding: 22px;
         border-radius: 5px;
         font-family: sans-serif;
      }

      .invoice_info p {
         margin: 0px 0px 20px 0px;
      }

      .billingDetails h4,
      .billingDetails p,
      .billingDetails_1 p,
      .billingDetails_1 h4 {
         margin: 3px 0px;
         font-size: 10px;
         line-height: 13px;
      }

      .address {
         width: 100%;
         /* clear: both; */
      }

      .invoice_info {
         text-align: right;
         /* width: 47%; */
         /* float: right; */
         font-size: 10px;
      }

      .billingDetails_1,
      .invoice_info {
         text-align: right;
         /* width: 55%; */
         /* float: right; */
         font-size: 10px;
      }

      .Registration {
         margin-top: 38px;
      }

      address.pancard p,
      .Ordernumber p,
      .private p,
      .invoice_logo h6 {
         margin: 0px;
      }

      .shopping_1 {
         margin: 5px 0px 8px 0px;
      }

      .Order {
         margin-top: 28px;
         width: 100%;
      }

      .billingDetails,
      .billingDetails_1 {
         margin-top: 10px;
      }

      .shoppingaddress {
         margin-top: 7px;
      }

      .shopping {
         margin: 10px 0px 22px 0px;
      }

      .tableheading td {
         padding: 4px !important;
      }

      .text-center {
         text-align: center;
      }

      .text-right {
         text-align: right;
      }

      .Signatory {
         margin-top: 45px;
         display: block;
      }

      .private td {
         padding: 5px;
      }

      .Amount td {
         padding: 4px;
      }

      .tax_invoice {
         text-align: center;
      }

      .heading_invoice h5 {
         margin: 0;
      }

      .heading_invoice {
         /* width: 92%; */
         /* float: left; */
      }

      /* .heading_invoice {
    width: 88%;
    float: left;
}
.logo_image {
    width: 12%;
    float: right;
} */
      .address_box p,
      .work_description p {
         margin: 0;
         line-height: 12px;
         font-weight: 500;
         font-size: 13px;
      }

      .table-responsive {
         font-family: serif;
      }

      .theading tr td {
         line-height: 13px;
      }

      tr td,
      tr th {
         font-size: 12px;
         line-height: 14px;
      }

      .amount_english p {
         font-size: 11px;
         margin-bottom: 10px;
      }

      .authorized_box b {
         font-size: 11px;
         font-family: system-ui;
      }

      .authorized_box {
         margin-top: 20px;
      }

      p {
         font-family: system-ui;
      }

      .invoice_address p {
         font-size: 12px;
      }

      .inner_invoice {
         padding-left: 6px;
         padding-bottom: 5px;
      }

      .sign_box p {
         font-size: 11px;
      }
   </style>
</head>

<body>
   <div>
      <div class="invoice_body">
         <table style="width: 100%;">
            <tbody>
               <tr>
                  <td>
                     <div class="invoice-title">
                        <div class="invoice_logo">
                           <h6 style="font-size:11px;"><img src="http://cheflab.local.com/commonarea/logo1.png" style="width:100px;"> </h6>
                        </div>

                     </div>
                  </td>

               </tr>
               <tr>
                  <td>

                     <div class="tax_invoice">
                        <div class="heading_invoice">
                           <div class="inner_invoice">
                              <h4 style="font-size:18px;margin: 0;line-height: 33px;">TAX INVOICE </h4>
                              <p style="font-size:14px;margin: 15px 0;">ChefLab</p>
                              <h5 style="font-size:13px;margin-top:12px;text-transform: uppercase;text-align: left;">(operated by Chotu 18 Services PVT LTD) </h5>
                           </div>
                        </div>

                     </div>
                  </td>
               </tr>
            </tbody>
         </table>
         <?php
         $currentDate = date('Y-m-d');
         $invoiceNo = rand(99999, 999999);
         ?>

         <div class="user_detail">
            <table style="width:100%;">
               <tr>
                  <td style="width:50%;">
                     <table>
                        <tr>
                           <td><b>Restaurant Name:</b> {{ $vendor->name }}</td>
                        </tr>
                        <tr>                          
                           <td><b>Restaurant Address:</b> {{ $vendor->address }}</td>                           
                        </tr>
                        <tr>                         
                           <td><b> Restaurant GST No.:</b> {{ $vendor->gst_no }}  </td>
                        </tr>
                        <tr>
                           <td><b>Restaurant FSSAI License No:</b> {{ $vendor->fssai_lic_no }}</td>
                        </tr>
                        <tr>
                           <td><b>Restaurant Contact:</b> {{ $vendor->mobile }}</td>
                        </tr>
                        <tr>
                           <td><b>Restaurant Email:</b> {{ $vendor->email }}</td>
                        </tr>
                     </table>
                  </td>
                  <td style="width:50%;">
                     <table>
                        <!-- <tr>
                           <td><b>CIN:</b> U93030DL2010PTC198141</td>
                        </tr> -->
                        <tr>
                           <td><b>Invoice No:</b> {{ $invoiceNumber }}</td>
                        </tr>
                        <tr>
                           <td><b>Date:</b> {{ $currentDate }}</td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </div>
         <div class="merchant_detail" style="margin-top:0px;">
            <table style="width:100%;">
               <tr>
                  <td style="width:50%;">
                     <table>
                        <tr>
                           <td><b>Customer Details</b></td>
                        </tr>
                        <tr>
                           <td><b>Customer Name:</b>  {{ $users->name }}</td>
                        </tr>
                        <!-- <tr>
                           <td><b>Merchant ID:</b> 146926 </td>
                        </tr> -->
                        <tr>
                           <td><b>Delivery Address:</b> {{ $order->delivery_address }}</td>
                        </tr>
                        <tr>
                           <td><b>Contact Number:</b> {{ $users->mobile_number }}</td>
                        </tr>
                     </table>
                  </td>
                  <td style="width:50%;">
                     <table>
                     <thead>
                            <tr>
                                <th class="initial-38-6">S.No.</th>
                                <th class="initial-38-6">Description</th>
                                <th class="initial-38-7">Quantity</th>
                                <th class="initial-38-7">Rate</th>
                                <th class="initial-38-7">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($orderProduct as $val) { ?>
                                <tr>
                                    <td class="">
                                    <?php echo $i; ?>
                                    </td>
                                    <td class="">
                                    {{$val['product_name']}}
                                    </td>
                                    <td class="">
                                        {{$val['product_qty']}} <br>
                                    </td>
                                    <td class="w-28p">
                                        {{ $val['product_price'] }}
                                    </td>
                                    <td class="w-28p">
                                    <?php echo ($val['product_qty'] * $val['product_price']); ?>
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                     </table>
                  </td>
               </tr>
            </table>
         </div>
         <div class="sevice_detail" style="margin-top:0px;">
            <table style="width:100%;">
               <tr>
                  <td style="width:50%;">
                     <table>
                       
                        <tr>
                           <td style="padding-top:5px;"><b>Tax (SGST : {{$vendor->tax/2}} % , CGST : {{$vendor->tax/2}} %)</b></td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Item Subtotal : </b>{{ $order->total_amount }}</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Platform Fee : </b>{{ $order->platform_charges }}</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Delivery Charges : </b>{{ $order->delivery_charge }}</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Total Amount : </b>{{ $order->net_amount }}</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Discount (if any) :</b>{{ $order->discount_amount }}</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Net Amount : </b>{{ $netTotalAmount }}</td>
                        </tr>

                        <tr>
                           <td style="padding-top:5px;"><b>Company Address : </b>{{ $adminDetail->office_addres }}</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>GST No. : </b>{{ $adminDetail->gstno }}</td>
                        </tr>

                     </table>
                  </td>
                  <td style="width:50%;">
                     <table>

                     </table>
                  </td>
               </tr>
            </table>
         </div>
         
      </div>
</body>

</html>