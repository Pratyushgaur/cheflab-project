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
                            <div class="col-md-10">
                                <a href="{{route('admin.deliverboy.create')}}" class="pull-right btn btn-sm btn-success " style="  color:#fff;"><i class="fa fa-building"> </i> Create New Deliver Boy</a>
                                <!-- <a href="{{route('admin.chef.create')}}" class="pull-right btn btn-sm btn-success " style=" color:#fff;"><i class="fa fa-search"> </i> Filter</a> -->
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
                      <h3 class="card-title">Listing of Registered Delivery Boy </h3>
                      
                      
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Name</th>
                                    <th  >Email</th>
                                    <th> Status</th>
                                    <th> Image</th>
                                    <th  >Wallet</th>
                                    <th  >Order Delivered</th>
                                    <th  >Order Canceled</th>
                                    <th  >Rating</th>
                                    <th  >created at</th>
                                    <th  >Action</th>
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
        ajax: "{{ route('admin.deliverboy.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {data: 'image', name: 'image',orderable: false, searchable: false},
            {data: 'wallet', name: 'wallet'},
            {data: 'order_delivered', name: 'order_delivered'},
            {data: 'order_calceled', name: 'order_calceled'},
            {data: 'ratings', name: 'ratings'},
            {data: 'date', name: 'created_at'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }




   $(document).on('click','.inactiveVendor',function(){
            Swal.fire({
                title: 'Are you sure To Want To Change Status ',
                text: '',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                var id = $(this).attr('data-id');
                var action = $(this).attr('data-url');
                var table = $(this).attr('data-table');
                //
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: action,
                    type: 'POST',
                    // dataType: "JSON",
                    data: {
                        "vendor_id": $(this).attr('data-id'),
                    },
                    success: function (response)
                    {
                        console.log(response);
                        if (response.success == true) {
                            Swal.fire({icon: 'success',title: 'Good',text: response.message, footer: ''});
                            reload_table();
                        } else {
                            Swal.fire({icon: 'error',title: 'Oops...',text: response.error[0], footer: ''});
                        }
                    },
                    error: function(xhr) {
                    console.log(xhr.responseText); 
                    Swal.fire({icon: 'error',title: 'Oops...',text: 'UNAUTHRIZED USER', footer: ''});
                    
                    }
                });

                }
            })
        })

 </script>
@endsection