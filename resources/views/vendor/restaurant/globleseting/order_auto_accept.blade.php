<?php
$breadcrumb[] = ["name"  => " Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Globle Setting",
                 'route' => route('restaurant.globleseting.ordertime')];
$breadcrumb[] = ["name"  => "Dining",
                 'route' => ""];
?>
@extends('vendor.restaurants-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])
                {{--                <nav aria-label="breadcrumb">--}}
                {{--                    <ol class="breadcrumb pl-0">--}}
                {{--                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>--}}
                {{--                        <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>--}}
                {{--                        <li class="breadcrumb-item"><a href="#">Dining</a></li>--}}
                {{--                    </ol>--}}
                {{--                </nav>--}}
            </div>

            @include('vendor.restaurant.globleseting.setting_menu')

            <div class="col-md-9">
                <form id="restaurent_status_form">
                    @csrf
                    <div class="ms-panel">
                        <div class="ms-panel-header">
                            <h6>Order Automatically send for preparation
                                <label class="ms-switch right" style="float: right">
                                    <input name="is_auto_send_for_prepare" id="vendor_table_service" type="checkbox"
                                           value="1"
                                           @if (Auth::guard('vendor')->user()->is_auto_send_for_prepare == 1) checked @endif>
                                    <span class="ms-switch-slider"></span>
                                </label>
                            </h6>
                        </div>
                        <div class="ms-panel-body">
<code>Sum of All Preparation Time of Products for particular Order will be order preparation time </code>
                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submit_vendor() {

            $.ajax({
                url: '{{ route('restaurant.order.save_order_auto_accept') }}',
                type: 'post',
                cache: false,
                data:{'_token' : '<?php echo csrf_token() ?>',
                    'is_auto_send_for_prepare' : $("#vendor_table_service").prop('checked')
                },
                // data: $('#restaurent_status_form').serialize(),
                success: function (data) {
// alert($("#vendor_table_service").prop('checked'));
                    if (data.msg != '') {
                        $("#vendor_table_service").val(data.rest_status);

                        // toastr.success(data.msg, 'Success');
                        Swal.fire({
                            // position: 'top-end',
                            type: 'success',
                            title: data.msg,
                            showConfirmButton: true,
                            timer: 15000
                        });

                        @if (!isset($table_service->id))
                        $("#dine_out_full_form").submit();
                        @endif

                    } else
                        toastr.error('Some thing went wrong', 'Error');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.error('Some thing went wrong', 'Error');
                }
            });
        }

        $("#vendor_table_service").on("change", submit_vendor);

        function submit_dien_out() {
            $.ajax({
                url: '{{ route('restaurant.dineout.dine_out_setting') }}',
                type: 'post',
                cache: false,
                data: $('#dine_out_form').serialize(),
                success: function (data) {
                    if (data.msg != '') {
                        toastr.success(data.msg, 'Success');
                    } else
                        toastr.error('Some thing went wrong', 'Error');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.error('Some thing went wrong', 'Error');
                }
            });
        }

        $("#restaurent_status_id").on("change", submit_dien_out);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

    <script>
        (function ($) {


            // $("#dine_out_full_form").validate({
            //     rules: {
            //         no_guest: {
            //             required: true
            //         },
            //         slot_time: {
            //             required: true
            //         },
            //         slot_discount: {
            //             required: true
            //         }
            //     },
            //     messages: {
            //         no_guest: {
            //             required: "Number of guest is required"
            //         },
            //         slot_time: {
            //             required: "slot time is Required",
            //         },
            //         slot_discount: {
            //             required: "Discount is required",
            //         }
            //     }
            // });
        })(jQuery);
    </script>
@endpush

@section('page-css')
    <style>
        .error {
            width: 100%;
            color: red;
        }

        ;
    </style>
@endsection
