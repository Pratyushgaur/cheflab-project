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
                            <div class="col-md-2">
                                <select name="" id="filter-by-status" onchange="reload_table()" class="form-control">
                                  <option value="">Filter By Status</option>
                                  <option value="pending">Pending</option>
                                  <option value="cancelled_by_customer">Cancelled By Customer</option>
                                  <option value="cancelled_by_vendor">Cancelled By Vendor</option>
                                  <option value="completed">completed</option>
                                  <option value="accept">Accept</option>
                                  <option value="payment_pending">Payment Pending</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-2">
                                <select name="" id="filter-by-role" onchange="reload_table()" class="form-control">
                                  <option value="">Filter By Role</option>
                                  <option value="restaurant">Restaurant</option>
                                  <option value="chef">Chef</option>
                                </select>
                            </div> -->
                            <div class="col-md-2">
                                <select name="" id="filter-by-vendor" onchange="reload_table()" class="form-control">
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
                      <h3 class="card-title">List of All Vendors Dineount Order </h3>
                      
                      
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
                                    <th>No Of Guest</th>
                                    <th>From</th>
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
            url:"{{ route('admin.order.dineoutdata') }}",
            data: function (d) {
                d.status = $('#filter-by-status').val(),
                d.role = $('#filter-by-role').val(),
                d.vendor = $('#filter-by-vendor').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id'},
            {data: 'vendor_name', name: 'vendor_name'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'booking_status', name: 'booking_status'},
            {data: 'booked_no_guest', name: 'booked_no_guest'},
            {data: 'booked_slot_time_from', name: 'booked_slot_time_from'},
            {data: 'date', name: 'created_at'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
  }
  $('#filter-by-role').change(function(){
    $.ajax({
      method:"GET",
      action:"{{route('admin.vendor.byRole')}}",
      data:{
        role:$(this).val()
      },
      success:function(){

      }
    })
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