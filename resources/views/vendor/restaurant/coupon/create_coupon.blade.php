@extends('vendor.restaurants-layout')
@section('main-content')
<style>
      .select2-selection__choice{
        background:#ff0018;
      }
      .select2-selection__choice__display{
        color:#fff;
      }
      .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color:#ff0018;
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
    </style>
    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Coupon</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="{{route('restaurant.menu.list')}}">Menu Catalogue</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create Coupon</li>
              

            </ol>
          </nav>
        </div>
        <div class="col-xl-12 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Create New  Coupon</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="coupon-form" action="{{route('restaurant.coupon.store')}}"  method="post" enctype="multipart/form-data">
              @csrf
              
              @if ($errors->any())
                  @foreach ($errors->all() as $error)
                      <div class="alert alert-danger">{{$error}}</div>
                  @endforeach
              @endif
                <div class="form-row">
                    <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Coupon Name</label>
                        <div class="input-group">
                        <input type="text" name="name" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Name">
                        <input type="hidden" name="create_by" value="vendor" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Name">
                        </div>
                        <span class="name_error text-danger"></span>
                     </div>
                    
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Coupon Code</label>
                        <div class="input-group">
                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="code" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Code">
                        
                        </div>
                        <span class="code_error text-danger"></span>
                     </div>
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Discount Type</label>
                        <div class="input-group">
                        <select class="form-control select2" name="discount_type" style="width: 100%;">
                          <option value="1">Percent</option>
                          <option value="0">Amount</option>
                        </select>
                        </div>
                           
                     </div>
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Discount</label>
                        <div class="input-group">
                        <input type="text" name="discount" class="form-control"  id="" placeholder="Discount">
                        
                        </div>
                        <span class="discount_error text-danger"></span>
                     </div>
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Maximum Discount Amount</label>
                        <div class="input-group">
                        <input type="text" name="maxim_dis_amount" class="form-control"  id="" placeholder="Maximum Discount Amount *">
                        
                        </div>
                        <span class="maxim_dis_amount_error text-danger"></span>
                     </div> 
                    
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Minimum Order Amount</label>
                        <div class="input-group">
                        <input type="text" name="minimum_order_amount" class="form-control"  id="" placeholder="Minimum Order Amount *">
                        
                        </div>
                        <span class="minimum_order_amount_error text-danger"></span>   
                     </div> 
                   
                      
                    
                     <!--<div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Coupon Type</label>
                        <div class="input-group">
                        <select class="form-control select2" id="type" name="coupon_type" style="width: 100%;">
                          <option value="order">order</option>
                          <option value="product">product</option>
                        </select>
                        </div>
                            @error('name')
                              <p class="text-danger">
                                  {{ $message }}
                              </p>
                            @enderror
                     </div> 
                     <div class="col-xl-3 col-md-12 mb-3" id="row_dim">
                      <label for="validationCustom10">Product</label>
                        <div class="input-group">
                        <select class="form-control select2" name="product_id" style="width: 100%;">
                              @foreach($product as $k =>$value)
                                  <option value="{{$value->id}}">{{$value->product_name	}}</option>
                              @endforeach
                        </select>
                        </div>
                            @error('name')
                              <p class="text-danger">
                                  {{ $message }}
                              </p>
                            @enderror
                     </div> -->
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">From</label>
                        <div class="input-group">
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                              <input type="date" name="from" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                        </div>
                        <span class="from_error text-danger"></span>
                        </div>
                           
                     </div>
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">To</label>
                        <div class="input-group">
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <input type="date" name="to" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            
                        </div>
                        <span class="to_error text-danger"></span>
                        </div>
                           
                     </div>
                     <div class="col-xl-4 col-md-12 mb-3">
                      <label for="validationCustom10">Redeem Count (How Much time a user can redeem this coupon)</label>
                        <div class="input-group">
                        <select class="form-control" name="promo_redeem_count" style="width: 100%;">
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
                   
                     <div class="col-xl-4 col-md-12 mb-3">
                      <label for="validationCustom10">Coupon Validity(Once a day/week/month or Lifetime)</label>
                        <div class="input-group">
                            <select class="form-control select2" name="promocode_use" style="width: 100%;">
                            <option value="1">Once a Day</option>
                            <option value="2">Once a Week</option>
                            <option value="3">Once a Month</option>
                            <option value="4">Lifetime</option>
                            </select>
                        </div>
                            
                     </div>
                     <div class="col-xl-4 col-md-12 mb-3">
                      <label for="validationCustom10">Coupon Valid For First X User &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <div class="input-group">
                        <input type="text" name="coupon_valid_x_user" class="form-control"  id="" placeholder="Coupon Valid For First X User">
                        
                        </div>
                        <span class="minimum_order_amount_error text-danger"></span>   
                     </div> 
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">description</label>
                        <div class="input-group">
                        <textarea type="text" name="description" class="form-control"  id="" placeholder="description"></textarea>
                        
                        </div>
                        <span class="description_error text-danger"></span> 
                     </div> 


                  </div>
                
                <button class="btn btn-primary float-right" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  
@endsection

@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script type="text/javascript">
     $("#coupon-form").validate({
      rules: {
             name: {
                  required: true,
              },
              code: {
                  required: true,
                  remote: '{{route("restaurant.coupon.couponcheck")}}',
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
              description: {
                required: true,
              }
        },
          messages: {
            name: {
                  required: "Coupon Name is required",
                 // remote: "Coupon code is already exist",
              },
              code: {
                  required: "Coupon code is required",
                  remote: "Coupon code is already Taken"
                 // remote:"Give Upore Case Value",
                 // remote:"ALL CHARACTOR ARE UPPERCASE",
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
              
          },
          errorPlacement: function (error, element) {
              var name = $(element).attr("name");
             
              error.appendTo($("." + name + "_error"));
          }, 
    });
    $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
    $('#row_dim').hide(); 
    $('#type').change(function(){
        if($('#type').val() == 'product') {
            $('#row_dim').show(); 
        } else {
            $('#row_dim').hide(); 
        } 
    });
    $('#reservationdate').datetimepicker({
          format: 'L'
      });
      $('#reservationdate1').datetimepicker({
          format: 'L'
      });
</script>
<script>
  (function($) {
    
  })(jQuery);
</script>
@endsection