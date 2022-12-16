@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
    
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
        .image-upload{
            display:inline-block;
            margin-right:15px;
            position:relative;
        }
        .image-upload > input
        {
            display: none;
        }
        .upload-icon{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        .upload-icon img{
          width: 100px;
          height: 100px;
          margin:19px;
          cursor: pointer;
        }
        
        
        .upload-icon.has-img {
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon.has-img img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        /*  */
        .upload-icon2{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon2 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon2.has-img2{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon2.has-img2 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
      </style>
@endsection
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create Food Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Food Category</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-12">
        <form id="restaurant-form" action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
          @if ($errors->any())
              @foreach ($errors->all() as $error)
                  <div class="alert alert-danger">{{$error}}</div>
              @endforeach
          @endif
          @csrf
          <div class="card card-primary">
							<div class="card-header">
							  <h3 class="card-title">Create</h3>

							  <div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								  <i class="fas fa-minus"></i></button>
							  </div>
							</div>
							<div class="card-body">
							  <div class="form-group">
                  <label for="category_name">Category Name <span class="text-danger">*</span></label>
                  <input type="text" id="name" name="name" value="{{!empty($class_name[0]->name) ? $class_name[0]->name : ''}}" class="form-control" placeholder="Enter Category">
                  <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($class_name[0]->id) ? $class_name[0]->id : ''}}">
                </div>
                <div class="form-group">
                  <label for="category_name">Position <span class="text-danger">*</span></label>
                  <input type="number" id="position" name="position" value="{{!empty($class_name[0]->position) ? $class_name[0]->position : ''}}" class="form-control" placeholder="Position ">
                  <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($class_name[0]->id) ? $class_name[0]->id : ''}}">
                </div>
                <div class="form-group">
                      <div>
                        <label for="">Images <span class="text-danger">*</span></label>
                      </div>
                      <div class="image-upload">
                          <label for="file-input">
                              <div class="upload-icon">
                                  <img class="icon" src="{{asset('add-image.png')}}">
                              </div>
                          </label>
                          <input id="file-input" type="file" name="categoryImage">
                      </div>      
                </div>
                <span class="product_image_error text-danger"></span>
							</div>
							<!-- /.card-body -->
						</div>
						<div>
						
						  <input type="submit" value="Save Changes" class="btn btn-success float-right">
						</div>
					</form>
				  <!-- /.card -->
				</div>
        <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">

                            <div class="card-header">
                                <h3 class="card-title">Listing of Registered Restaurant And Chef </h3>


                            </div>
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sr No.</th>
                                        <th >Category Name</th>
                                        <th >Position</th>
                                        <th  >Image</th>
                                        <th  >Status</th>
                                        <th  >Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>

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
                                    <th >Category Name</th>
                                    <th >Position</th>
                                    <th  >Image</th>
                                    <th  >No Of Res.</th>
                                    <th  >Status</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
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
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.category.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'city_name'},
            {data: 'position', name: 'position'},
            {data: 'categoryImage', name: 'categoryImage'},
            {data: 'no_of_res', name: 'no_of_res'},
            {data: 'is_active', name: 'is_active'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#restaurant-form").validate({
      rules: {
            name: {
                required: true,
                maxlength: 20,
                remote: '{{route("check-duplicate-category")}}',
            },
            position: {
                required: true,
                number: true,
            },
            categoryImage:{
              required: true,
              image: true,
            }
        },
        messages: {
            name: {
                remote:"Category  Already Exist",
            },
            position:{
                remote:"Position Required",
            },
            categoryImage:{
                remote:"Image Required",
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
@endsection