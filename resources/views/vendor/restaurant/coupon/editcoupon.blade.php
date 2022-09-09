@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Coupon</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="">Coupoan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Coupon</li>
              

            </ol>
          </nav>
        </div>
        <div class="col-xl-12 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Edit Coupon</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="menu-form" action="{{route('restaurant.coupon.update')}}"  method="post">
                @csrf
                
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                <div class="form-row">
                   <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Name of Menu</label>
                        <div class="input-group">
                             <input type="text" class="form-control" value="{{$coupon->code}}" name="code"  id="validationCustom03" placeholder="Enter Menu Name " >
                             <input type="hidden" name="id" value="{{$coupon->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Coupon Code">
                        </div>
                            @error('code')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Discount Type</label>
                        <div class="input-group">
                            <select class="form-control select2" name="discount_type" style="width: 100%;">
                                <option value="{{$coupon->discount_type}}">{{$coupon->discount_type}}</option>
                                <option value="percent">Percent</option>
                                <option value="amount">Amount</option>
                            </select>
                        </div>
                            @error('discount_type')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Discount</label>
                        <div class="input-group">
                             <input type="text" value="{{$coupon->discount}}" class="form-control" name="discount"  id="validationCustom03" placeholder="Enter Coupon Discription " >
                        </div>
                            @error('discount')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Descriptio</label>
                        <div class="input-group">
                        <input type="text" value="{{$coupon->discription}}" class="form-control" name="discription"  id="validationCustom03" placeholder="Discription " >
                        </div>
                            @error('name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Maximum Ammount</label>
                        <div class="input-group">
                             <input type="text" class="form-control" value="{{$coupon->maximum_order_value}}" name="maximum_order_value"  placeholder="Enter Maximum Ammount" >
                        </div>
                            @error('maximum_order_value')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Minimum Ammount</label>
                        <div class="input-group">
                        <input type="text" class="form-control" name="minimum_order_value" value="{{$coupon->minimum_order_value}}"  placeholder="Enter Minimum Ammount " >
                        </div>
                            @error('name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Coupon Type</label>
                        <div class="input-group">
                            <select class="form-control select2" name="type" style="width: 100%;">
                                <option value="{{$coupon->type}}">{{$coupon->type}}</option>
                                <option value="1">publish</option>
                                <option value="0">secret</option>
                            </select>
                        </div>
                            @error('type')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                    </div>
                    <div class="col-xl-6 col-md-6 mb-3">
                        <label for="validationCustom10">Expires Coupon</label>
                        <div class="input-group">
                            <input type="date" value="{{$coupon->expires_coupon}}" id="birthday" class="form-control" name="expires_coupon">
                        </div>
                            @error('expires_coupon')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
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
     $("#menu-form").validate({
        rules: {
              code: {
                  required: true,
                  remote: '{{route("restaurant.coupon.couponcheckedit",$coupon->id)}}',
              },
              discount_type: {
                  required: true,
              },
              discount: {
                  required: true,
                  number: true,
              },
              discription: {
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
</script>
<script>
  (function($) {
    
  })(jQuery);
</script>
@endsection