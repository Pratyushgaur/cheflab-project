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
                {{--                        <li class="breadcrumb-item"><a href="#">Global Setting</a></li>--}}
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
                            <code>The Automatically Accept Order Feature Accept your order automatically and set prepration time as defined by you</code>
                            <!-- Sum of All Preparation Time of Products for particular Order will be order preparation time  -->
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="modal-confirm" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h3 class="modal-title has-icon text-white">Select Prepration time for automatic set in accept order </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <select name="" id="" class="form-control prepration_time">
                                <option value="10">10 Minute</option>
                                <option value="20">20 Minute</option>
                                <option value="30">30 Minute</option>
                                <option value="40">40 Minute</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary shadow-none save" data-id="" {{--data-dismiss="modal"--}} id="" data-url="">
                                Save
                            </button>
                        </div>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submit_vendor(checkbox) {
            
            if(checkbox){
                $('#vendor_table_service').prop('checked',false);
                $('#modal-confirm').modal('show');
            }else{
                $.ajax({
                    url: '{{ route('restaurant.order.save_order_auto_accept') }}',
                    type: 'post',
                    cache: false,
                    data:{'_token' : '<?php echo csrf_token() ?>',
                        'is_auto_send_for_prepare' : $("#vendor_table_service").prop('checked'),
                        'prepration_time'          : ''
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
            
        }
        $('.save').click(function(){
            var prepration =  $('.prepration_time').val();
            $('#vendor_table_service').prop('checked',true);
            $.ajax({
                    url: '{{ route('restaurant.order.save_order_auto_accept') }}',
                    type: 'post',
                    cache: false,
                    data:{'_token' : '<?php echo csrf_token() ?>',
                        'is_auto_send_for_prepare' : 'true',
                        'prepration_time'          : prepration
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
                            $('#modal-confirm').modal('hide');
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
        })
        $("#vendor_table_service").on("change", function(){
            submit_vendor($(this).prop('checked'));
        });

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
