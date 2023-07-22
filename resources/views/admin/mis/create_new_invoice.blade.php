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
                          <div class="row">
                            <div class="col-md-4">
                              <select name="" id="filter-by-month" class="form-control">
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
                            <div class="col-md-3" id="filter_yester">
                              <select name="" id="filter-by-year" class="form-control">
                                <?php 
                                  for($i=2023;$i <= 2030; $i++){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
                                ?>
                                
                                
                              </select>  
                            </div>
                            <div class="col-3 mt-0 mb-3">
                                <div class="exportbtn text-end d-flex">
                                  <!-- <button type="submit" class="me-2 btn btn-info text-white rounded-0 px-4 py-2">
                                  Apply
                                  </button> -->
                                  <button type="button"  class="search me-2 btn btn-info text-white rounded-0 px-4 py-2">Apply</button>
                                  &nbsp;
                                           
                                </div>
                            </div>
                            <div class="col-2 mt-0 mb-3">
                                <div class=" text-end d-flex">
                                  <!-- <button type="submit" class="me-2 btn btn-info text-white rounded-0 px-4 py-2">
                                  Apply
                                  </button> -->
                                  <button type="button"  class=" me-2 btn btn-info text-white rounded-0 px-4 py-2 generate_invoice">Generate Invoice</button>
                                  &nbsp;
                                           
                                </div>
                            </div>              
                          </div>
                      </div>
                        <form method="post" action="{{route('admin.mis.genrate.bulk.invoice')}}" id="generate_form" style="display:none;">
                        @csrf
                                  <input type="text" class="month" name="month">
                                  <input type="text" class="year" name="year">
                        </form>
                          
                      
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header card-header d-flex justify-content-between clear-both">
                      <h3 class="card-title">Create Monthly Invoice</h3>
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th class="text-center">S. No.</th>
                                    <th>Vendor Name</th>
                                    
                                    <th>Gross Amount</th>
                                    <th>Admin Commision</th>
                                    <th>Tax Admin Commision</th>
                                    <th>Fee</th>
                                    <th>Fee Tax</th>
                                    <th>Final</th>
                                    <th>Action </th>
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
    
    let table = $('#example').dataTable({        
       
       processing: true,
       serverSide: true,
       // buttons: true,
       ajax:{
           url:"{{ route('admin.account.month.invoice') }}",
           data: function (d) {
               d.month = $('#filter-by-month').val(),
               d.year = $('#filter-by-year').val()
           }
       },
       columns: [
         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
           {data: 'name', name: 'name'},
           {data: 'gross_revenue_total', name: 'gross'},
           {data: 'admin_commision_total', name: 'admin_charge'},
           {data: 'tax_on_commission_total', name: 'tax_com'},
           {data: 'convenience_amount_total', name: 'conv_am'},
           {data: 'convenience_tax_total', name: 'conv_am_tx'},
           {data: 'net_receivables_total', name: 'total'},
           
           {data: 'action', name: 'action'},
       ]
   });
   $('.search').click(function(){
      table.DataTable().ajax.reload(null, false);
   })
   $('.generate_invoice').click(function(){
      if(confirm("Are You Sure to Generate Invoice!\nIf Yes then OK or Cancel.")){
        $(".month").val($('#filter-by-month').val());
        $(".year").val($('#filter-by-year').val());
        $('#generate_form').submit();
      }else{

      }

   })
});
 


  // $(function () {
   
    // table.buttons().container()
        // .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  // });

  

  function reload_table() {
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