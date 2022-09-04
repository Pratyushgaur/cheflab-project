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
                      <h3 class="card-title">Listing of Registered Restaurant And Chef </h3>
                      
                      
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
            {data: 'status', name: 'status',orderable: false, searchable: false},
            {data: 'image', name: 'image',orderable: false, searchable: false},
            {data: 'wallet', name: 'wallet'},
            {data: 'date', name: 'created_at'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection