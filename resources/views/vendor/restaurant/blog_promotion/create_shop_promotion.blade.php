<?php
$breadcrumb[] = ["name"  => "Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Shop Promotion management",
                 'route' => route("restaurant.shop.promotion")];
$breadcrumb[] = ["name"  => "Create",
                 'route' => ''];

?>
@extends('vendor.restaurants-layout')
@section('main-content')
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Create New Shop Promotion</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form class=" clearfix " id="coupon-form" action="{{route('restaurant.shop.promotion.save')}}"
                              method="post" enctype="multipart/form-data">
                            @csrf

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            <div class="form-row">
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Date</label>
                                    <div class="input-group">
                                        <input type="date" name="date" class="form-control" id="datepicker"
                                               placeholder="Promotion Date From">

                                    </div>
                                    <span class="date_error text-danger"></span>
                                </div>
                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Select Place</label>
                                    <div class="input-group">
                                        {{ Form::select('app_promotion_blog_id',$app_promotion,null,['class' => 'form-control','id'=>'app_promotion_blog_id', 'placeholder' => 'Select Place ']) }}
                                    </div>
                                    <span class="banner_error text-danger"></span>
                                    <div id="price">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Select time frame for promotion *</label>
                                    <div class="input-group">
                                        {{ Form::select('booked_for_time', config('custom_app_setting.blog_promotion_date_frame'), null, ['class'=>"form-control", 'id' => 'time_frame','placeholder'=>'Select Time Frame']) }}
                                    </div>
                                    <span class="banner_error text-danger"></span>
                                </div>


                                <div class="col-xl-6 col-md-6 mb-3">
                                    <label for="validationCustom10">Select Place *</label>
                                    <div class="input-group">
                                        {{ Form::select('position', [], null,['class'=>"form-control", 'id' => 'position','placeholder'=>'Select Slide Position']) }}
                                        {{--                                        <select class="form-control" name="position" id="validationCustom22">--}}

                                        {{--                                        </select>--}}
                                    </div>
                                    <span class="banner_error text-danger"></span>
                                    <div id="price">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
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

    <script>


    </script>

    <script type="text/javascript">
        $("#coupon-form").validate({
            rules: {
                date: {
                    required: true
                },
                app_promotion_blog_id: {
                    required: true
                },
                position: {
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


        function get_positions() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    type: "POST",
                    url: '{{route("restaurant.shop.promotion.positions")}}', // This is what I have updated
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "app_promotion_blog_id": $("#app_promotion_blog_id").val(),
                        "date": $("#datepicker").val(),
                        "time_frame": $("#time_frame").val()
                    },
                    success: function (response) {
                        $('#position').html('');
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
                            $('#position').append("<option value=''>Select Position</option>");
                            for (i = 0; i < uh.length; i++) {
                                $('#position').append("<option value=" + obj[i].id + ">" + obj[i].name + "</option>");
                            }
                        }

                    }
                }
            );
        }

        $('#datepicker').datepicker({

            dateFormat: "yy-mm-dd",
            minDate: -0
        });
        // min="2022-09-23" max="2022-09-28"
    </script>
    <script>
        $(function () {

            $('#datepicker').on('change', get_positions);
            $('#app_promotion_blog_id').on('change', get_positions);
            $('#time_frame').change(get_positions);

        });
    </script>
@endsection
