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
                                  <option value="">Filter By Role</option>
                                  <option value="1">Accept </option>
                                  <option value="2">Reject</option>
                                  <option value="0">Pending</option>
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
                      <h3 class="card-title">Listing of Banner Request </h3>
                      
                      
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Slot Name</th>
                                    <th >Position</th>
                                    <th  >Price</th>
                                    <th  >Image</th>
                                    <th  >status</th>
                                    <th  >date</th>
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
            {data: 'slot_name', name: 'slot_name'},
            {data: 'position', name: 'position'},
            {data: 'price', name: 'price'},
            {data: 'slot_image', name: 'slot_image',orderable: false, searchable: false},
            {data: 'slot_status', name: 'slot_status'},
            {data: 'date', name: 'date'},
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