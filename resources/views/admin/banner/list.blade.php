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
                      <h3 class="card-title">Listing of Slot Booking </h3>
                   </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Slot Name</th>
                                    <th  >Slot</th>
                                    <th  >Image</th>
                                    <th  >Date</th>
                                    <th> Status</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
                    </div>
                  </div>

                </div>
                
              </div>
            </div>
            <div class="modal fade" id="modal-default">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Product Reject Rejoin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <form id="restaurant-form" action="{{route('admin.slot.reject')}}" method="post" enctype="multipart/form-data">
                          @if ($errors->any())
                              @foreach ($errors->all() as $error)
                                  <div class="alert alert-danger">{{$error}}</div>
                              @endforeach
                          @endif
                          @csrf
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Rejoin</label>
                                          <div id="price"></div>
                                          <textarea type="text" name="comment_rejoin" class="form-control"  id="exampleInputEmail1" placeholder="Enter Your Rejoin"></textarea>   
                                         
                                        </div>  
                                    </div>
                                </div>
                            </div>
  
                            <button class="btn btn-primary float-right" type="submit">Submit</button>
                      </form>
                  </div>
                  
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
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
        //ajax: "{{ route('admin.vendors.datatable') }}",
        ajax:{
            url:"{{ route('admin.slotebook.data') }}",
            data: function (d) {
                d.rolename = $('#filter-by-role').val()
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'restaurantName', name: 'restaurantName'},
            {data: 'banner', name: 'banner'},
            {data: 'slot_image', name: 'slot_image',orderable: false, searchable: false},
            {data: 'date', name: 'date'},
            {data: 'slot_status', name: 'slot_status'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });
  $("#restaurant-form").validate({
      rules: {
        comment_rejoin: {
                  required: true,
                //  remote: '{{route("restaurant.slot.checkdate")}}', 
              },
              
        },
          messages: {
            comment_rejoin: {
                  required: "Comment is required"
              },
          }
    });
    $(document).on('click', '.openModal', function () {
        var slot_id = $(this).data('id');
        $('#price').append("<input type='hidden' name='slot_id' value="+slot_id+">");
    });
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection