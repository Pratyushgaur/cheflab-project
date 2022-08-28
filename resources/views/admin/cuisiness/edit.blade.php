@extends('admin.layouts.layoute')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Category</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-4">
        <form id="restaurant-form" action="" method="post" enctype="multipart/form-data">
          @csrf	
          <div class="card card-primary">
							<div class="card-header">
							  <h3 class="card-title">General</h3>

							  <div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								  <i class="fas fa-minus"></i></button>
							  </div>
							</div>
							<div class="card-body">
							  <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" id="name" value="{{$city_data->name}}" name="name" class="form-control" placeholder="Category Name">
							  </div>
                <div class="form-group">
                    <div>
                        <label for="">Category Images</label>
                    </div>
                    <div class="image-upload">
                        <label for="file-input">
                            <div class="upload-icon">
                                <img class="icon" src="{{asset('categories').'/'.$city_data->categoryImage}}"  style="width:75px;height:50px;">
                            </div>
                        </label>
                        <input id="file-input" type="file" name="categoryImage" required/>
                        <input type="hidden" name="admin_image_old" id="admin_image_old" value="{{ !empty($categoryImage[0]->categoryImage) ? $category_data[0]->categoryImage : '' }}" class="form-control">
                    </div>        
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
            <div class="card-header">
              <h3 class="card-title">Files</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Vendor Name</th>
                                    <th  >Image</th>
                                  
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
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

  <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script>
   $(document).ready(function() {
    
    $("#restaurant-form").validate({
        rules: {
            name: {
                required: true,
                maxlength: 20,
            }
            
            
        },
        messages: {
            name: {
                required: "Name is required",
                maxlength: "First name cannot be more than 20 characters"
            }
            
        }
    });


    $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
      $('#file-input2').change( function(event) {
          $("img.icon2").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon2").parents('.upload-icon2').addClass('has-img2');
      });
</script>
<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.category.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'categoryImage', name: 'categoryImage'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection