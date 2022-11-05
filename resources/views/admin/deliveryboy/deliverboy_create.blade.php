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
                      <h3 class="card-title">Create Delivery Boy </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.diliverboy.store')}}" method="post" enctype="multipart/form-data">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            @csrf
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-12">
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
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Delivery Boy <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"  id="exampleInputEmail1" placeholder="Enter Deliveryboy Name">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control"  id="" placeholder="Enter Deliveryboy Email">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City <span class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control"  id="" placeholder="Enter City">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" class="form-control"  id="" placeholder="Enter Pincode">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control"  id="" placeholder="Enter Mobile Number">
                                    </div>  
                                  </div>
                                  
                                  
                                  
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control"  id="" placeholder="Enter Password">
                                    </div>  
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="confirm_password" class="form-control"  id="" placeholder="Enter Confirm Password">
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
                                  <div class="col-md-4">
                                    <div class="form-group">identity_image
                                        <label for="exampleInputEmail1">Identity Number <span class="text-danger">*</span></label>
                                        <input type="text" name="identity_number" class="form-control"  id="" placeholder="Enter Identity Number">
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
                                  </div>
                                </div>
                                  
                                </div>
                                <!-- div row -->
                            </div>
                              
                              
                          </div>
                         
                          
                         
                              
                              
                          </div>
                          <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i>Register Deliveryboy </button>
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
        
      $("#restaurant-form").validate({
          rules: {
              name: {
                  required: true,
                  maxlength: 40,
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

              password:{
                required: true,
                maxlength: 20,  
                minlength: 5,
                
              },
              confirm_password:{
                 required: true,
                 equalTo : '[name="password"]'
              },
      
              identity_image:{
                required: true,
              },
              identity_number:{
                 required: true,
              }

          },
          messages: {
              name: {
                  required: "Name is required",
                  maxlength: "First name cannot be more than 40 characters"
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

  $.validator.addMethod('checkLocation',function (value, element) {

            var check = true;
            if($('#address-latitude').val() == ''){
                check =  false;
            }
            else if($('#address-longitude').val() == ''){
                check =  false
            }
            if(check){
                return true;
            }else{
                Swal.fire({icon: 'error',title: 'Oops...',text: "Please Select Location Properly", footer: ''});
            }
        
        
        

    },'Please Select Location Properly ');
    function initialize() {

$('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});
const locationInputs = document.getElementsByClassName("map-input");

const autocompletes = [];
const geocoder = new google.maps.Geocoder;
for (let i = 0; i < locationInputs.length; i++) {

    const input = locationInputs[i];
    const fieldKey = input.id.replace("-input", "");
    const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

    const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 51.5073509;
    const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || -0.12775829999998223;

    const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
        center: {
            lat: latitude,
            lng: longitude
        },
        zoom: 13
    });
    const marker = new google.maps.Marker({
        map: map,
        position: {
            lat: latitude,
            lng: longitude
        },
    });

    marker.setVisible(isEdit);

    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.key = fieldKey;
    autocompletes.push({
        input: input,
        map: map,
        marker: marker,
        autocomplete: autocomplete
    });
}

for (let i = 0; i < autocompletes.length; i++) {
    const input = autocompletes[i].input;
    const autocomplete = autocompletes[i].autocomplete;
    const map = autocompletes[i].map;
    const marker = autocompletes[i].marker;

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        marker.setVisible(false);
        const place = autocomplete.getPlace();

        geocoder.geocode({
            'placeId': place.place_id
        }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                const lat = results[0].geometry.location.lat();
                const lng = results[0].geometry.location.lng();
                setLocationCoordinates(autocomplete.key, lat, lng);
            }
        });

        if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            input.value = "";
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

    });
}
}
function setLocationCoordinates(key, lat, lng) {
const latitudeField = document.getElementById(key + "-" + "latitude");
const longitudeField = document.getElementById(key + "-" + "longitude");
latitudeField.value = lat;
longitudeField.value = lng;
}
 </script>
 <script>
        (function($) {
            $(".select-av").change(function() {

                if ($(this).val() == 0) {

                    $("#start_time_" + $(this).attr('data-item-id')).val(null);
                    $("#end_time_" + $(this).attr('data-item-id')).val(null);
                    $('#start_time_'+ $(this).attr('data-item-id')).prop('required', false);
                    $('#end_time_'+ $(this).attr('data-item-id')).prop('required', false);
                }else
                {
                    $('#start_time_'+ $(this).attr('data-item-id')).prop('required', true);
                    $('#end_time_'+ $(this).attr('data-item-id')).prop('required', true);
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
@endsection