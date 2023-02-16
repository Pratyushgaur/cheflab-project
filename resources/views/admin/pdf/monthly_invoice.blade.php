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
                              <p style="font-size:14px;margin: 15px 0;">Original for Recipient</p>
                              <h5 style="font-size:13px;margin-top:12px;text-transform: uppercase;text-align: left;">CHOTU 18 SERVICES PRIVATE LIMITED </h5>
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
                           <td><b>Address:</b> {{ $adminDetail->office_addres }}</td>
                        </tr>
                        <!-- <tr>                          
                           <td><b>PAN:</b> AADCD4946L</td>                           
                        </tr> -->
                        <!-- <tr>                         
                           <td><b>State:</b> Madhya Pradesh  </td>
                        </tr> -->
                        <!-- <tr>
                           <td><b>State Code:</b> 23</td>
                        </tr> -->
                        <tr>
                           <td><b>Invoice No:</b> {{ $invoiceNo }}</td>
                        </tr>
                        <tr>
                           <td><b>Invoice Date:</b> {{ $currentDate }}</td>
                        </tr>
                     </table>
                  </td>
                  <td style="width:50%;">
                     <table>
                        <!-- <tr>
                           <td><b>CIN:</b> U93030DL2010PTC198141</td>
                        </tr> -->
                        <tr>
                           <td><b>GSTIN:</b> {{ $adminDetail->gstno }}</td>
                        </tr>
                        <tr>
                           <td><b>Email:</b> {{ $adminDetail->email }}</td>
                        </tr>
                        <tr>
                           <td><b>Support Contact Number:</b> {{ $adminDetail->suport_phone }}</td>
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
                           <td><b>Merchant Details</b></td>
                        </tr>
                        <!-- <tr>
                           <td><b>Entity Name:</b> {{$vendorData->owner_name}}</td>
                        </tr> -->
                        <!-- <tr>
                           <td><b>Merchant ID:</b> 146926 </td>
                        </tr> -->
                        <tr>
                           <td><b>Trade Name:</b> {{$vendorData->name}}</td>
                        </tr>
                        <tr>
                           <td><b>Address:</b> {{$vendorData->address}}</td>
                        </tr>
                        <tr>
                           <td><b>Email:</b> {{$vendorData->email}}</td>
                        </tr>
                        <tr>
                           <td><b>Contact Number:</b> {{$vendorData->mobile}}</td>
                        </tr>
                     </table>
                  </td>
                  <td style="width:50%;">
                     <table>
                        <!-- <tr>
                           <td><b>State:</b>Madhya Pradesh</td>
                        </tr> -->
                        <!-- <tr>
                           <td><b>Restaurant ID:</b> 18801646</td>
                        </tr> -->
                        <tr>
                           <td><b>Pin Code:</b>{{$vendorData->pincode}}</td>
                        </tr>
                        <tr>
                           <td><b>GSTIN:</b>@if($vendorData->gst_no){{$vendorData->gst_no}} @else Not Registered @endif </td>
                        </tr>
                        <tr>
                           <td><b>FSSAI Licence Number:</b> {{$vendorData->fssai_lic_no}}</td>
                        </tr>
                        <!-- <tr>
                           <td style="padding-top:35px;"><b>Place of supply:</b>Madhya Pradesh (23)</td>
                        </tr> -->
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
                        <!-- <tr>
                           <td style="padding-top:5px;"><b>Service Details</b></td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>HSN Code:</b>998599</td>
                        </tr>
                        <tr>
                           <td style="padding-top:5px;"><b>Service Description:</b> Support Service </td>
                        </tr> -->

                     </table>
                  </td>
                  <td style="width:50%;">
                     <table>

                     </table>
                  </td>
               </tr>
            </table>
         </div>
         <div class="work_description">
            <div class="work_heading" style="margin: 10px 0;">
               <p class="">Work Description: </p>
            </div>
            <table style="width:100%;border-collapse: collapse;" border="1" cellpadding="4">
               <thead>
                  <tr>
                     <th style="padding: 6px 0 3px;">Sr.No</th>
                     <th style="padding: 6px 0 3px;">Particulars</th>
                     <th style="padding: 6px 0 3px;">Amount (Rs.)</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td></td>
                     <td><b>Period: </b> {{ $monthYearData }}</td>
                     <td></td>
                  </tr>
                  <!-- <tr>
                     <td>1</td>
                     <td>Convenience Fee</td>
                     <td>11.12</td>
                  </tr> -->
                  <tr>
                     <td></td>
                     <td>Commission for usage of Cheflab's Online Ordering Platform </td>
                     <td>{{ $commission }}</td>
                  </tr>
                  <tr>
                     <td></td>
                     <td style="text-align: right;">Taxable Amount </td>
                     <td style="text-align: right;">{{ $commission }}</td>
                  </tr>
                  <tr>
                     <td></td>
                     <td style="text-align: right;">SGST @ 9.00%</td>
                     <td style="text-align: right;">{{ $sgst }}</td>
                  </tr>
                  <tr>
                     <td></td>
                     <td style="text-align: right;">CGST @ 9.00%</td>
                     <td style="text-align: right;">{{ $cgst }}</td>
                  </tr>
                  <tr>
                     <td></td>
                     <td style="text-align: right;"><b>Total Amount</b></td>
                     <td style="text-align: right;"><b>{{ $totalAdminCommission }}</b></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="amount_english">
            <!-- <p>Total Amount: Indian Rupee One Hundred Sixty Nine And Ninety Six Paisa only</p> -->
            <p>Amount INR {{ $totalAdminCommission }} settled through digital mode through multiple transactions net payout settlement dated {{ $currentDate }}</p>
         </div>
         
         <div class="invoice_address" style="text-align:center;">
            <p>Communication Address: Flat201,Antilia Sky Luxuria, Antilia2,Nipania Road,Indore - 452010</p>
            <p>This is a computer generated invoice</p>
         </div>
      </div>
</body>

</html>