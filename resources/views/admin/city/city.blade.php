@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
</style>
@endsection('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create City</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create City</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-4">
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
								<label for="city_name">City</label>
								<input type="text" id="city_name" name="city_name" class="form-control" placeholder="City Name">
								<input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($city_data[0]->id) ? $city_data[0]->id : ''}}">
							  </div>
							</div>
							<!-- /.card-body -->
						</div>
						<div>
						
						  <input type="submit" value="Save Changes" class="btn btn-success float-right">
						</div>
					</form>
				  <!-- /.card -->
				</div>
				<div class="card card-info col-md-8">
				<div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Files</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body p-0">
               <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>City Name</th>
					          <th>Created at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                   
                  
                     

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
		  </div>
          <!-- /.card -->
		</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->
<!-- /.row -->
@endsection


@section('js_section')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
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
    $("#cityForm").validate({
          rules: {
            city_name: {
                  required: true,
                  maxlength: 25,
                  remote: '{{route("check-duplicate-city")}}',
              },
              
          },
          messages: {
              city_name:{
                remote:"City Name Already Exist"
              }
              
          }
      });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection