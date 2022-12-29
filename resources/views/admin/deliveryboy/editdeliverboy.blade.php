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
        /*  */
        .upload-icon3{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }

        .upload-icon3 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }

        .upload-icon3.has-img3{
            width: 150px;
            height: 150px;
            border: none;
        }

        .upload-icon3.has-img3 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }





        .upload-icon4{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }

        .upload-icon4 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }

        .upload-icon4.has-img4{
            width: 150px;
            height: 150px;
            border: none;
        }

        .upload-icon4.has-img4 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }

        /*  */
        .upload-icon5{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }

        .upload-icon5 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }

        .upload-icon5.has-img5{
            width: 150px;
            height: 150px;
            border: none;
        }

        .upload-icon5.has-img5 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        .select2-selection__choice{
          background:#007bff !important;
        }
      </style>
      @endsection
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
                      <h3 class="card-title">Edit  Deliveryboy </h3>

                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.deliverboy.update')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                                </div>

                                <div class="row">
                                  <div class="col-md-12">
                                        <div>
                                          <label for="">Logo Images</label>
                                        </div>
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <div class="upload-icon">
                                                  @if($deliveryboy->image == null)
                                                    <img class="icon2" src="{{asset('add-image.png')}}">
                                                    @else
                                                    <img class="icon2" src="{{ asset('dliver-boy'.'/'.$deliveryboy->image ) }}">
                                                    @endif
                                                </div>
                                            </label>
                                            <input id="file-input" type="file" name="image" required/>
                                        </div>
                                  </div>
                            
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Deliver Boy <span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{$city_data->name}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter  Name">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{$city_data->email}}" class="form-control"  id="" placeholder="Enter  Email">
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" value="{{$city_data->pincode}}" class="form-control"  id="" placeholder="Enter Pincode">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{$city_data->mobile}}" class="form-control"  id="" placeholder="Enter Mobile Number">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="time">Time Type <span class="text-danger">*</span></label>
                                        <select name="time"  class="form-control" id="time">
                                          <option value="full_time">Full Time</option>
                                          <option value="part_time">Part Time</option>
                                        </select>
                                    </div>  
                                  </div>


                                    
                                  
                                </div>

                              </div>

                          </div>
                          <!-- basic information end -->
                          <hr>
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Bank Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Bank name</label>
                                        <input type="text" name="bank_name" class="form-control"  id="" placeholder="Enter Bank Name" value="{{ @$delivery_bankdetails->bank_name }}">
                                    </div>
                                  </div>
                                  <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Account Holder name</label>
                                            <input type="text" name="holder_name" class="form-control"  id="" placeholder="Account Holder Name" value="{{ @$delivery_bankdetails->holder_name }}">
                                        </div>
                                  </div>
                                  <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Account Number </label>
                                            <input type="text" name="account_no" class="form-control" placeholder="Account Number" value="{{ @$delivery_bankdetails->account_no }}">
                                        </div>
                                  </div>
                                  <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>IFSC Code </label>
                                            <input type="text" name="ifsc" class="form-control" placeholder="IFSC Code" value="{{ @$delivery_bankdetails->ifsc }}">
                                        </div>
                                  </div>                                 
                                  <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Cancel Check</label>
                                            <input type="file" name="cancel_check" class="form-control" placeholder="Cancel Check" value="{{ @$delivery_bankdetails->cancel_check }}">
                                        </div>
                                  </div>
                                </div>
                                <!-- div row -->
                              </div>


                          </div><hr>
                          <!-- schedule information start -->
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Identity  Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Identity Type <span class="text-danger">*</span></label>
                                        <select name="identity_type"  class="form-control">
                                          @if($deliveryboy->identity_type == '1')
                                            <option value="1">Passport</option>
                                            <option value="2">Driving License</option>
                                            <option value="3">Aadhar Card</option>
                                            @elseif($deliveryboy->identity_type)
                                            <option value="2">Driving License</option>
                                            <option value="1">Passport</option>
                                            <option value="3">Aadhar Card</option>
                                            @else
                                            <option value="3">Aadhar Card</option>
                                            <option value="2">Driving License</option>
                                            <option value="1">Passport</option>
                                            @endif
                                        </select>
                                    </div>  
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Identity Number <span class="text-danger">*</span></label>
                                        <input type="text" name="identity_number" value="{{$deliveryboy->identity_number}}" class="form-control"  id="" placeholder="Enter Identity Number">
                                    </div>  
                                  </div>
                                  <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Identity Image. </label>
                                            <input type="file" name="identity_image" value="{{$deliveryboy->identity_image}}" class="form-control"  id="" placeholder="Enter FSSAI licence Number">
                                        </div>
                                  </div>
                                </div>
                                <!-- div row -->
                              </div>


                          </div>
                          
                          
                          <!-- schedule information end -->
                          <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i>Update Deliveryboy </button>
                          </div>
                      </form>

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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>







<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    $('.custmization-block').hide();
    $('.gstavailable').change(function(){
      if ($(this).val()  == '1') {
        $('.custmization-block').show();
      } else {
        $('.custmization-block').hide();
      }
    })
      $("#restaurant-form").validate({
          rules: {
              name: {
                  required: true,
              },
              email: {
                  required: true,
                  maxlength: 60,
                  email: true,
                  remote: '{{route("admin.deliverboy.emailcheck")}}',
              },
              phone: {
                  required: true,
                  minlength: 10,
                  maxlength: 10,
                  number: true,
                  remote: '{{route("admin.deliverboy.mobilecheck")}}',
              },
              pincode: {
                  required: true,
                  minlength: 6,
                  maxlength: 6,
                  number: true
              },
              identity_number: {
                required: true,
              },
              password:{
                required: true,
                maxlength: 20,
                minlength: 5,

              },
              confirm_password:{
                 required: true,
                 equalTo : '[name="password"]'
              },
              identity_image: {
                required: true,
              }


          },
          messages: {
              name: {
                  required: "Name is required",
                  maxlength: "First name cannot be more than 40 characters"
              },
              email: {
                  required: "Please Enter Email",
                  maxlength: "Email cannot be more than 30 characters",
                  email: "Email must be a valid email address",
                  remote:"This Email is Already has been Taken"
              },
              pincode: {
                  required: "pincode is required",
                  maxlength: "pincode cannot be more than 6 characters",
                  minlength: "pincode cannot be Less than 6 characters",
                  number: "Pincode must be an number"
              },
              confirm_password:{
                equalTo:"Field Not Match with Passowrd Field"
              },
              phone:{
                remote:"Mobile Number Already use in Onther Account"
              },
              identity_image:{
                remote:"identity  image is required"
              },
              identity_number:{
                remote:"identity  number is required"
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
      $('#file-input3').change( function(event) {
          $("img.icon3").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon3").parents('.upload-icon3').addClass('has-img3');
      });
      $('#file-input4').change( function(event) {
          $("img.icon4").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon4").parents('.upload-icon4').addClass('has-img4');
      });
      $('#file-input5').change( function(event) {
          $("img.icon5").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon5").parents('.upload-icon5').addClass('has-img5');
      });
  });

  
 </script>
@endsection
