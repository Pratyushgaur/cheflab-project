@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
  label.error {
    color: #dc3545;
    font-size: 14px;
  }

  .image-upload {
    display: inline-block;
    margin-right: 15px;
    position: relative;
  }

  .image-upload>input {
    display: none;
  }

  .upload-icon {
    width: 150px;
    height: 150px;
    border: 2px solid #000;
    border-style: dotted;
    border-radius: 18px;
  }



  .upload-icon img {
    width: 100px;
    height: 100px;
    margin: 19px;
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
    margin: 0px;
  }

  /*  */
  .upload-icon2 {
    width: 150px;
    height: 150px;
    border: 2px solid #000;
    border-style: dotted;
    border-radius: 18px;
  }

  .upload-icon2 img {
    width: 100px;
    height: 100px;
    margin: 19px;
    cursor: pointer;
  }

  .upload-icon2.has-img2 {
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
    margin: 0px;
  }

  /*  */
  .upload-icon3 {
    width: 150px;
    height: 150px;
    border: 2px solid #000;
    border-style: dotted;
    border-radius: 18px;
  }

  .upload-icon3 img {
    width: 100px;
    height: 100px;
    margin: 19px;
    cursor: pointer;
  }

  .upload-icon3.has-img3 {
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
    margin: 0px;
  }





<<<<<<< HEAD
  .upload-icon4 {
    width: 150px;
    height: 150px;
    border: 2px solid #000;
    border-style: dotted;
    border-radius: 18px;
  }

  .upload-icon4 img {
    width: 100px;
    height: 100px;
    margin: 19px;
    cursor: pointer;
  }

  .upload-icon4.has-img4 {
    width: 150px;
    height: 150px;
    border: none;
  }
=======
        .upload-icon4{
          width: 450px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }

        .upload-icon4 img{
            width: 300px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }

        .upload-icon4.has-img4{
            width: 450px;
            height: 150px;
            border: none;
        }
>>>>>>> master

  .upload-icon4.has-img4 img {
    /*width: 100%;
            height: auto;*/
<<<<<<< HEAD
    width: 150px;
    height: 150px;
    border-radius: 18px;
    margin: 0px;
  }

  .select2-selection__choice {
    background: #007bff !important;
  }
</style>
@endsection
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
=======
            width: 450px;
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
                      <h3 class="card-title">Edit  Restaurant </h3>
>>>>>>> master

    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary card-outline">

<<<<<<< HEAD
            <div class="card-header">
              <h3 class="card-title">Edit Restaurant </h3>
=======
                                        </div>
                                        <div class="image-upload">

                                            <label for="file-input4">
                                                <div class="upload-icon4">
                                                    @if($vendor->banner_image == null)
                                                    <img class="icon4" src="{{asset('add-image.png')}}">
                                                    @else
                                                        <?php
                                                          $baner=json_decode($vendor->banner_image);
                                                          if (json_last_error() === JSON_ERROR_NONE) {
                                                            ?>
                                                            <img class="icon4" src="{{ asset('vendor-banner'.'/'.$baner[0] ) }}">
                                                            <?php
                                                          } else {
                                                            ?>
                                                            <img class="icon4" src="{{ asset('vendor-banner'.'/'.$vendor->banner_image ) }}">
                                                            <?php
                                                          }
                                                          
                                                          
                                                        ?>
                                                    
                                                    @endif
                                                </div>
                                            </label>
                                            <input id="file-input4"  type="file" name="banner_image"/>
>>>>>>> master

            </div>
            <div class="card-body pad table-responsive">
              <form id="restaurant-form" action="{{route('admin.vendors.update')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title text-bold">Basic Information</h3>

                  </div>
                  <div class="card-body">
                    <div class="error">
                      @if($errors->any())
                      {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                      @endif
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div>
                          <label for="">Restaurant Images ( Ratio 1:1 )</label>
                        </div>
                        <div class="image-upload">
                          <label for="file-input">
                            <div class="upload-icon">
                              @if($vendor->image == null)
                              <img class="icon" src="{{asset('add-image.png')}}">
                              @else
                              <img class="icon" src="{{ asset('vendors'.'/'.$vendor->image ) }}">
                              @endif
                            </div>
                          </label>
                          <input id="file-input" type="file" name="image" required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div>
                          <label for="">Banner Image (Ratio 3:1)</label>

                        </div>
                        <div class="image-upload">

                          <label for="file-input4">
                            <div class="upload-icon4">
                              @if($vendor->banner_image == null)
                              <img class="icon4" src="{{asset('add-image.png')}}">
                              @else
                              <?php
                              $baner = json_decode($vendor->banner_image);
                              ?>
                              <img class="icon4" src="{{ asset('vendor-banner'.'/'.$baner[0] ) }}">
                              @endif
                            </div>
                          </label>
                          <input id="file-input4" type="file" name="banner_image" />

                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name of Restaurant <span class="text-danger">*</span></label>
                          <input type="text" value="{{$vendor->name}}" name="restaurant_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Chef Name">
                          <input type="hidden" value="{{$vendor->id}}" name="id" class="form-control" id="exampleInputEmail1" placeholder="Enter Chef Name">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name of Restaurant Owner <span class="text-danger">*</span></label>
                          <input type="text" value="{{$vendor->owner_name}}" name="owner_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Owner Name">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                          <input type="email" name="email" value="{{$vendor->email}}" class="form-control" id="" placeholder="Enter Restaurant Email">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Password (IF YOU WANT TO EDIT) </label>
                          <input type="" name="password" value="" class="form-control" id="" placeholder="Enter Password if you want to change ">
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Pincode <span class="text-danger">*</span></label>
                          <input type="text" name="pincode" value="{{$vendor->pincode}}" class="form-control" id="" placeholder="Enter Pincode">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                          <input type="text" name="phone" value="{{$vendor->mobile}}" class="form-control" id="" placeholder="Enter Mobile Number">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Alternate Mobile Number</label>
                          <input type="text" name="alt_phone" class="form-control" value="{{$vendor->alt_mobile}}" id="" placeholder="Enter Alternate Mobile Number">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name of Restaurant Manager</label>
                          <input type="text" name="manager_name" class="form-control" value="{{$vendor->manager_name}}" id="exampleInputEmail1" placeholder="Enter Restaurant Manager Name">
                        </div>
                      </div>
                      <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Password <span class="text-danger">*</span></label>
                                            <input type="text" name="password" value="{{$vendor->password}}" class="form-control"  id="" placeholder="Enter Password">
                                        </div>
                                    </div> -->
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Deal With Categories <span class="text-danger">*</span></label>
                          {{ Form::select('categories[]',$categories,@explode(',',$vendor->deal_categories),['class' => 'select2','multiple'=>"multiple", 'data-placeholder'=>"Select Deal Categories",'style'=>"width: 100%;"]) }}


                          {{-- <select name="categories[]" class="select2" multiple="multiple" data-placeholder="Select Deal Categories" style="width: 100%;">--}}

                          {{-- <option value="{{$vendor->deal_categories}}">{{$vendor->deal_categories}}</option>--}}
                          {{-- @foreach($categories as $k =>$v)--}}
                          {{-- <option value="{{$v->id}}">{{$v->name}}</option>--}}
                          {{-- @endforeach--}}
                          {{-- </select>--}}
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Deal With Cuisines <span class="text-danger">*</span></label>
                          {{ Form::select('deal_cuisines[]',$cuisines,@explode(',',$vendor->deal_cuisines),['class' => 'select2','multiple'=>"multiple", 'data-placeholder'=>"Select Deal Cuisines" ,'style'=>"width: 100%;"]) }}
                          {{-- <select name="deal_cuisines[]" class="select2" multiple="multiple" data-placeholder="Select Deal Cuisines" style="width: 100%;">--}}
                          {{-- <option value="{{$vendor->deal_cuisines}}">{{$vendor->cuisinesName}}</option>--}}
                          {{-- @foreach($cuisines as $k =>$v)--}}
                          {{-- <option value="{{$v->id}}">{{$v->name}}</option>--}}
                          {{-- @endforeach--}}
                          {{-- </select>--}}
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Address <span class="text-danger">*</span></label>
                          <input type="text" name="address" value="{{$vendor->address}}" class="form-control" id="" placeholder="Enter Restaurant Address">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">

                          <label for="exampleInputEmail1">Vendor Food Type</label><br>

                          <div class="form-group clearfix">
                            <div class="icheck-success d-inline">
                              @if($vendor->vendor_food_type == '1')
                              <input type="radio" id="veg" name="type" value="1" checked>
                              <label for="veg">Veg</label>
                              @elseif($vendor->vendor_food_type != '1')
                              <input type="radio" id="veg" name="type" value="1">
                              <label for="veg">Veg</label>
                              @endif
                            </div>

                            <div class="icheck-danger d-inline">
                              @if($vendor->vendor_food_type == '3')
                              <input type="radio" id="non_veg" name="type" value="3" checked>
                              <label for="non_veg">Veg + Non Veg</label>
                              @elseif($vendor->vendor_food_type != '3')
                              <input type="radio" id="non_veg" name="type" value="3">

                              <label for="non_veg">Veg + Non Veg</label>
                              @endif
                            </div>


                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Vendor Commission Persentage<span class="text-danger">*</span></label>
                          <input type="text" value="{{$vendor->commission}}" name="vendor_commission" class="form-control" id="" placeholder="Enter Commission">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Tax<span class="text-danger">*</span></label>
                          <input type="text" name="tax" value="{{$vendor->tax}}" class="form-control" id="" placeholder="Tax">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">GST Available</label>
                          <select class="form-control gstavailable" name="gst_available">
                            {{-- @if($vendor->gst_available == '0')--}}
                            {{-- <option value="0">Not Available</option>--}}
                            {{-- <option value="1">Available</option>--}}
                            {{-- @elseif($vendor->gst_available == '1')--}}
                            {{-- <option value="1">Available</option>--}}
                            {{-- @endif--}}
                            <?php if ($vendor->gst_available == '1') { ?>
                              <option value="1">Available</option>
                            <?php } else { ?>
                              <option value="0">Not Available</option>
                              <option value="1">Available</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      {{-- @if($vendor->gst_available == '1')--}}
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">GST No<span class="text-danger">*</span></label>
                          <input type="text" value="{{($vendor->gst_no!='') ? $vendor->gst_no : null}}" name="gst_no" class="form-control" id="" placeholder="Enter GST NO" {{($vendor->gst_available!='1') ? '"required"' : ''}}>
                        </div>
                      </div>
                      {{-- @endif--}}
                      {{-- <div class="col-md-6 custmization-block">--}}
                      {{-- <div class="form-group">--}}
                      {{-- <label for="exampleInputEmail1">GST No<span class="text-danger">*</span></label>--}}
                      {{-- <input type="text" name="gst_no" class="form-control"  id="" placeholder="Enter GST NO">--}}
                      {{-- </div>--}}
                      {{-- </div>--}}

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
                          <input type="text" name="bank_name" class="form-control" id="" placeholder="Enter Bank Name" value="{{ @$vendor_bankdetails->bank_name }}">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Account Holder name</label>
                          <input type="text" name="holder_name" class="form-control" id="" placeholder="Account Holder Name" value="{{ @$vendor_bankdetails->holder_name }}">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Account Number </label>
                          <input type="text" name="account_no" class="form-control" placeholder="Account Number" value="{{ @$vendor_bankdetails->account_no }}">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>IFSC Code </label>
                          <input type="text" name="ifsc" class="form-control" placeholder="IFSC Code" value="{{ @$vendor_bankdetails->ifsc }}">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Cancel Check</label>
                          <input type="file" name="cancel_check" class="form-control" placeholder="Cancel Check" value="{{ @$vendor_bankdetails->cancel_check }}">
                        </div>
                      </div>
                    </div>
                    <!-- div row -->
                  </div>


                </div>
                <hr>
                <!-- schedule information start -->
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title text-bold">Identity Information</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">FSSAI Lic. No. <span class="text-danger">*</span></label>
                          <input type="text" value="{{$vendor->fssai_lic_no}}" name="fssai_lic_no" value="{{$vendor->fssai_lic_no}}" class="form-control" id="" placeholder="Enter FSSAI licence Number">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div>
                          <label for="">FSSAI Image </label>
                        </div>
                        <div class="image-upload">
                          <label for="file-input2">
                            <div class="upload-icon2">
                              @if($vendor->licence_image == null)
                              <img class="icon2" src="{{asset('add-image.png')}}">
                              @else
                              <img class="icon2" src="{{ asset('vendor-documents'.'/'.$vendor->licence_image ) }}">
                              @endif
                            </div>
                          </label>
                          <input id="file-input2" type="file" name="fassai_image" />

                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Pan Card Number. </label>
                          <input type="text" value="{{$vendor->pancard_number}}" name="pancard_number" class="form-control" placeholder="Pan Card Number">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Pan Card Image. </label>
                          <input type="file" name="pancard_image" value="{{$vendor->pancard_image}}" class="form-control" placeholder="Pan Card Image">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Document Name. </label>
                          <input type="text" name="other_document_name" value="{{$vendor->other_document}}" class="form-control" placeholder="Document Name">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Other Document.</label>
                          <input type="file" name="other_document" value="{{$vendor->other_document}}" class="form-control" id="" placeholder="Enter FSSAI licence Number">
                        </div>

                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Aadhar Number. </label>
                          <input type="text" name="aadhar_number" value="{{$vendor->aadhar_number}}" class="form-control" placeholder="Addhar Number">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Aadhar Image. </label>
                          <input type="file" name="aadhar_card_image" value="{{$vendor->aadhar_card_image}}" class="form-control" placeholder="Addhar Number">
                        </div>
                      </div>
                    </div>
                    <!-- div row -->
                  </div>


                </div>
                <!-- schedule information end -->
                <!--  -->
                <div class="card card-default">
                  <div class="card-header">
                    <h3 class="card-title text-bold">Location Setup</h3>
                  </div>
                  <!-- <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-4">
                                          <div class="form-group">
                                              <label>Lat </label>
                                              <input type="text" name="lat" class="form-control" placeholder="Latitue of Restaurant" value="{{ @$vendor->lat }}" required>
                                          </div>
                                    </div>                                 
                                    <div class="col-sm-4">
                                          <div class="form-group">
                                              <label>Lng</label>
                                              <input type="text" name="lng" class="form-control" placeholder="Lng of Restaurant" value="{{ @$vendor->long }}" required>
                                          </div>
                                    </div>
                                </div>
                              </div> -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label>Location</label>
                        <div class="input-group">
                          <input type="text" id="address-input" name="location" class="form-control map-input" value="" placeholder="Enter Location">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div id="address-map-container" style="width:100%;height:400px; ">
                          <div style="width: 100%; height: 100%" id="address-map"></div>
                          <input type="hidden" name="address_latitude" id="" value="{{ old('address_latitude') ?? '0' }}" />
                          <input type="hidden" name="address_longitude" id="" value="{{ old('address_longitude') ?? '0' }}" />

                          <input id="address-latitude" type="hidden" class="form-control" placeholder="Latitude" step="" name="lat" value="{{ @$vendor->lat }}" readonly required>
                          <input id="address-longitude" type="hidden" class="form-control" placeholder="Latitude" step="" name="long" value="{{ @$vendor->long }}" readonly required>

                        </div>
                      </div>
                    </div>
                    <!-- div row -->
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label>Latitude</label>
                      <div class="input-group">
                        <input id="address-lat" type="text" class="form-control" placeholder="Latitude" step="" value="{{ @$vendor->lat }}" readonly><br>
                      </div>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label>Longitude</label>
                      <div class="input-group">
                        <input id="address-long" type="text" class="form-control" placeholder="Latitude" step="" value="{{ @$vendor->long }}" readonly><br>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="card-footer">
                  <button class="btn btn-success"><i class="fa fa-save"></i>Update Restaurant </button>
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
    $('.gstavailable').change(function() {
      if ($(this).val() == '1') {
        $('.custmization-block').show();
      } else {
        $('.custmization-block').hide();
      }
    })
    $("#restaurant-form").validate({
      rules: {
        restourant_name: {
          required: true,
          maxlength: 80,
        },
        email: {
          required: true,
          maxlength: 60,
          email: true,
          remote: '{{route("admin.vendor.emailcheckUpdate",$vendor->id)}}',
        },
        address: {
          required: true,
          minlength: 5,
          maxlength: 120
        },
        phone: {
          required: true,
          minlength: 10,
          maxlength: 10,
          number: true,
          remote: '{{route("admin.vendor.mobilecheckUpdate",$vendor->id)}}',
        },
        pincode: {
          required: true,
          minlength: 6,
          maxlength: 6,
          number: true
        },
        fassai_lic_no: {
          required: true,
        },
        vendor_commission: {
          required: true,
          number: true
        },
        tax: {
          required: true,
        }
        // lat:{
        //   required:true
        // },
        // lng:{
        //   required:true
        // }



      },
      messages: {
        restourant_name: {
          required: "Name is required",
          maxlength: "First name cannot be more than 20 characters"
        },
        email: {
          required: "Please Enter Email",
          maxlength: "Email cannot be more than 30 characters",
          email: "Email must be a valid email address",
          remote: "This Email is Already has been Taken"
        },
        address: {
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
        phone: {
          remote: "Mobile Number Already use in Onther Account"
        },
        tax: {
          remote: "Tax is required"
        }


      }
    });

    $('#file-input').change(function(event) {
      $("img.icon").attr('src', URL.createObjectURL(event.target.files[0]));
      $("img.icon").parents('.upload-icon').addClass('has-img');
    });
    $('#file-input2').change(function(event) {
      $("img.icon2").attr('src', URL.createObjectURL(event.target.files[0]));
      $("img.icon2").parents('.upload-icon2').addClass('has-img2');
    });
    $('#file-input3').change(function(event) {
      $("img.icon3").attr('src', URL.createObjectURL(event.target.files[0]));
      $("img.icon3").parents('.upload-icon3').addClass('has-img3');
    });
    $('#file-input4').change(function(event) {
      $("img.icon4").attr('src', URL.createObjectURL(event.target.files[0]));
      $("img.icon4").parents('.upload-icon4').addClass('has-img4');
    });
  });


  function initialize() {
    var map = new google.maps.Map(document.getElementById('address-map'), {
      center: {
        lat: 51.5073509,
        lng: -0.12775829999998223
      },
      zoom: 15

    });
    var marker = new google.maps.Marker({
      position: {
        lat: 51.5073509,
        lng: -0.12775829999998223
      },
      map: map,
      draggable: true
    });
    var searchBox = new google.maps.places.SearchBox(document.getElementById("address-input"));
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('address-input'));

    google.maps.event.addListener(searchBox, 'places_changed', function(event) {
      searchBox.set('map', null);



      var places = searchBox.getPlaces();

      setLocationCoordinates(places[0].geometry.location.lat(), places[0].geometry.location.lng());
      var bounds = new google.maps.LatLngBounds();
      var i, place;
      for (i = 0; place = places[i]; i++) {
        (function(place) {
          var marker = new google.maps.Marker({

            position: place.geometry.location,
            draggable: true


          });
          marker.bindTo('map', searchBox, 'map');
          google.maps.event.addListener(marker, 'dragend', function(event) {
            setLocationCoordinates(event.latLng.lat(), event.latLng.lng());
          });
          google.maps.event.addListener(marker, 'map_changed', function() {
            if (!this.getMap()) {
              this.unbindAll();
            }
          });

          bounds.extend(place.geometry.location);


        }(place));




      }
      map.fitBounds(bounds);
      searchBox.set('map', map);
      map.setZoom(Math.min(map.getZoom(), 15));

    });
    google.maps.event.addListener(marker, 'dragend', function(event) {
      setLocationCoordinates(event.latLng.lat(), event.latLng.lng());
    });

    function setLocationCoordinates(lat, lng) {
      const latitudeField = document.getElementById("address-latitude");
      const longitudeField = document.getElementById("address-longitude");
      latitudeField.value = lat;
      longitudeField.value = lng;
      $('#address-lat').val(lat);
      $('#address-long').val(lng);
    }
  }
</script>
@endsection