@extends('admin.layouts.layoute')
@section('content')


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
                                <select name="" id="filter-by-status" onchange="reload_table()" class="form-control">
                                  <option value="">Filter By Status</option>
                                  <option value="confirmed">Pending</option>
                                  <option value="preparing">Preparing</option>
                                  <option value="ready_to_dispatch">Ready To Dispatch</option>
                                  <option value="dispatched">Dispatched</option>
                                  <option value="cancelled_by_vendor">Cancelled By Vendor</option>
                                  <option value="cancelled_by_customer_before_confirmed">Cancelled By User (With in 30)</option>
                                  <option value="cancelled_by_customer_after_confirmed">Cancelled By User (After in 30)</option>
                                  <option value="cancelled_by_customer_during_prepare">Cancelled By User (After Accept)</option>
                                  <option value="cancelled_by_customer_after_disptch">Cancelled By User (After Dispatched)</option>
                                  <option value="completed">Completed</option>
                                  <!-- <option value="accept">Accept</option>
                                  <option value="payment_pending">Payment Pending</option> -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="filter-by-role" onchange="reload_table()" class="form-control">
                                  <option value="">Filter By Role</option>
                                  <option value="restaurant">Restaurant</option>
                                  <option value="chef">Chef</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="" id="filter-by-vendor" onchange="reload_table()" class="form-control ">
                                  <option value="">Filter By Vendor</option>
                                  
                                </select>
                            </div>
                            
                          </div>
                          
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">List of All Vendors Order </h3>
                      
                      
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th class="text-center">Sr No.</th>
                                    <th>Order-id</th>
                                    <th>Vendor</th>
                                    <th>Customer</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Order Amount</th>
                                    <th>payment Type</th>
                                    <th>Date</th>

                                    <th>Action</th>
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
<script>
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        
        ajax:{
            url:"{{ route('admin.order.data') }}",
            data: function (d) {
                d.status = $('#filter-by-status').val(),
                d.role = $('#filter-by-role').val(),
                d.vendor = $('#filter-by-vendor').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'order_id', name: 'order_id'},
            {data: 'vendor_name', name: 'vendor_name'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'order_status', name: 'status'},
            {data: 'net_amount', name: 'net_amount'},
            {data: 'payment_type', name: 'payment_type'},
            {data: 'date', name: 'created_at'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
  }
  $('#filter-by-role').change(function(){
     
    // $.ajax({
    //   method:"GET",
    //   action:"{{route('admin.vendor.byRole')}}",
    //   data:{
    //     role:$(this).val()
    //   },
    //   success:function(){

    //   }
    // })
    //
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "POST",
        url: '{{route("admin.vendor.byRole")}}', // This is what I have updated
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { "_token": "{{ csrf_token() }}","role":$(this).val() },
        success: function(response){
          
          
          var html = '<option value="">Filter By Vendor</option>';
          for(var i=0;response.length >i; i++){
            html+='<option value="'+response[i].id+'">'+response[i].name+'</option>';
            
          }
          $('#filter-by-vendor').html(html);
        }
      }); 
  })

 </script>
@endsection