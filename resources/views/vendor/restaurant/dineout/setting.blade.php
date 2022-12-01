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
                            <h6>Enable Dining Setting
                                <label class="ms-switch right" style="float: right">
                                    <input name="vendor_table_service" id="vendor_table_service" type="checkbox"
                                           value="1"
                                           @if (Auth::guard('vendor')->user()->table_service == 1) checked @endif>
                                    <span class="ms-switch-slider"></span>
                                </label>
                            </h6>
                        </div>
                        <div class="ms-panel-body">

                        </div>
                    </div>
                </form>
                <form id="dine_out_form">
                    @csrf
                    <div class="ms-panel">
                        <div class="ms-panel-header">
                            <h6>Active
                                @if (isset($table_service->id) && $table_service->id != '')
                                    <label class="ms-switch right" style="float: right">
                                        <input name="is_active" id="restaurent_status_id" type="checkbox" value="1"
                                               @if ($table_service->is_active == 1) checked @endif>
                                        <span class="ms-switch-slider"></span>
                                    </label>
                                @endif

                            </h6>
                        </div>
                </form>
                <div class="ms-panel-body">
                    @include('vendor.restaurant.alertMsg')

                    {!! Form::model($table_service, [
                        'route' => ['restaurant.dineout.update'],
                        'method' => 'post',
                        'id' => 'dine_out_full_form',
                    ]) !!}

                    @csrf

                    {{-- Location form start --}}
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Maximum number of guest allowed</label>
                            <div class="input-group">
                                {{ Form::number('no_guest', null, ['class' => 'form-control', 'required', 'placeholder' => 'Select Slot Time ', 'min' => 1]) }}

                                @if ($errors->has('no_guest'))
                                    <span class="ms-text-danger">
                                        <strong>{{ $errors->first('no_guest') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Slot Time</label>
                            <div class="input-group">
                                {{ Form::select(
                                    'slot_time',
                                    [
                                        '30' => '30 Minutes',
                                        '45' => '45 Minutes',
                                        '60' => '1 Hour',
                                        '75' => '1 Hour 15 Minutes',
                                        '90' => '1 Hour 30 Minutes',
                                        '105' => '1 Hour 45 Minutes',
                                        '120' => '2 Hours',
                                    ],
                                    null,
                                    ['class' => 'form-control', 'placeholder' => 'Select Slot Time '],
                                ) }}

                                @if ($errors->has('slot_time'))
                                    <span class="ms-text-danger">
                                        <strong>{{ $errors->first('slot_time') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
{{--                        <div class="col-md-12 mb-3">--}}
{{--                            <label>Discount %</label>--}}
{{--                            <div class="input-group">--}}
{{--                                {{ Form::number('slot_discount', null, ['class' => 'form-control', 'placeholder' => 'Discount %', 'min' => '0']) }}--}}

{{--                                @if ($errors->has('slot_discount'))--}}
{{--                                    <span class="ms-text-danger">--}}
{{--                                        <strong>{{ $errors->first('slot_discount') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="col-md-12 mb-12">

                            <?php
                            $days[0] = "sunday";
                            $days[1] = "monday";
                            $days[2] = "tuesday";
                            $days[3] = "wednesday";
                            $days[4] = "thursday";
                            $days[5] = "friday";
                            $days[6] = "saturday";
                            ?>

                            <table class="table table-hover thead-primary">
                                <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Discount Percentage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php //dd($TableServiceDiscount);?>
                                @for($i=0;$i<=6;$i++)
                                    <tr>
                                        <th>{{ucwords($days[$i])}}</th>
                                        <th>{{Form::number("discount_percent[$i]", old("discount_percent[$i]",@$TableServiceDiscount[$i]->discount_percent),['class'=>'form-control','required'])}}</th>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{-- Location form end --}}

                    <div class="form-row">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submit_vendor() {

            $.ajax({
                url: '{{ route('restaurant.dineout.vendor_table_setting') }}',
                type: 'post',
                cache: false,
                data:{'_token' : '<?php echo csrf_token() ?>',
                    'vendor_table_service' : $("#vendor_table_service").prop('checked')
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


            $("#dine_out_full_form").validate({
                rules: {
                    no_guest: {
                        required: true
                    },
                    slot_time: {
                        required: true
                    },
                    slot_discount: {
                        required: true
                    }
                },
                messages: {
                    no_guest: {
                        required: "Number of guest is required"
                    },
                    slot_time: {
                        required: "slot time is Required",
                    },
                    slot_discount: {
                        required: "Discount is required",
                    }
                }
            });
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
