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
                                <select name="" id="filter-by-role" onchange="reload_table()" class="form-control">
                                  <option value="admin">Admin</option>
                                  <option value="vendor">Vendor</option>
                                </select>
                            </div>
                            <div class="col-md-10">
                                <a href="{{route('admin.coupon.create')}}" class="pull-right btn btn-sm btn-success " style="  color:#fff;"><i class="fa fa-building"> </i> Create Coupon</a>
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
                      <h3 class="card-title">List of Coupons </h3>
                      
                      
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Vendor</th>
                                    <th >Name</th>
                                    <th >Code</th>
                                    <th  >Discount Type</th>
                                    <th  >Discount</th>
                                    <th> Status</th>
                                    <th>Start At</th>
                                    <th>Expire At</th>
                                    <th>Coupon Status</th>
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
        ajax:{
            url:"{{ route('admin.coupon.data') }}",
            data: function (d) {
                d.create_by = $('#filter-by-role').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'vendor_name', name: 'vendor_name' ,orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'discount_type', name: 'discount_type'},
            {data: 'discount', name: 'discount'},
            {data: 'status', name: 'status'},
            {data: 'start_at', name: 'Start At'},
            {data: 'end_at', name: 'Expire At'},
            {data: 'running', name: 'Running'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection