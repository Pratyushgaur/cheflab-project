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
                      <h3 class="card-title">Create Prodect </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.chef.store_product')}}" method="post" enctype="multipart/form-data">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                        @endif
                        @csrf
                          <inpu`t type="hidden" name="_token" value="{{ csrf_token() }}" />
                       <div class="card card-default">
                              <div class="card-header">
                                    <h3 class="card-title">Product Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Name of Product</label>
                                          <input type="text" name="product_name" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Product Name">
                                          <input type="hidden" name="userId" value="{{$vendor->id}}" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Product Name">
  

                                      </div>
                                    </div>
                                  

                                    <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Product Description</label>
                                          <textarea class="form-control" name="dis" ></textarea>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Primary Variant Name *</label>
                                          <input type="text" name="primary_varinat_name" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Primary Variant Name">
                                          
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">

                                          <label for="exampleInputEmail1">Product Type</label><br>

                                          <div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                              <input type="radio" id="veg" name="type" value="veg" checked>
                                              <label for="veg">Veg</label>
                                            </div>
                                            <div class="icheck-danger d-inline">
                                              <input type="radio" id="non_veg" name="type" value="non_veg">
                                              <label for="non_veg">Non Veg</label>
                                            </div>
                                            <div class="icheck-warning d-inline">
                                              <input type="radio" id="eggs" name="type" value="eggs">
                                              <label for="eggs">Eggs</label>
                                            </div>

                                          </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="">Product Price</label>
                                          <input type="text" name="product_price" class="form-control"  id="product_owner" placeholder="Product Price">
                                      </div>
                                    </div>

                                

                                    <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="">Customizable Availablity</label>


                                          <select name="customizable" id="custimization" name="customizable" class="form-control">
                                            <option value="false">No</option>
                                            <option value="true">Yes</option>
                                          </select>
                                      </div>
                                    </div>

                                  </div>
                                  <div class="col-md-12 mb-3 custmization-block" style="">
                                        <div class="row">
                                          <div class="col-md-12">
                                              <h5>Add More Variant</h5>
                                          </div>
                                        </div>
                                        <div class="variant-input-container">
                                            <div class="row input-container" style="padding-bottom:15px;">
                                                <div class="col-md-4">
                                                    <input type="text" name="variant_name[]" class="form-control variant_name"  placeholder="Enter Variant Name">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="price[]" class="form-control price" placeholder="Enter Price">
                                                </div>
                                            </div>
                                            <!-- <div class="row input-container" style="padding-bottom:15px;">
                                                <div class="col-md-4">
                                                    <input type="text" name="variant_name[]" class="form-control variant_name"  placeholder="Enter Variant Name">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="price[]" class="form-control price" placeholder="Enter Price">
                                                </div>
                                                <div class="col-md-2">
                                                    <a class="" href="javascript:void(0)" ><i class="fa fa-trash delete-variant" style="margin-top:10px;"></i></a>
                                                </div>
                                            </div> -->
                                        </div>


                                        <div class="row">
                                          <div class="col-md-4"><a href="javascript:void(0)" class="add">+ Add More Variant</a></div>
                                        </div>
                                    <!--<div class="custmization-block" style="display:none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Add More Variant</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="variant_name" class="form-control variant_name"  placeholder="Enter Variant Name">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="price" class="form-control price" placeholder="Enter Price">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary add">Add This Variant</button>
                                            </div>
                                        </div>
                                            <br>
                                        <div class="variant-container">
                                        </div>

                                    </div> -->
                                 </div>
                                 <div class="col-md-3 mb-3">
                                    <label>Preparation Time</label>
                                    <div class="input-group">
                                        {{ Form::select('preparation_time', config('custom_app_setting.product_preparation_time'),null,['class' => 'form-control', 'placeholder' => 'Select Preparation Time ','reuired']) }}

                                        @if ($errors->has('preparation_time'))
                                            <span class="ms-text-danger"><strong>{{ $errors->first('preparation_time') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                  <div class="col-sm-3">
                                      <div>
                                        <label for="">Product Image </label>

                                      </div>
                                      <div class="image-upload">

                                          <label for="file-input">
                                              <div class="upload-icon">
                                                  <img class="icon" src="{{asset('add-image.png')}}">
                                              </div>
                                          </label>
                                          <input id="file-input" type="file" name="product_image"/>

                                      </div>

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
  (function($) {
    $('.custmization-block').hide();
    $(document).on('click','.delete-variant',function(){
      $(this).parent().parent().parent().remove();
      
    })
    $(document).on('click','.add',function(){
      var html = '<div class="row input-container" style="padding-bottom:15px;"><div class="col-md-4"><input type="text" name="variant_name[]" class="form-control variant_name"  placeholder="Enter Variant Name"></div><div class="col-md-2"><input type="text" name="price[]" class="form-control price" placeholder="Enter Price"></div><div class="col-md-2"><a class="" href="javascript:void(0)" ><i class="fa fa-trash delete-variant" style="margin-top:10px;"></i></a></div></div>';
      $('.variant-input-container').append(html);
    })
    $('#custimization').change(function(){
      if ($(this).val()  == 'true') {
        $('.custmization-block').show();
      } else {
        $('.custmization-block').hide();
      }
    })
    $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
      

      $.validator.addMethod('checkVariants',
          function (value, element) {
            if (value == 'true') {
              var check = true;
              $('.input-container').each(function(index, value) {
                if($(this).find('.variant_name').val() == ''){
                  check = false;
                }
                if($(this).find('.price').val() == ''){
                  check = false;
                }
                
              });
              if (check) {
                return true;
              } else {
                return false;
              }
             
            } else {
              return true;
            }
           

          },'Variants Fields is required'
      );
    $("#restaurant-form").validate({
          rules: {
            product_name: {
                  required: true,
                  maxlength: 25,
              },
              dis: {
                  required: true,
                  maxlength: 30,
              },
              product_price: {
                  required: true,
              },
              product_image: {
                  required: true,
              }
          },
          messages: {
              product_name: {
                  required: "Name is required",
                  maxlength: "First name cannot be more than 20 characters"
              },
              email: {
                  required: "Please Enter Email",
                  maxlength: "Product Discription more than 30 characters",
              },
              product_price: {
                  required: "Address is required",
              },
             
              phone:{
                remote:"Please Uplode Product Image Image"
              }
              
          }
      });     
  

    
      /*$('#customizable').change(function(){
        if ($(this).val() == 'true') {
          $('.custmization-block').show();
        } else {
          $('.custmization-block').hide();
        }
      })
      $('.add').click(function(){
        if ($('.variant_name').val() !='' && $('.price').val() !='') {
          var html = '<div class="row"><div class="col-md-4" style="text-align:center"><span>'+$('.variant_name').val()+'</span></div><div class="col-md-2"><span>'+$('.price').val()+'</span></div><div class="col-md-2"><a class="" href="javascript:void(0)" ><i class="fa fa-trash delete-variant" style="margin-top:10px;"></i></a></div></div><input type="hidden" name="variant_name[]" value="'+$('.variant_name').val()+'"><input type="hidden" name="variant_price[]" value="'+$('.price').val()+'"><br>';  
          $('.variant-container').append(html);
        }else{
          return false;
        }
        
        
      })*/
    })(jQuery);
 </script>
@endsection