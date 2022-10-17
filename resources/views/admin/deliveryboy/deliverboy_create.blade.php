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
                      <h3 class="card-title">Create New Deliver Boy </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.diliverboy.store')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="error">
                                    @if($errors->any())
                                      {{ implode('', $errors->all('message')) }}
                                    @endif
                                </div>
                             
                                <div class="row">
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Deliver Boy <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"  id="exampleInputEmail1" placeholder="Enter  Name">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"  id="" placeholder="Enter  Email">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City <span class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control"  id="" placeholder="Enter City">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" class="form-control"  id="" placeholder="Enter Pincode">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control"  id="" placeholder="Enter Mobile Number">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Delivery Boy Section  <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control">
                                          <option value="1">Pure Commission</option>
                                            <option value="2">Rent/Day Commission</option>
                                            <option value="3">In House</option>
                                        </select>
                                    </div>  
                                  </div> 
                                </div>
                                
                              </div>
                              
                          </div>
                          <!-- basic information end -->
                          <hr>
                          <!-- schedule information start -->
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Identity  Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-4">
                                        <div>
                                          <label for="">Deliver Boy Images</label>
                                        </div>
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <div class="upload-icon">
                                                    <img class="icon" src="{{asset('add-image.png')}}">
                                                </div>
                                            </label>
                                            <input id="file-input" type="file" name="image" required/>
                                        </div>        
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Identity Type <span class="text-danger">*</span></label>
                                        <select name="identity_type"  class="form-control">
                                          <option value="1">Passport</option>
                                          <option value="2">Driving License</option>
                                          <option value="3">Aadhar Card</option>
                                        </select>
                                    </div>  
                                  </div>
                                  <div class="col-sm-4">
                                        <div>
                                          <label for="">Identity Image </label>
                                          
                                        </div>
                                        <div class="image-upload">
                                          
                                            <label for="file-input3">
                                                <div class="upload-icon3">
                                                    <img class="icon3" src="{{asset('add-image.png')}}">
                                                </div>
                                            </label>
                                            <input id="file-input3" type="file" name="identity_image"/>
                                            
                                        </div>   
                                        <input type="text" name="identity_number" class="form-control" placeholder="Document Name">    
                                  </div>
                                </div>
                                <!-- div row -->
                              </div>
                              
                              
                          </div>
                          <!-- schedule information end -->
                          <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i>Register Deliver Boy </button>
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





    

<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  $(document).ready(function() {
    
      $("#restaurant-form").validate({
          rules: {
              name: {
                  required: true,
                  maxlength: 25,
              },
              email: {
                  required: true,
                  maxlength: 30,
                  email: true,
                  remote: '{{route("admin.deliverboy.emailcheck")}}',
              },
              city: {
                  required: true,
                  minlength: 5,
                  maxlength: 60
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
              identity_image:{
                required: true,
              },
              identity_number:{
                 required: true,
              },
             
              
              
          },
          messages: {
                name: {
                  required: "Name is required",
                  maxlength: "First name cannot be more than 20 characters"
              },
              email: {
                  required: "Please Enter Email",
                  maxlength: "Email cannot be more than 30 characters",
                  email: "Email must be a valid email address",
                  remote:"This Email is Already has been Taken"
              },
              city: {
                  required: "Address is required",
                  maxlength: "Address cannot be more than 60 characters",
                  minlength: "Address cannot be Less than 5 characters"
              },
              pincode: {
                  required: "pincode is required",
                  maxlength: "pincode cannot be more than 6 characters",
                  minlength: "pincode cannot be Less than 6 characters",
                  number: "Pincode must be an number"
              },
              identity_image:{
                equalTo:"Identity Image Required"
              },
              phone:{
                remote:"Mobile Number Already use in Onther Account"
              },
              identity_number:{
                remote:"Identity Number is Required"
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
  });
 </script>
@endsection