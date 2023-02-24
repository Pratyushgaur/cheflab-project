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
      }

      .invoice_info {
         text-align: right;
         font-size: 10px;
      }

      .billingDetails_1,
      .invoice_info {
         text-align: right;
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

      .address {
         list-style: none;
         text-align: left;
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
                           <h6 style="font-size:11px;"><img src="{{asset('commonarea/logo.png')}}" style="width:100px;"> </h6>
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
                           <td><b>Restaurant Name-</b></td>
                        </tr>
                        <tr>
                           <td style="padding-top: 5px;"><b> Name:</b> {{ $vendor->name }}</td>
                        </tr>
                        <tr>
                           <td><b>Address:</b> {{ $vendor->address }}</td>
                        </tr>
                        <tr>
                           <td><b> GST No.:</b> {{ $vendor->gst_no }} </td>
                        </tr>
                        <tr>
                           <td><b> FSSAI License No:</b> {{ $vendor->fssai_lic_no }}</td>
                        </tr>
                        <tr>
                           <td><b> Contact:</b> {{ $vendor->mobile }}</td>
                        </tr>
                        <tr>
                           <td><b> Email:</b> {{ $vendor->email }}</td>
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
                           <td><b>Customer Details-</b></td>
                        </tr>
                        <tr>
                           <td style="padding-top: 5px;"><b>Customer Name:</b> {{ $users->name }}</td>
                        </tr>
                        <tr>
                           <td><b>Delivery Address:</b> {{ $order->delivery_address }}</td>
                        </tr>
                        <tr>
                           <td><b>Contact Number:</b> {{ $users->mobile_number }}</td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </div>
         <div class="sevice_detail" style="margin-top:0px;">
            <table class="order_table" cellpadding="5" border="1" style="width:100%;margin-top: 20px;border-collapse: collapse;">
               <thead>
               <tr>
                  <th>S.No.</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Rate</th>
                  <th>Price</th>
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
                  <?php $i++;
                  } ?>

                  <tr>
                     <td></td>
                     <td colspan="2" style="text-align:right;padding-right:20px;"><b>Tax:</b></td>
                     <td><b>SGST: {{$vendor->tax/2}} %</b></td>
                     <td>{{ $taxAmount }}</td>


                  </tr>

                  <tr>

                     <td></td>
                     <td colspan="2"></td>
                     <td><b>CGST: {{$vendor->tax/2}} %</b></td>
                     <td>{{ $taxAmount }}</td>


                  </tr>

                  <tr>
                     <td></td>
                     <td colspan="3" style="text-align:right;padding-right:20px;"><b>Item Subtotal:</b></td>
                     <td>{{ $order->total_amount }} </td>


                  </tr>
                  <tr>
                     <td></td>
                     <td colspan="3" style="text-align:right;padding-right:20px;"><b>Platform Fee: </b></td>
                     <td>{{ $order->platform_charges }}</td>

                  </tr>
                  <tr>
                     <td></td>
                     <td colspan="3" style="text-align:right;padding-right:20px;"><b>Delivery Charges :</b></td>
                     <td>{{ $order->delivery_charge }}</td>

                  </tr>
                  <tr>
                     <td></td>
                     <td colspan="3" style="text-align:right;padding-right:20px;"><b>Discount (if any):</b></td>
                     <td>{{ $order->discount_amount }}</td>

                  </tr>
                  <tr>
                     <td></td>
                     <td colspan="3" style="text-align:right;padding-right:20px;"><b>Total Amount :</b></td>
                     <td>{{ $order->net_amount }}</td>

                  </tr>
               </tbody>

            </table>
            <div class="user_detail">
               <table style="width: 100%; margin-top:10px;">
                  <tbody>
                     <tr>
                        <td><b>Company Address : </b>{{ $adminDetail->office_addres }} </td>
                     </tr>
                     <tr>
                        <td><b>GST No. : </b>{{ $adminDetail->gstno }} </td>
                        </tr>
                        <tr>
                        <td><b>CIN : </b>{{ $adminDetail->cin_no }}</td>
                        </tr>
                        <tr>
                        <td><b>FSSAI : </b>{{ $adminDetail->fssai_no }}</td>
                     </tr>
                  </tbody>
               </table>
               <div>
                  <p>*This is computer generated invoice.</p>
               </div>
            </div>
         </div>

      </div>
</body>

</html>