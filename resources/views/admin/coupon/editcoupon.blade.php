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
                      <form id="restaurant-form" action="{{route('admin.coupon.store')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" value="{{$coupon->name}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Name">
                                        <input type="hidden" name="id" value="{{$coupon->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Name">
                                        <input type="hidden" name="create_by" value="admin" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Name">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Code<span class="text-danger">*</span></label>
                                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="code" value="{{$coupon->code}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Code">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Discount Type <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="discount_type" style="width: 100%;">
                                        @if($coupon->discount_type == '1')
                                          <option value="1">Percent</option>
                                          <option value="0">Amount</option>
                                        @else
                                          <option value="0">Amount</option>
                                          <option value="1">Percent</option>
                                        @endif
                                        </select>
                                    </div>  
                                  </div>
                                  
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Discount <span class="text-danger">*</span></label>
                                        <input type="text" name="discount" value="{{$coupon->discount}}" class="form-control"  id="" placeholder="Discount">
                                    </div>  
                                  </div>
                                 
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Maximum Discount Amount *</label>
                                      <input type="text" name="maxim_dis_amount" value="{{$coupon->maxim_dis_amount}}" class="form-control"  id="" placeholder="Maximum Discount Amount *">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Minimum Order Amount * <span class="text-danger">*</span></label>
                                        <input type="text" name="minimum_order_amount" value="{{$coupon->minimum_order_amount}}" class="form-control"  id="" placeholder="Minimum Order Amount *">
                                    </div>  
                                  </div>
                                  
                                  <!--<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Type * <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="coupon_type" style="width: 100%;">
                                          <option value="order">order</option>
                                          <option value="product">product</option>
                                        </select>
                                    </div>  
                                  </div>-->
                                  <div class="col-md-3">
                                   <div class="form-check" style="margin-top:40px;">
                                    @if($coupon->show_in == '1')
                                        <input class="form-check-input" name="show_in" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    @else
                                      <input class="form-check-input" name="show_in" type="checkbox" value="1" id="flexCheckDefault" checked>
                                    @endif
                                        <label for="flexCheckDefault">
                                            Show In Customer App
                                        </label>
                                    </div> 
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Valid For First X User <span class="text-danger">*</span></label>
                                        <input type="text"  name="coupon_valid_x_user" value="{{$coupon->coupon_valid_x_user}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Valid For First X User ">
                                    </div>  
                                  </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>From:</label>
                                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                    <input type="text" name="from" class="form-control datetimepicker-input" value="{{$coupon->from}}" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>To:</label>
                                                <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                                    <input type="text" name="to" class="form-control datetimepicker-input" value="{{$coupon->to}}" data-target="#reservationdate"/>
                                                    <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Description <span class="text-danger">*</span></label>
                                        <input type="text" name="description" class="form-control" value="{{$coupon->description}}"  id="" placeholder="Description...">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Redeem Count (How Much time a user can redeem this coupon)<span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="promo_redeem_count" style="width: 100%;">
                                         <option value="{{$coupon->promo_redeem_count}}">{{$coupon->promo_redeem_count}}</option>
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                          <option value="6">6</option>
                                          <option value="7">7</option>
                                          <option value="8">8</option>
                                          <option value="9">9</option>
                                          <option value="10">10</option>
                                        </select>
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coupon Validity(Once a day/week/month or Lifetime)<span class="text-danger">*</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select class="form-control select2" name="promocode_use" style="width: 100%;">
                                          <option value="{{$coupon->promocode_use}}">{{$coupon->promocode_use}}</option>
                                          <option value="1">Once a Day</option>
                                          <option value="2">Once a Week</option>
                                          <option value="3">Once a Month</option>
                                          <option value="4">Lifetime</option>
                                        </select>
                                    </div>  
                                  </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                            <div>
                                              <label for="">Images </label>
                                            </div>
                                            <div class="image-upload">
                                                <label for="file-input">
                                                    <div class="upload-icon">
                                                    @if($coupon->image == null)
                                                    <img class="icon3" src="{{asset('add-image.png')}}">
                                                    @else
                                                    <img class="icon3" src="{{ asset('coupon-admin'.'/'.$coupon->image ) }}">
                                                    @endif
                                                    </div>
                                                </label>
                                                <input id="file-input" type="file" name="image" required/>
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
             name: {
                  required: true,
              },
              code: {
                  required: true,
                  remote: '{{route("admin.coupon.couponcheck")}}',
              },
              discount_type: {
                  required: true,
              },
              discount: {
                  required: true,
                  number: true,
              },
              maxim_dis_amount: {
                required: true,
                number: true,
              },
              minimum_order_amount: {
                required: true,
                number: true,
              },
              promo_redeem_count: {
                  required: true,
                
              },
              promocode_use: {
                required: true,
              },
              coupon_type: {
                required: true,
              },
              from: {
                required: true,
              },
              to: {
                required: true,
              },
              discription: {
                required: true,
              }
        },
          messages: {
            name: {
                  required: "Coupon Name is required",
              },
              code: {
                  required: "Coupon code is required",
                  remote: "Coupon code is already Taken"
              },
              discount_type: {
                  required: "Please Select Discount Type",
              },
              discount: {
                  required: "Discount is required",
                  number: "Discount must be an number"
              },
              maxim_dis_amount: {
                  required: "Maximum Value is required",
                  number: "Pincode must be an number"
              },
              minimum_order_amount:{
                required: "Maximum Value is required",
                  number: "Minimum Value must be an number"
              },
              promo_redeem_count: {
                required: "Promo Redeem Code is required",
              },
              promocode_use: {
                required: "Promo Redeem Code is required",
              },
             
              coupon_type: {
                required: "Coupon Type is required",
              },
              from: {
                required: "Date is required",
              },
              to: {
                required: "Date is required",
              },
              
          }
      });
      $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
    $('#reservationdate').datetimepicker({
          format: 'L'
      });
      $('#reservationdate1').datetimepicker({
          format: 'L'
      });
</script>



@endsection