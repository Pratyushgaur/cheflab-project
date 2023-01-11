<?php
$breadcrumb[] = ["name"  => "Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Promotion management",
                 'route' => route("restaurant.promotion.list")];
$breadcrumb[] = ["name"  => "List",
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
                                <h6>Promotion</h6>
                            </div>
                            <a href="{{route('restaurant.promotion.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <div class="">
                            <table id="menu-catalogue-table" class="table thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">S.No.</th>
                                    <th scope="col">Slot</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">From Date</th>
                                    <th scope="col">To Date</th>
                                    <th scope="col">From time</th>
                                    <th scope="col">To time</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Status</th>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($banners)<0)
                                    <tr>
                                        <td colspan="6">No record found</td>
                                    </tr>
                                @endif
                                @foreach($banners as $key=>$banner)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>{{$banner->name}}</td>
                                        <td>
                                            <img src="{{ asset('slot-vendor-image').'/'.$banner->slot_image }}" style='width: 50px;'/>
                                        </td>
                                        <td>{{$banner->from_date}}</td>
                                        <td>{{$banner->to_date}}</td>
                                        <td>{{$banner->from_time}}</td>
                                        <td>{{$banner->to_time}}</td>
                                        <td>{{$banner->position}}</td>
                                        <td><?php
                                            if (!empty($banner->is_active) && ($banner->is_active == 1))
                                                echo '<span class="badge badge-success">Active</span>';
                                            else if (!empty($banner->is_active) && ($banner->is_active == 2))
                                                echo '<span class="badge badge-danger">Rejected</span><br/>'.$banner->comment_reason;
                                            else
                                                echo '<span class="badge badge-primary">Pending</span>';

                                            ?></td>
                                        <td>
                                        @if($banner->payment_status!='0' && !(!empty($banner->is_active) && ($banner->is_active == 2)))
                                            <!-- <div class="panel-body text-center"> -->
                                                <form action="{!!route('payment')!!}" method="POST">
                                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                            data-key="{{ env('RAZOR_KEY') }}"
                                                            data-amount="{{($banner->price*100)}}"
                                                            data-buttontext="Pay {{($banner->price)}} INR"
                                                            data-name="{{ env('APP_NAME') }}"
                                                            data-description="Payment for Banner Promotion :{{"'".$banner->name."' for position ".$banner->position}}"
                                                            data-prefill.name="{{$banner->name}}"
                                                            data-prefill.email="{{\Auth::guard('vendor')->user()->email}}"
                                                            data-prefill.contact="{{\Auth::guard('vendor')->user()->mobile}}"
                                                            data-theme.color="#ff7529">
                                                    </script>
                                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                                    <input type="hidden" name="id" value="{{$banner->id}}">

                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@section('page-js')
    <script>
        (function ($) {
            {{--let table = $('#menu-catalogue-table').dataTable({--}}
            {{--    processing: true,--}}
            {{--    serverSide: true,--}}
            {{--    ajax: "{{ route('restaurant.slot.list') }}",--}}
            {{--    columns: [--}}
            {{--        {data: 'DT_RowIndex', name: 'DT_RowIndex'},--}}
            {{--        {data: 'name', name: 'name'},--}}
            {{--        {data: 'slot_image', name: 'slot_image', orderable: false, searchable: false},--}}
            {{--        {data: 'from_date', name: 'from_date'},--}}
            {{--        {data: 'to_date', name: 'to_date'},--}}
            {{--        {data: 'from_time', name: 'from_time'},--}}
            {{--        {data: 'to_time', name: 'to_time'},--}}
            {{--        {data: 'position', name: 'position'},--}}
            {{--        {data: 'is_active', name: 'is_active'},--}}
            {{--        {data: 'payment', name: 'payment'},--}}

            {{--    ]--}}
            {{--});--}}
            $('#menu-catalogue-table').dataTable();
        })(jQuery);
    </script>
@endsection
