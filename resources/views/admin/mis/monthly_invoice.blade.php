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
                    
                    <div class="card-header card-header d-flex justify-content-between clear-both">
                      <h3 class="card-title">Generated Monthly Invoice</h3>
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th class="text-center">S. No.</th>
                                    <th>Vendor Name</th>
                                    <th>Year-month</th>
                                    <th>InvoiceNo.</th>
                                    <th>Gross Amount</th>
                                    <th>Vendor Commision</th>
                                    <th>convenience fee</th>
                                    <th>convenience fee gst</th>
                                    <th>final_amount</th>
                                    <th>Generate</th>
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
       
       processing: true,
       serverSide: true,
       // buttons: true,
       ajax:{
           url:"{{ route('admin.account.month.invoice.generated.list') }}",
           data: function (d) {
               d.month = $('#filter-by-month').val(),
               d.year = $('#filter-by-year').val()
           }
       },
       columns: [
         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           {data: 'vendor_name', name: 'name'},
           {data: 'year_mnth', name: 'year_mnth'},
           {data: 'invoice_number', name: 'invoice_number'},
           {data: 'gross_revenue', name: 'gross_revenue'},
           {data: 'vendor_commission', name: 'vendor_commission'},
           {data: 'convenience_fee', name: 'convenience_fee'},
           {data: 'convenience_fee_gst', name: 'convenience_fee_gst'},
           {data: 'final_amount', name: 'final_amount'},
           {data: 'created_at', name: 'created_at'},
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