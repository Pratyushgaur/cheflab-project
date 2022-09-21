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
                      <h3 class="card-title">Edit Coupon </h3>
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.coupon.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                        @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Code<span class="text-danger">*</span></label>
                                        <input type="text" name="code" value="{{$coupon->code}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Code">
                                        <input type="hidden" name="id" value="{{$coupon->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Code">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Discount Type <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="discount_type" style="width: 100%;">
                                          <option value="{{$coupon->discount_type}}">{{$coupon->discount_type}}</option>
                                          <option value="percent">Percent</option>
                                          <option value="amount">Amount</option>
                                        </select>
                                    </div>  
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Discount <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$coupon->discount}}"  name="discount" class="form-control"  id="" placeholder="Discount">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Descriptio <span class="text-danger">*</span></label>
                                        <input type="text" name="description" value="{{$coupon->description}}" class="form-control"  id="" placeholder="Enter Mobile Number">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Maximum Ammount</label>
                                      <input type="text" name="maximum_order_value" value="{{$coupon->maximum_order_value}}" class="form-control"  id="" placeholder="Maximum Ammount">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Minimum Ammount <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$coupon->minimum_order_value}}" name="minimum_order_value" class="form-control"  id="" placeholder="Minimum Ammount">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Type <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="type" style="width: 100%;">
                                          <option value="{{$coupon->type}}">{{$coupon->type}}</option>
                                          <option value="1">publish</option>
                                          <option value="0">secret</option>
                                        </select>
                                    </div>  
                                  </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Expires Coupon:</label>
                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                    <input type="text" value="{{$coupon->expires_coupon}}" name="expires_coupon" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                              </div>
                              
                          </div>
                          <!-- basic information end -->
                          
                              
                              
                          </div>
                          <!-- schedule information end -->
                          <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i> Create Coupon </button>
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
    $("#restaurant-form").validate({
        rules: {
              code: {
                  required: true,
                  remote: '{{route("admin.coupon.couponcheckedit",$coupon->id)}}',
              },
              discount_type: {
                  required: true,
              },
              discount: {
                  required: true,
                  number: true,
              },
              description: {
                  required: true,
              },
              type: {
                  required: true,
                
              },
              maximum_order_value: {
                required: true,
                number: true,
              },
              minimum_order_value: {
                required: true,
                number: true,
              },
              expires_coupon: {
                required: true,
              }
        },
          messages: {
              code: {
                  required: "Coupon code is required",
                  remote:"This Coupon is Already has been Taken",
              },
              discount_type: {
                  required: "Please Select Discount Type",
                  maxlength: "Email cannot be more than 30 characters",
                  email: "Email must be a valid email address",
                  remote:"This Email is Already has been Taken"
              },
              discount: {
                  required: "Discount is required",
                  number: "Pincode must be an number"
              },
              maximum_order_value: {
                  required: "Maximum Value is required",
                  number: "Pincode must be an number"
              },
              minimum_order_value:{
                required: "Maximum Value is required",
                  number: "Minimum Value must be an number"
              },
              expires_coupon: {
                required: "Expire  Date is required",
              }
              
              
          }
      });
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
    $('#reservationdate').datetimepicker({
          format: 'L'
      });
</script>



@endsection