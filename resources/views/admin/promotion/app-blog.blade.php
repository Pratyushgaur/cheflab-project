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
                  <h1>Add Application Blog </h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Add Application Blog r</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">

              <div class="col-md-4">
                <form id="banner-form" action="{{route('admin.application.blog.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                          <h3 class="card-title">Add Sponsored Blog on Application </h3>

                          <div class="card-tools">
                          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                          </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="blog_position">Blog Position <span class="text-danger">*</span></label>
                                <select name="position" class="form-control" id="blog_position">
                                  <option value="1">Restaurant</option>
                                  <option value="2">Chef</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="blog_type">Shop type <span class="text-danger">*</span></label>
                                <select name="blog_type" class="form-control" id="blog_type">
                                  <option value="1">Vendor</option>
                                  <option value="2">Product</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Name of Blog <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name"  class="form-control" placeholder="Name of Blog">

                            </div>
{{--                            <div class="form-group">--}}
{{--                                <label for="name">Blog Duration <span class="text-danger">*</span></label>--}}
{{--                                <select name="duration" id="custimization" name="customizable" class="form-control">--}}
{{--                                  <option value="1">fullday</option>--}}
{{--                                  <option value="2">custom</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
                            <div class="col-md-12 mb-3 custmization-block" style="">
                            <div class="row">
                            <div class="form-group">
                              <label>Start Time:</label>

                              <div class="input-group date" id="timepicker" data-target-input="nearest">
                                <input type="text" name="from" class="form-control datetimepicker-input" data-target="#timepicker"/>
                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                                </div>
                              <!-- /.input group -->
                            </div>
                            <div class="form-group">
                              <label>End Time:</label>

                              <div class="input-group date" id="timepicker2" data-target-input="nearest">
                                <input type="text" name="to" class="form-control datetimepicker-input" data-target="#timepicker2"/>
                                  <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i>
                                    </div>
                                  </div>
                              </div>
                              <!-- /.input group -->
                            </div>
                              </div>
                           </div>
                            <input type="submit" value="Save Changes" class="btn btn-success float-right">

                        </div>

                      </div>
                      <div>


                    </div>
                </form>
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
                                          <th >Name of Blog</th>
                                          <th >Blog Position</th>
                                          <th >Blog For</th>
                                          <th >Status</th>
                                          <th >Action</th>
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
   (function($) {
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('admin.vendorstore.data')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'vendor_type', name: 'vendor_type'},
            {data: 'blog_type', name: 'blog_type'},
            {data: 'status', name: 'status',orderable: false, searchable: false},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#banner-form").validate({
      rules: {
            blog_position: {
                required: true
            },
            blog_type: {
                required: true
            },
            name:{
              required: true,
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
      // $('.custmization-block').hide();
      // $('#custimization').change(function(){
      //   if ($(this).val()  == '2') {
      //     $('.custmization-block').show();
      //   } else {
      //     $('.custmization-block').hide();
      //   }
      // })
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
  })(jQuery);
 </script>
@endsection
