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

  .upload-icon4.has-img4 img {
    /*width: 100%;
            height: auto;*/
    width: 150px;
    height: 150px;
    border-radius: 18px;
    margin: 0px;
  }

  /*  */
  .upload-icon5 {
    width: 150px;
    height: 150px;
    border: 2px solid #000;
    border-style: dotted;
    border-radius: 18px;
  }

  .upload-icon5 img {
    width: 100px;
    height: 100px;
    margin: 19px;
    cursor: pointer;
  }

  .upload-icon5.has-img5 {
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

    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary card-outline">

            <div class="card-header">
              <h3 class="card-title">Create New User </h3>

            </div>
            <div class="card-body pad table-responsive">
              <form id="restaurant-form" action="{{route('admin.system.user.store')}}" method="post" enctype="multipart/form-data">
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
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name of User <span class="text-danger">*</span></label>
                          <input type="text" name="user_name" class="form-control" id="exampleInputEmail1" placeholder="Enter User Name">
                        </div>
                      </div>
                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                          <input type="email" name="email" class="form-control" id="" placeholder="Enter User Email">
                        </div>
                      </div>

                      
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                          <input type="text" name="phone" class="form-control" id="" placeholder="Enter Mobile Number">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Alternate Mobile Number</label>
                          <input type="text" name="alt_phone" class="form-control" id="" placeholder="Enter Alternate Mobile Number">
                        </div>
                      </div>


                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Password <span class="text-danger">*</span></label>
                          <input type="password" name="password" class="form-control" id="" placeholder="Enter Password">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Confirm Password <span class="text-danger">*</span></label>
                          <input type="password" name="confirm_password" class="form-control" id="" placeholder="Enter Confirm Password">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Role  <span class="text-danger">*</span></label>
                          <select name="role_id" id="" class="form-control">
                            @foreach($roles as $key =>$value)
                              <option value="{{$value->id}}">{{$value->role_name}}</option>
                            @endforeach
                            
                            
                          </select>
                        </div>
                      </div>

                      
                      
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Address <span class="text-danger">*</span></label>
                          <input type="text" name="address" class="form-control" id="" placeholder="Enter User Address">
                        </div>
                      </div>
                      
                    
                    </div>

                  </div>

                </div>
                <!-- basic information end -->
                
                <!-- schedule information end -->
                <div class="card-footer">
                  <button class="btn btn-success"><i class="fa fa-save"></i>Register User </button>
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
        user_name: {
          required: true,
        },
        email: {
          required: true,
          maxlength: 60,
          email: true,
          remote: '{{route("admin.systemuser.emailcheck")}}',
        },
        address: {
          required: true,
          minlength: 5,
          maxlength: 140
        },
        phone: {
          required: true,
          minlength: 10,
          maxlength: 10,
          number: true,
          //remote: '{{route("admin.vendor.mobilecheck")}}',
        },
        alt_phone: {
          minlength: 10,
          maxlength: 10,
          number: true,
        },

        pincode: {
          required: true,
          minlength: 6,
          maxlength: 6,
          number: true
        },
        fssai_lic_no: {
          required: true,
        },
        password: {
          required: true,
          maxlength: 20,
          minlength: 5,

        },
        confirm_password: {
          required: true,
          equalTo: '[name="password"]'
        },
        vendor_commission: {
          required: true,
          number: true
        },
        tax: {
          required: true,
        },
        pancard_number: {
          required: true,
        },
        pancard_image: {
          required: true,
        },
        aadhar_number: {
          required: true,
        },
        aadhar_card_image: {
          required: true,
        },
        'categories[]': {
          required: true
        },
        'deal_cuisines[]': {
          required: true
        },
        lat:{
          required: true,
        },
        lng:{
          required: true,
        }


      },
      messages: {
        Restaurant_name: {
          required: "Name is required",
          maxlength: "First name cannot be more than 40 characters"
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
        confirm_password: {
          equalTo: "Field Not Match with Passowrd Field"
        },
        phone: {
          remote: "Mobile Number Already use in Onther Account"
        },
        tax: {
          remote: "Tax is required"
        },
        pancard_number: {
          remote: "pan card number is required"
        },
        pancard_image: {
          remote: "pan card image is required"
        },
        aadhar_number: {
          remote: "aadhar card number is required"
        },
        aadhar_card_image: {
          remote: "aadhar card image is required"
        },
        'categories[]': {
          required: "Select Deals categories"
        },
        'deal_cuisines[]': {
          required: "Select Deals Cuisines"
        },
        lat: {
          required: "Latitude is required",
        },
        lng: {
          required: "Longitude is required",
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
    $('#file-input5').change(function(event) {
      $("img.icon5").attr('src', URL.createObjectURL(event.target.files[0]));
      $("img.icon5").parents('.upload-icon5').addClass('has-img5');
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
      
      // const latitudeField = document.getElementById("address-latitude-1");
      // const longitudeField = document.getElementById("address-longitude-1");
      // latitudeField.value = lat;
      // longitudeField.value = lng;
      // $('#address-lat').val(lat);
      // $('#address-long').val(lng);
      $('.newLatitude').val(lat);
      $('.newLongitude').val(lng);
    }
  }
</script>


<script>
  (function($) {
    $(".select-av").change(function() {

      if ($(this).val() == 0) {

        $("#start_time_" + $(this).attr('data-item-id')).val(null);
        $("#end_time_" + $(this).attr('data-item-id')).val(null);
        $('#start_time_' + $(this).attr('data-item-id')).prop('required', false);
        $('#end_time_' + $(this).attr('data-item-id')).prop('required', false);
      } else {
        $('#start_time_' + $(this).attr('data-item-id')).prop('required', true);
        $('#end_time_' + $(this).attr('data-item-id')).prop('required', true);
      }
    });

    $(".start_time").focusout(function() {
      var v = $(this).val();

      $(".start_time").each(function() {
        if ($(this).val() == '' && $("#available_" + $(this).attr('data-item-id')).val() ==
          1) {
          $(this).val(v);
        }

      });
    });
    $(".end_time").focusout(function() {
      var v = $(this).val();
      $(".end_time").each(function() {
        if ($(this).val() == '' && $("#available_" + $(this).attr('data-item-id')).val() ==
          1) {
          $(this).val(v);
        }
      });
    });
  })(jQuery);
</script>
</script>
@endsection