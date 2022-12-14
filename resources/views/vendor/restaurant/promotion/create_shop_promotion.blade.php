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
          width: 450px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }



        .upload-icon img{
          width: 450px;
          height: 150px;
          margin:19px;
          cursor: pointer;
        }


        .upload-icon.has-img {
            width: 450px;
            height: 150px;
            border: none;
        }

        .upload-icon.has-img img {
            /*width: 100%;
            height: auto;*/
            width: 450px;
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
                <li class="breadcrumb-item"><a href="#">Promotion management</a></li>
                <li class="breadcrumb-item "><a href="{{route('restaurant.shop.promotion')}}">Shop Promotion</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Shop Promotion</li>


            </ol>
          </nav>
        </div>
        <div class="col-xl-6 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Create New  Promotion</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="coupon-form" action="{{route('restaurant.slot.store')}}"  method="post" enctype="multipart/form-data">
                  @csrf

                  @if ($errors->any())
                      @foreach ($errors->all() as $error)
                          <div class="alert alert-danger">{{$error}}</div>
                      @endforeach
                  @endif
                <div class="form-row">
                    <div class="col-xl-12 col-md-12 mb-3">
                      <label for="validationCustom10">Date</label>
                        <div class="input-group">
                        <input type="date" name="date" class="form-control" min="2022-09-16" max="2022-09-22"  id="dateid" placeholder="Coupon Name">

                        </div>
                        <span class="date_error text-danger"></span>
                     </div>
                     <div class="col-xl-12 col-md-12 mb-3">
                      <label for="validationCustom10">Select Place</label>
                        <div class="input-group">
                        <select class="form-control" name="banner" id="validationCustom22">

                        </select>
                        </div>
                        <span class="banner_error text-danger"></span>
                        <div id="price">
                        </div>
                     </div>

                     <div class="col-md-6 mb-3">
                          <div>
                            <label for="">Images</label>
                          </div>
                          <div class="image-upload">
                            <label for="file-input">
                              <div class="upload-icon">
                                <img class="icon" src="{{asset('add-image.png')}}">
                              </div>
                            </label>
                            <input id="file-input" type="file" name="slot_image" required>
                          </div>
                        </div>
                        <span class="image_error text-danger"></span>
                        <!--  -->


                      </div>
                      <button class="btn btn-primary float-right" type="submit">Submit</button>
                   </form>
                 </div>




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
             date: {
                  required: true,
                //  remote: '{{route("restaurant.slot.checkdate")}}',
              },
              banner: {
                  required: true,

              },
              slot_image: {
                required: true,
              }

        },
          messages: {
            date: {
                  required: "Date  is required",
                  remote: "You Allready book this date chenge the date",
              },
              banner: {
                  required: "Select  Place",

              },
              slot_image: {
                  required: "Image is Required",

              },

          },
          errorPlacement: function (error, element) {
              var date = $(element).attr("date");

              error.appendTo($("." + date + "_error"));
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
    $('#dateid').change(function(){
      var id = this.value;
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("restaurant.slot.checkdate")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
              var resp = JSON.stringify(response);
           //   console.log(resp);
             var len = resp;
          //   console.log(len);
             if(len == 'false'){
                toastr.error('Your Allradiy Book This date place chenge sate', 'Alert');
              }else{
                var uh = JSON.stringify(response);
                console.log(uh);
                var obj = JSON.parse(uh);
                  for(i=0; i<uh.length; i++) {
                      $('#validationCustom22').append("<option value="+obj[i].slot_name+">"+obj[i].slot_name+"</option>");
                  }
              }

            }
      });

    });
    $('#validationCustom22').change(function(){
      var id = this.value;
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("restaurant.slot.getPrice")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: {
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
              var uh = JSON.stringify(response);
              var obj = JSON.parse(uh);
              for(i=0; i<uh.length; i++) {
                $('#price').append("<p class='text-danger' name='id' value="+obj[i].id+">Banner Rs.. "+obj[i].price+"</p>","<input type='hidden' name='price' value="+obj[i].price+">","<input type='hidden' name='id' value="+obj[i].id+">");
              }

            }
      });
    });
</script>
<script>
  (function($) {

  })(jQuery);
</script>
@endsection
