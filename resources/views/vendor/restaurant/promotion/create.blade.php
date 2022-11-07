@extends('vendor.restaurants-layout')
@section('main-content')

    <style>
        .select2-selection__choice {
            background: #ff0018;
        }

        .select2-selection__choice__display {
            color: #fff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ff0018;
        }

        .image-upload {
            display: inline-block;
            margin-right: 15px;
            position: relative;
        }

        .image-upload > input {
            display: none;
        }

        .upload-icon {
            width: 450px;
            height: 150px;
            border: 2px solid #000;
            border-style: dotted;
            border-radius: 18px;
        }


        .upload-icon img {
            width: 300px;
            height: 100px;
            margin: 19px;
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
            margin: 0px;
        }
    </style>
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Promotion</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="#">Create Promotion</a></li>


                    </ol>
                </nav>
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Create New Promotion</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form class=" clearfix " id="coupon-form" action="{{route('restaurant.slot.store')}}"
                              method="post" enctype="multipart/form-data">
                            @csrf

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif

                            <div class="form-row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Promotion for *</label>
                                    <div class="input-group">
                                        {{ Form::select('for', $for, null,['class'=>"form-control", 'id' => 'banner_for','placeholder'=>'Select Slide shows in section']) }}
                                    </div>
                                    <span class="banner_error text-danger"></span>

                                </div>


                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Start Time *</label>
                                    <div class="input-group">
                                        <input type="text" name="date" class="form-control" id="datepicker"
                                               placeholder="Enter Date">
                                    </div>
                                    {{--                                    <span class="date_error text-danger"></span>--}}
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Select Date frame for promotion *</label>
                                    <div class="input-group">
                                        {{ Form::select('booked_for', config('custom_app_setting.promotion_date_frame'), null, ['class'=>"form-control", 'id' => 'date_frame','placeholder'=>'Select Date Frame']) }}
                                    </div>
                                    <span class="banner_error text-danger"></span>
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Select time frame for promotion *</label>
                                    <div class="input-group">
                                        {{ Form::select('booked_for_time', config('custom_app_setting.promotion_restaurant_time'), null, ['class'=>"form-control", 'id' => 'time_frame','placeholder'=>'Select Time Frame']) }}
                                    </div>
                                    <span class="banner_error text-danger"></span>
                                </div>


                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Select Place *</label>
                                    <div class="input-group">
                                        {{ Form::select('position', [], null,
 ['class'=>"form-control", 'id' => 'validationCustom22','placeholder'=>'Select Slide Position']) }}
                                        {{--                                        <select class="form-control" name="position" id="validationCustom22">--}}

                                        {{--                                        </select>--}}
                                    </div>
                                    <span class="banner_error text-danger"></span>
                                    <div id="price">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-12">
                                    <div>
                                        <label for="">Images *</label>
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

    <script>


    </script>

    <script type="text/javascript">
        $("#coupon-form").validate({
            rules: {
                date: {
                    required: true
                },
                booked_for: {
                    required: true
                },
                slot_image: {
                    required: true
                }
            },
            messages: {
                date: {
                    required: "Date is required"
                },
                slot_image: {
                    required: "Image is Required"
                }
            }
            // ,
            // errorPlacement: function (error, element) {
            //     var date = $(element).attr("date");
            //
            //     error.appendTo($("." + date + "_error"));
            // },
        });
        $('#file-input').change(function (event) {
            $("img.icon").attr('src', URL.createObjectURL(event.target.files[0]));
            $("img.icon").parents('.upload-icon').addClass('has-img');
        });
        $('#row_dim').hide();
        $('#type').change(function () {
            if ($('#type').val() == 'product') {
                $('#row_dim').show();
            } else {
                $('#row_dim').hide();
            }
        });

        function get_positions() {
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
                        "id": $("#date_frame").val(),
                        "date": $("#datepicker").val(),
                        "time": $("#time_frame").val(),
                        "banner_for": $("#banner_for").val()
                    },
                    success: function (response) {
                        $('#validationCustom22').html('');
                        var resp = JSON.stringify(response);

                        var len = resp;
                        // if (len == 'false') {
                        if (response['status'] == false) {
                            if (response['message'] != '')
                                toastr.error(response['message'], 'Alert');
                        } else {
                            var uh = JSON.stringify(response);
                            console.log(uh);
                            var obj = JSON.parse(uh);
                            $('#validationCustom22').append("<option value=''>Select Slide Position</option>");
                            for (i = 0; i < uh.length; i++) {
                                $('#validationCustom22').append("<option value=" + obj[i].id + ">" + obj[i].slot_name + "</option>");
                            }
                        }

                    }
                }
            );
        }

        $('#validationCustom22').change(function () {
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
                    "id": id
                },
                success: function (response) {
                    var uh = JSON.stringify(response);
                    var obj = JSON.parse(uh);
                    $('#price').append("<p class='text-danger' name='id' value=" + obj.id + ">Banner Rs.. " + obj.price + "</p>", "<input type='hidden' name='price' value=" + obj.price + ">", "<input type='hidden' name='id' value=" + obj.id + ">", "<input type='hidden' name='slot_name' value=" + obj.slot_name + ">", "<input type='hidden' name='position' value=" + obj.position + ">");
                }
            });
            $('#price').empty().append();
        });
        $('#datepicker').datepicker({

            dateFormat: "yy-mm-dd",
            maxDate: '+7d',
            minDate: -0
        });

        // min="2022-09-23" max="2022-09-28"
    </script>
    <script>
        $(function () {

            $('#datepicker').on('change', get_positions);
            $('#time_frame').on('change', get_positions);
            $('#date_frame').change(get_positions);

        });
    </script>
@endsection
