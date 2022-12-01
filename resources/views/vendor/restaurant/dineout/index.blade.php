<?php
$breadcrumb[] = ["name"  => " Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Dining",
                 'route' => route("restaurant.dineout.setting")];
$breadcrumb[] = ["name"  => "Booking Request List",
                 'route' => ""];
?>
@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])

            </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Dining</h6>
                            </div>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        {{--                        <div class="col-xl-12 col-md-12">--}}
                        {{--                            <div class="ms-panel-body">--}}
                        {{--                        <p class="ms-directions">Use <code>.table-hover</code> in the <code>table</code></p>--}}
                        <div class="table-responsive">
                            <table class="table table-hover thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Number of guest</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                    <th scope="col">Discount %</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($TableServiceBookings as $k=>$TableServiceBooking)
                                    <tr>
                                        <th scope="row">{{$TableServiceBooking->id}}</th>
                                        <td>{{$TableServiceBooking->name}}</td>
                                        <td>{{$TableServiceBooking->booked_no_guest}}</td>
                                        <td>{{front_end_date_time($TableServiceBooking->booked_slot_time_from)}}</td>
                                        <td>{{front_end_date_time($TableServiceBooking->booked_slot_time_to)}}</td>
                                        <td>{{$TableServiceBooking->booked_slot_discount}}</td>
                                        <td>
                                            <div class="input-group">
                                                <div class="">
                                                    <button
                                                        class="btn btn-sm <?php
                                                        switch ($TableServiceBooking->booking_status) {
                                                            case "pending":
                                                                echo "btn-primary";
                                                                break;

                                                            case "accepted":
                                                                echo "btn-success";
                                                                break;
                                                            case "rejected":
                                                                echo "btn-dark";
                                                                break;
                                                        }
                                                        ?>  dropdown-toggle" type="button" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false" id="{{$TableServiceBooking->id}}">{{ucfirst($TableServiceBooking->booking_status)}}
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item ms-text-success" onclick="ajax_post_on_link('{{route('restaurant.dineout.accept',[$TableServiceBooking->id])}}',{{$TableServiceBooking->id}})">Accept</a>
{{--                                                        <a class="dropdown-item ms-text-danger" onclick="ajax_post_on_link('{{route('restaurant.dineout.reject',[$TableServiceBooking->id])}}',{{$TableServiceBooking->id}})">Reject</a>--}}

                                                        <a data-toggle="modal" data-target="#modal-5" class="dropdown-item  ms-text-danger" onclick="preparation_form('{{route('restaurant.dineout.reject',[$TableServiceBooking->id])}}', {{$TableServiceBooking->id}}, '{{"#".$TableServiceBooking->id." request for ".$TableServiceBooking->booked_no_guest." guest, Time: ".front_end_date_time($TableServiceBooking->booked_slot_time_from)."-".front_end_date_time($TableServiceBooking->booked_slot_time_to)}}')">Reject</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="">{{ $TableServiceBookings->links('vendor.pagination.bootstrap-4') }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


@push('model')
    <div class="modal fade" id="modal-5" tabindex="-1" role="dialog" aria-labelledby="modal-5">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="dineout_form" action="#" method="post">
                    @csrf
                    <input type="hidden" id="dineout_id" value="">
                    <div class="modal-header bg-primary">
                        <h3 class="modal-title has-icon text-white"><i class="flaticon-alert-1"></i> Reject Dine-out Request!
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <p id="dine-out-msg"></p>
                        <textarea class="form-control" name="reject_reason">{{$admin_master->dine_out_reject_reason}}</textarea>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" name="" value="Submit" class="btn btn-primary shadow-none">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
{{--                        <button type="submit" class="btn btn-primary shadow-none" data-dismiss="modal">Reject booking request</button>--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        function ajax_post_on_link(url, id) {

            $.ajax({
                url: url,
                type: 'post',
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (data) {
                    if (data.msg != '') {
                        $("#" + id).text(data.booking_status);
                        if (data.booking_status == 'Accepted') {
                            $("#" + id).removeClass('btn-success btn-primary btn-dark');
                            $("#" + id).addClass('btn-success');
                        } else {
                            $("#" + id).removeClass('btn-success btn-primary btn-dark');
                            $("#" + id).addClass('btn-dark');
                        }
                        toastr.success(data.msg, 'Success');
                    } else
                        toastr.info('Somethin went wrong', 'Info');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.info('Somethin went wrong', 'Info');
                }
            });
        }


        function preparation_form(url, id,msg) {
            $("#dineout_id").val(id);
            $("#dineout_form").prop('action',url);
            $("#dine-out-msg").html(msg),
            $('#myModal').modal('show');
        }

    </script>
@endpush
