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
                      <h3 class="card-title">Create Food Video Link </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.chef.video.update')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                       <div class="card card-default">
                              <div class="card-header">
                                    <h3 class="card-title">Video Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Video Title</label>
                                          <input type="text" name="title" value="{{$video->title}}" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Video Title">
                                          <input type="hidden" name="id" value="{{$video->id}}" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Video Title">
                                          <input type="hidden" name="userId" value="{{$video->userId}}" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Video Title">
                                        
                                      </div>  
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Sub Title</label>
                                          <input type="text" name="sub_title"  value="{{$video->title}}" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Sub Title">
                                        
                                      </div>  
                                    </div>
                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Video Link</label>
                                          <textarea class="form-control" name="link" >{{$video->link}}</textarea>
                                      </div>
                                    </div>

                                    
                                

                              </div>
                              <div class="card-footer">
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
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
            title: {
                  required: true,
                  minlength: 10,
              },
              sub_title: {
                  required: true,
                  maxlength: 30,
                  minlength: 10,
              },
              link: {
                  required: true,
              }
             
              
              
          },
          title: {
                name: {
                  required: "Name is required",
                  minlength: 10,
                  minlength: "Title  cannot be more than 20 characters"
              },
              sub_title: {
                  required: "Please Sub Title",
                  maxlength: "Sub Title cannot be more than 30 characters"
              },
              link: {
                  required: "Link is required"
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