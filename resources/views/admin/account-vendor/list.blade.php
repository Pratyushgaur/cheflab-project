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
                          
                            <div class="col-md-4">
                            <input type="text" class="form-control" name="start_date" value="{{ date('Y-m-d', strtotime('this week')) }} / {{ date('Y-m-d', strtotime('sunday 1 week')) }}" placeholder="" id="datePicker">
                               
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
                                    <th>Vendor’s Bank Name</th>
                                    <th>Vendor’s Bank Account Name</th>
                                    <th>Bank Account Number</th>
                                    <th>IFSC Code </th>
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
  
  var startDate,
        endDate;
        
      $('#datePicker').datepicker({
        autoclose: true,
        format :'yyyy-mm-dd',
        forceParse :false
    }).on("changeDate", function(e) {
        //console.log(e.date);
        var date = e.date;
        startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
        endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
        //$('#datepicker').datepicker("setDate", startDate);
        $('#datePicker').datepicker('update', startDate);
        $('#datePicker').val(startDate.getFullYear() + '-' + (startDate.getMonth() + 1) + '-' + startDate.getDate() + ' / ' + endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' + endDate.getDate());
    });
        
        
       

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
                d.status = $('#filter-by-status').val(),
                d.role = $('#filter-by-role').val(),
                d.vendor = $('#filter-by-vendor').val()
                d.datePicker = $('#datePicker').val()
            }
        },
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'total', name: 'total'},
            {data: 'bank_name', name: 'bank_name'},
            {data: 'holder_name', name: 'holder_name'},
            {data: 'account_no', name: 'account_no'},
            {data: 'ifsc', name: 'ifsc'},
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

  

 </script>
 <style>
  th {
    white-space: nowrap;
}
 </style>
@endsection