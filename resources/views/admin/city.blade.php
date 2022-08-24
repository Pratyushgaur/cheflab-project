@extends('admin.layouts.layoute')
@section('content')


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Product</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-6">
          
					<form method="post" id="cityForm" action="{{ route('city.action') }}">
              @csrf
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Add CIty</h3>
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_name">City</label>
                    <input type="text" name="city_name" id="city_name" autocomplete="off" class="form-control" value="{{!empty($city_data[0]->city_name) ? $city_data[0]->city_name : ''}}" placeholder="City Name">
                    <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($city_data[0]->id) ? $city_data[0]->id : ''}}">
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
						<div>
						
            <input type="submit" value="Save Changes" class="btn btn-success float-right">
            <a href=""> <button type="button" class="btn btn-danger cancel-btn"><i class="fa fa-times-circle"></i> Cancel</button></a>
						</div>
					</form>
				  <!-- /.card -->
				</div>
				<div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Files</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="row">
                                    <div class="col-sm-12">
                                       <div class="table-responsive">
                                          <table id="example" class="table table-bordered">
                                             <thead>
                                                   <tr role="row">
                                                      <th width="5%" class="text-center">Sr No.</th>
                                                      <th width="20%">City</th>
                                                      <th width="2%" >created at</th>
                                                      <th width="3%" >Action</th>
                                                   </tr>
                                             </thead>
                                             
                                          </table>
                                        </div>
                                    </div>
                                </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
		</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('city.getDataTable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'city_name', name: 'city_name'},
            {data: 'date', name: 'date'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection