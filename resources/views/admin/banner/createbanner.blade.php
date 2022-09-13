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
            <h1>Create Admin Banner Slote</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create Banner</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-4">
        <form id="banner-form" action="{{route('admin.banner.store')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card card-primary">
							<div class="card-header">
							  <h3 class="card-title">Add Banner Time Slot*</h3>

							  <div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
								  <i class="fas fa-minus"></i></button>
							  </div>
							</div>
							<div class="card-body">
							    <div class="form-group">
                                     <label for="category_name">Slot Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{!empty($class_name[0]->name) ? $class_name[0]->name : ''}}" class="form-control" placeholder="Slot Name">
                                    <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($class_name[0]->id) ? $class_name[0]->id : ''}}">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label>From Time:</label>

                                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                                <input type="text" name="from_time" class="form-control datetimepicker-input" data-target="#timepicker"/>
                                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label>To Time:</label>

                                                <div class="input-group date" id="timepicker1" data-target-input="nearest">
                                                <input type="text" name="to_time" class="form-control datetimepicker-input" data-target="#timepicker1"/>
                                                <div class="input-group-append" data-target="#timepicker1" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="category_name">Max. No. Of Banner <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="max_no_banner" style="width: 100%;" id="timeSlote">
                                        <option selected="selected">Select Number</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group" id="games">
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
              <h3 class="card-title">List</h3>

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
                                    <th >Slot Name</th>
                                    <th >From Time</th>
                                    <th  >To Time</th>
                                    <th  >Created At</th>
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
        ajax: "{{route('admin.slot.data')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'city_name'},
            {data: 'from_time', name: 'from_time'},
            {data: 'to_time', name: 'to_time'},
          //  {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#banner-form").validate({
      rules: {
            name: {
                required: true,
                maxlength: 20,
                remote: '{{route("admin.banner.slotcheck")}}',
            },
            from_time: {
                required: true,
               // remote: '{{route("admin.banner.slotchecktime",)}}',
            },
            to_time :{
              required: true,
              //remote: '{{route("admin.banner.slotchecktime")}}',
            },
            max_no_banner:{
              required: true,
            },
            banner: {
                required: true,
                number: true,
            },
        },
        messages: {
            name: {
                remote:"Name  Already Exist",
            },
            from_time:{
                remote:"Time is  Required",
            },
            to_time:{
                remote:"To Time Required",
            },
            max_no_banner:{
                remote:"Select Max Banner Required",
            },
            banner:{
                remote:"Select Max Banner Required",
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
       //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    });
    $('#timepicker1').datetimepicker({
      format: 'LT'
    });
    $("#timeSlote").change(function() {
        var value = +$(this).val();
        value *= 1;
        var nr = 0;
        var elem = $('#games').empty();
     
        while (nr < value) {
            elem.append($('<label for="category_name"> Banner priority amount <span class="text-danger">*</span></label><input type="text" id="name" name="banner[]" value="{{!empty($class_name[0]->name) ? $class_name[0]->name : ''}}" class="form-control" placeholder="Slot Name"><br>',{name : "whateverNameYouWant"}));
            nr++;
        }
        }); 
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection