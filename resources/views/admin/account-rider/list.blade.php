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
                      <form id="member_filter" enctype="multipart/form-data"> 
                          <div class="row">
                        
                            <div class="col-md-4">
                              <input type="hidden" class="form-control" name="datePicker" id="datePicker"  placeholder="Date" required value="" autocomplete="off" >
                                <div   id="reportrange"  style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                  <i class="fa fa-calendar"></i>&nbsp;
                                  <span >{{ date('F D, Y') }}</span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                           
                            <div class="col-md-3" id="filter_yester" style="display:none;">
                                <input type="date" class="form-con">
                            </div>
                            <div class="col-3 mt-0 mb-3">
                                <div class="exportbtn text-end d-flex">
                                  <!-- <button type="submit" class="me-2 btn btn-info text-white rounded-0 px-4 py-2">
                                  Apply
                                  </button> -->
                                  <button type="button" onclick="getSearchView();" class="me-2 btn btn-info text-white rounded-0 px-4 py-2">Apply</button>
                                  &nbsp;
                                           <button type="button" class="btn btn-info text-white rounded-0 px-4 py-2" class="clearbtn" onclick="clearfilter()">
                                          Clear
                                          </button>
                                </div>
                            </div>              
                            </div>
                          </div>
                        </form>
                          
                      
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header card-header d-flex justify-content-between clear-both">
                      <h3 class="card-title">Account Rider</h3>
                      <!-- <a href="javascript:void(0);" id="ExportReporttoExcel" class=" me-2 btn btn-info text-white rounded-0 px-4 py-2">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>              
                        My new button
                      </a> -->
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th class="text-center">S. No.</th>
                                    <th>Rider Name</th>
                                    <th>Id</th>
                                    <th>Rider Amount</th>
                                    <th>Rider Bank Name</th>
                                    <th>Rider Bank Account Name</th>
                                    <th>Bank Account Number</th>
                                    <th>IFSC Code </th>
                                    <th>Start Date - H:M:S</th>
                                    <th>End Date - H:M:S </th>
                                    <th>UTR</th>
                                    <th>Payment Date - H:M:S</th>
                                    <th>Status </th>
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

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script> -->
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

$(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('#datePicker').val(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);
 
});




  // $(function () {
    let table = $('#example').dataTable({        
       
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excel', className: 'btn-info',title: 'Account-rider' }
        ],
        processing: true,
        serverSide: true,
        // buttons: true,
        ajax:{
            url:"{{ route('admin.account.rider.data') }}",
            data: function (d) {
                d.status = $('#filter-by-status').val(),
                d.role = $('#filter-by-role').val(),
                d.vendor = $('#filter-by-vendor').val()
                d.datePicker = $('#datePicker').val()
            }
        },
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'name', name: 'name'},
          {data: 'boy_id', name: 'boy_id'},
            {data: 'paid_amount', name: 'paid_amount'},
            {data: 'bank_name', name: 'bank_name'},
            {data: 'holder_name', name: 'holder_name'},
            {data: 'account_no', name: 'account_no'},
            {data: 'ifsc', name: 'ifsc'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'bank_utr_number', name: 'bank_utr_number'},
            {data: 'payment_success_date', name: 'payment_success_date'},
            {data: 'status', name: 'status'},
        ]
    });
    // table.buttons().container()
        // .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  // });

  

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
  }

  function getSearchView(){
    table.DataTable().ajax.reload(null, false);
   } 

   function clearfilter(){
   $('#datePicker').val('');
   $('#member_filter')[0].reset();
   table.DataTable().ajax.reload(null, false);
  }

  

 </script>
 <style>
  th {
    white-space: nowrap;
}
 </style>
@endsection