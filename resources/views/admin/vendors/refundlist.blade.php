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
          <div class="row">
              <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    <div class="card-body pad table-responsive">
                       
                          <form action="">
                            <div class="row">
                              <div class="form-group col-md-3">
                                  <input type="date" name="from_date" class="form-control" placeholder="From Date" required>
                              </div>
                              <div class="form-group col-md-3">
                                  <input type="date" name="to_date" class="form-control" placeholder="To Date" required  >
                                  
                              </div>
                              <div class="form-group col-md-3">
                                  
                                  <button class="btn btn-sm btn-primary">Submit</button>
                              </div>
                            </div>
                          </form>
                        
                        
                    </div>
                  </div>

                </div>
                
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Listing of Refund  </h3>
                      
                      
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th>Name</th>
                                    <th>Order Id</th>
                                    <th>Amount</th>
                                    <th>created at</th>
                                    <th>Action</th>
                                  </tr>
                            </thead>
                            <tbody>
                              <?php $no=1; ?>
                              @foreach($orders as $key =>$value)
                              <tr>
                                <td>{{$no}}</td>
                                <td>{{$value->customer_name}}</td>
                                <td>{{$value->order_id}}</td>
                                <td>{{$value->net_amount}}</td>
                                <td>{{date('d-m-Y h:i A',strtotime($value->created_at))}}</td>
                                <td>Credited</td>
                              </tr>
                              <?php $no++; ?>
                              @endforeach
                              
                            </tbody>
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
    // let table = $('#example').dataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('admin.deliverboy.datatable') }}",
    //     columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'name', name: 'name'},
    //         {data: 'email', name: 'email'},
    //         {data: 'status', name: 'status',orderable: false, searchable: false},
    //         {data: 'image', name: 'image',orderable: false, searchable: false},
    //         {data: 'wallet', name: 'wallet'},
    //         {data: 'date', name: 'created_at'},
    //         {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
    //     ]
    // });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection