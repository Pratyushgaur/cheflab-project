@extends('admin.layouts.layoute')
@section('content')
<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet"> -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                  <div class="card card-primary card-outline">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-md-3">
                            <input type="date" class="form-control from_date" value="{{date('Y-m-d')}}">
                          </div>
                          <div class="col-md-3">
                            <input type="date" class="form-control to_date" value="{{date('Y-m-d')}}" >
                          </div>
                          <div class="col-md-3">
                            <button class="btn btn-xs btn-success" onclick="reload_table()">Search</button>
                          </div>
                          <!-- <div class="col-md-3">
                            <select name="" id="" class="form-control select2">
                              <option value=""></option>
                            </select>
                          </div>     -->
                        </div>
                      </div>  
                      
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header card-header d-flex justify-content-between clear-both">
                      <h3 class="card-title">MIS  </h3>
                      <!-- <a href="javascript:void(0);" id="ExportReporttoExcel" class=" me-2 btn btn-info text-white rounded-0 px-4 py-2">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>              
                        My new button
                      </a> -->
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th class="text-center">Sr No.</th>
                                    <th>Invoice No. / Order ID</th>
                                    <th>Order Date / Time</th>
                                    <th>User (Customer Name)</th>
                                    <th>Vendor Name</th>
                                    <th>Rider Name & ID</th>
                                    <th>Gross Order Value</th>
                                    <th>Coupon Code</th>
                                    <th>Coupon Amount</th>
                                    <th>Net order value</th>
                                    <th>GST%</th>
                                    <th>GST Rate</th>
                                    <th>Order Value Inc Tax</th>
                                    <th>Delivery Charge</th>
                                    <th>Delivery Charge Tax %</th>
                                    <th>Delivery Charge Tax Amount</th>
                                    <th>Delivery Charges Inc Tax</th>
                                    <th>Platform Charges</th>
                                    <th>Platform Charge Tax %</th>
                                    <th>Platform Charge Tax Amount</th>
                                    <th>Platform Charge Inc Tax</th>
                                    
                                    <th>Order Amount</th>
                                    
                                    
                                    
                                    
                                    
                                    <th>Wallet Cut</th>
                                    <th>Vendor Comission (%)</th>
                                    <th>Vendor Settlement(Final)</th>
                                    <th>Rider Settlement(Final)</th>
                                    <th>Earning from Vendor (to admin)</th> 
                                    <th>Earning from Rider (to admin)</th>
                                    <th>Admin Profit (Gross)</th>
                                  </tr>
                            </thead>
                            
                        </table>
                    </div>
                  </div>

                </div>
                
              </div>
            </div>

          
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
</script>

<script type="text/javascript">

    let table = $('#example').dataTable({        
       dom: 'Bfrtip',
       buttons: [
         { extend: 'excel', className: 'btn-info' }
       ],
       processing: true,
       paging: false,
       serverSide: true,
       lengthChange: true,
       // buttons: true,
       ajax:{
           url:"{{ route('admin.account.order.data') }}",
           data: function (d) {
               d.from = $('.from_date').val(),
               d.todate = $('.to_date').val()
           }
       },
       columns: [
         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           {data: 'order_id', name: 'order_id'},
           {data: 'date', name: 'date'},
           {data: 'name', name: 'name'},
           {data: 'vendor_name', name: 'vendor_name'},
           {data: 'rider_name', name: 'rider_name'},
           {data: 'total_amount', name: 'total_amount'},
           {data: 'code', name: 'code'},
           {data: 'discount_amount', name: 'discount_amount'},
           {data: 'net_order_value', name: 'net_order_value'},
           {data: 'gst_per', name: 'gst_per'},
           {data: 'tex', name: 'tex'},
           {data: 'order_value_inc_tax', name: 'order_value_inc_tax'},
           {data: 'exclusive_delivery_charge', name: 'exclusive_delivery_charge'},
           {data: function(data, type, row){
                  return '18';
           }},
           {data: function(data, type, row){
                  return data.delivery_charge*18/100;
           }},

           {data: 'delivery_charge', name: 'delivery_charge'},
           {data: 'exclusive_platform_charge', name: 'exclusive_platform_charge'},
           {data: function(data, type, row){
                  return '18';
           }},
           {data: function(data, type, row){
                  return data.platform_charges*18/100;
           }},

           {data: 'platform_charges', name: 'platform_charges'},
           //
           {data: 'net_amount', name: 'net_amount'},
          //  {data: 'platform_charges', name: 'platform_charges'},
           
           
           
           {data: 'wallet_cut', name: 'wallet_cut'},
           {data: 'commission', name: 'commission'}, 
           {data: 'vendor_settlement', name: 'vendor_settlement'}, 
           {data: 'rider_earning', name: 'rider_earning'}, 
           {data: 'admin_earning_vendor', name: 'admin_earning_vendor'},
           {data: 'admin_earning_rider', name: 'admin_earning_rider'},
           {data: 'admin_erning', name: 'admin_erning'},
       ]
    });
    function reload_table() {
        table.DataTable().ajax.reload(null, false);
    }
    
  
 </script>
 <style>
  th {
      white-space: nowrap;
  }
  tbody{
    min-height:500px !important;
    overflow:scroll  !important;
  }
 </style>
@endsection