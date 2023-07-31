@extends('admin.layouts.layoute')
@section('content')
<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">

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

                            <div class="col-md-3">
                              <select name="" id="select_year" class="form-control" onChange="getWeekDetailByYearMonth();">
                                <option value="">Select Year</option>
                                <?php 
                                  for($i=2023;$i <= 2030; $i++){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-2">
                              <select name="" id="filter-by-month" class="form-control" onChange="getWeekDetailByYearMonth();">
                                  <option value="">Select Month</option>
                                  <option value="01">Jan</option>
                                  <option value="02">Feb</option>
                                  <option value="03">March</option>
                                  <option value="04">April</option>
                                  <option value="05">May</option>
                                  <option value="06">Jun</option>
                                  <option value="07">July</option>
                                  <option value="08">Aug</option>
                                  <option value="09">Sep</option>
                                  <option value="10">Oct</option>
                                  <option value="11">Nov</option>
                                  <option value="12">Dec</option>
                                  
                                </select>  
                            </div>
                            <div class="col-md-4">
                              <select name="" id="filter-by-week" class="form-control">
                                  <option value="">Select Week</option>
                                  
                                  
                                </select>  
                            </div>
                            <div class="col-md-2">
                              <button type="button" onClick="getSearchView();" class="btn btn-primary">Search</button>
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
                      <h3 class="card-title">Account Vendor</h3>
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
                                    <th>Vendor Name</th>
                                    <th>Vendor Amount</th>
                                    <!-- <th>Vendor’s Bank Name</th>
                                    <th>Vendor’s Bank Account Name</th>
                                    <th>Bank Account Number</th>
                                    <th>IFSC Code </th> -->
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


<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script> -->
<link href="{{ asset('js/bootstrap-datepicker3.css') }}" rel="stylesheet"> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
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
          { extend: 'excel', className: 'btn-info',title: 'Account-vendor' }
        ],
        processing: true,
        serverSide: true,
        // buttons: true,
        ajax:{
            url:"{{ route('admin.account.vendor.data') }}",
            data: function (d) {
                d.week = $('#filter-by-week').val()
            }
        },
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'total', name: 'total'},
            // {data: 'bank_name', name: 'bank_name'},
            // {data: 'holder_name', name: 'holder_name'},
            // {data: 'account_no', name: 'account_no'},
            // {data: 'ifsc', name: 'ifsc'},
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

  ;

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
  function getWeekDetailByYearMonth(){
    var month = $("#filter-by-month").val();
    var year = $("#select_year").val();
    if(month!='' && year!=""){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          url: "{{route('admin.account.mis.getWeek')}}",
          type: 'POST',
          data: {
              "month": month,
              "year": year
          },
          success: function (response)
          {
              $("#filter-by-week").html(response);
          },
          error: function(xhr) {
          console.log(xhr.responseText); 
          
        }
      });
    }
  }

  

 </script>
 <style>
  th {
    white-space: nowrap;
}


 </style>




@endsection