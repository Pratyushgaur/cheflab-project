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
                  <h1>Application Blog </h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Application Blog </li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">

              <div class="col-md-12">
                <form id="banner-form" action="{{route('admin.application.blog.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card card-primary">
                      <div class="card-header"></div>
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
                        <!-- row -->
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">Start Time</label>
                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                  <input type="text" name="from" class="form-control datetimepicker-input" data-target="#timepicker"/>
                                  <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="">End Time</label>
                              <div class="input-group date" id="timepicker2" data-target-input="nearest">
                                <input type="text" name="to" class="form-control datetimepicker-input" data-target="#timepicker2"/>
                                  <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                  </div>
                              </div>
                              
                            </div>
                          </div>
                        </div>
                        <!-- end row -->
                        <div class="form-group">
                            <label for="master_blog">Master Blog <span class="text-danger">*</span> <span>(This option for shown in top of the application)</span></label>
                            <select name="master_blog" class="form-control" id="master_blog">
                              <option value="1">No</option>
                              <option value="0">Yes</option>
                            </select>
                        </div>
                        <div class="row">
                            <h3>First Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="first_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_two_week" name="first_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_month" name="first_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                            

                        </div>
                        <div class="row">
                            <h3>Second Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="second_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_two_week" name="second_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_month" name="second_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Third Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="third_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_two_week" name="third_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_month" name="third_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Fourth Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="fourth_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="fourth_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="fourth_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Fifth Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="fifth_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="fifth_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="fifth_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Sixth Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="sixth_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="sixth_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="sixth_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Seventh Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="seventh_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="seventh_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="seventh_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Eighth Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="eighth_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="eighth_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="eighth_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Ninth Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="ninth_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="ninth_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="ninth_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Tenth Position</h3> <br>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="first_position_price_for_week" name="tenth_position_price_for_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">Two Week  <span class="text-danger">*</span></label>
                                  <input type="number" id="second_position_price_for_week" name="tenth_position_price_for_two_week"  class="form-control" placeholder="">

                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                  <label for="name">One Month <span class="text-danger">*</span></label>
                                  <input type="number" id="third_position_price_for_week" name="tenth_position_price_for_month"  class="form-control" placeholder="">

                              </div>
                            </div>
                        </div>
                        <input type="submit" value="Save Changes" class="btn btn-success float-right">

                      </div>
                    </div>

                    
                </form>
              </div>
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
            // {data: 'vendor_type', name: 'vendor_type'},
            {data: 'blog_type', name: 'blog_type'},
            {data: 'from_to', name: 'from_to',orderable: false, searchable: false},
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
