@extends('vendor.restaurants-layout')
@section('main-content')
    <?php
    $status_class['pending'] = 'primary';
    $status_class['accepted'] = 'warning';
    $status_class['preparing'] = 'secondary';
    $status_class['ready_to_dispatch'] = 'info';
    $status_class['dispatched'] = 'success';
    $status_class['completed'] = 'success';
    $status_class['payment_pending'] = 'warning';
    $status_class['cancelled_by_vendor'] = 'danger';
    $status_class['cancelled_by_customer'] = 'danger';

    ?>
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
                    </ol>
                </nav>
            </div>
{{--            <div class="col-md-12">--}}
{{--                <div class="ms-panel">--}}
{{--                    <div class="ms-panel-header">--}}
{{--                        <h6>Order Details</h6>--}}
{{--                    </div>--}}
{{--                    <div class="ms-panel-body">--}}

{{--                        <div id="arrowSlider" class="ms-arrow-slider carousel slide" data-ride="carousel"--}}
{{--                             data-interval="false">--}}
{{--                            <div class="carousel-inner">--}}
{{--                                @foreach($order->order_product_details as $k=>$order_product_details)--}}
{{--                                    <div class="carousel-item">--}}
{{--                                        <img class="d-block w-100"--}}
{{--                                             src="{{asset('products')."/$order_product_details->product_image"}}"--}}
{{--                                             alt="Second slide">--}}
{{--                                        <div class="carousel-caption d-none d-md-block">--}}
{{--                                            <h3 class="text-white">{{$order_product_details->name}}</h3>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            <a class="carousel-control-prev" href="#arrowSlider" role="button" data-slide="prev">--}}
{{--                                <span class="material-icons" aria-hidden="true">keyboard_arrow_left</span>--}}
{{--                                <span class="sr-only">Previous</span>--}}
{{--                            </a>--}}
{{--                            <a class="carousel-control-next" href="#arrowSlider" role="button" data-slide="next">--}}
{{--                                <span class="material-icons" aria-hidden="true">keyboard_arrow_right</span>--}}
{{--                                <span class="sr-only">Next</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


            <div class=" col-md-6">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h4 class="section-title bold">Customer Detail</h4>
                    </div>
                    <div class="ms-panel-body">

                        <table class="table ms-profile-information">
                            <tbody>

                            <tr>
                                <th style="border: 0 !important;" scope="row">Name</th>
                                <td style="border: 0 !important;">{{$order->user->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile no.</th>
                                <td>{{$order->user->mobile_number.',',$order->user->alternative_number}}</td>
                            </tr>
                            </tbody>
                        </table>
                        {{--                        <div class="new">--}}
                        {{--                            <button type="button" class="btn btn-primary">Edit</button>--}}
                        {{--                            <button type="button" class="btn btn-secondary">Delete</button>--}}
                        {{--                        </div>--}}

                    </div>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h4 class="section-title bold">Deliver To </h4>
                    </div>
                    <div class="ms-panel-body">
                        <table class="table ms-profile-information">
                            <tbody>
                            <tr>
                                <th style="border: 0 !important;" scope="row">Name</th>
                                <td style="border: 0 !important;">{{$order->customer_name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile no.</th>
                                <td>{{$order->delivery_address}}</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #dee2e6 !important;">
                                <th scope="row">Pincode</th>
                                <td>{{$order->pincode}}</td>
                            </tr>

                            <tr>
                                <th style="border-bottom: 0px  !important;" scope="row">Status</th>
                                <td class="left-side" style="float: right;border-bottom: 0px  !important;">
                                    <div class="input-group">
                                        <div class="">
                                            <button
                                                class="btn {{'btn-'.@$status_class[$order->order_status]}}  dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"
                                                id="{{$order->id}}"
                                                style="padding: 0.25rem 0.5rem !important;  line-height: 1 !important;">{{ucfirst(str_replace('_',' ',$order->order_status))}} </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item  {{'ms-text-'.$status_class['accepted']}}"
                                                   onclick="ajax_post_on_link('{{route('restaurant.order.accept',[$order->id])}}',{{$order->id}})">Accept</a>
                                                <a class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}"
                                                   onclick="ajax_post_on_link('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})">Reject</a>
                                                <a  data-toggle="modal" data-target="#modal-7"
                                                    class="dropdown-item {{'ms-text-'.$status_class['preparing']}}"
                                                    onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})"
                                                >Preparing</a>
                                                <a class="dropdown-item {{'ms-text-'.$status_class['ready_to_dispatch']}}"
                                                   onclick="ajax_post_on_link('{{route('restaurant.order.ready_to_dispatch',[$order->id])}}',{{$order->id}})">Ready
                                                    To Dispatch</a>
                                                <a class="dropdown-item {{'ms-text-'.$status_class['dispatched']}}"
                                                   onclick="ajax_post_on_link('{{route('restaurant.order.dispatched',[$order->id])}}',{{$order->id}})">Dispatched</a>
                                            </div>
                                        </div>

                                    </div>

                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <div class="ms-content-wrapper">--}}
    {{--        <div class="row">--}}
    <div class="col-md-12">
        <div class="ms-panel">
            <div class="ms-panel-header">
                <h4 class="section-title bold">Order Detail</h4>
            </div>
            <div class="ms-panel-body">
                <!-- Invoice Table -->
                <div class="ms-invoice-table table-responsive mt-5">
                    <table class="table table-hover text-right thead-light">
                        <thead>
                        <tr class="text-capitalize">
                            <th class="text-center w-5">id</th>
                            <th class="text-left">description</th>
                            <th>qty</th>
                            <th>Unit Cost</th>
                            <th>total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $k=>$product)
                            <tr>
                                <td class="text-center">{{$k}}</td>
                                <td class="text-left">Product : {{$product->product_name}}
                                    <?php

                                    $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $product->id)->get();
                                    if (!$OrderProductVariant) {
                                        echo "<br/> Variant : $OrderProductVariant->variant_name";

                                        $unit_price = $OrderProductVariant->variant_price / $OrderProductVariant->variant_qty;
                                        $price = $OrderProductVariant->variant_price;
                                    } else {
                                        $unit_price = @(@$product->product_price / @$product->product_qty);
                                        $price = $product->product_price;
                                    }

                                    ?>
                                    <br/>

                                </td>
                                <td>{{$product->product_qty}}</td>
                                <td><?php echo "&#8377;" . $unit_price;?></td>
                                <td><?php echo "&#8377;" . $price;?></td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">Total:</td>
                            <td><b><?php echo "&#8377;" . $order->total_amount;?></b></td>
                        </tr>

                        <tr>
                            <td colspan="4">Discount:</td>
                            <td>-<?php echo "&#8377; " . $order->discount_amount;?></td>
                        </tr>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">Net Amount:</td>
                            <td><b><?php echo "&#8377;" . $order->net_amount;?></b></td>
                        </tr>
                        </tfoot>
                    </table>
                    <div class="modal-footer">
                        <a href="{{route('restaurant.order.list')}}" class="btn btn-light" >Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--        </div>--}}
    {{--    </div>--}}

@endsection
@push('model')

    <div class="modal fade" id="modal-7" tabindex="-1" role="dialog" aria-labelledby="modal-7" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="preparation_form">
                    @csrf
                    <div class="modal-header bg-primary">
                        <h3 class="modal-title has-icon text-white"> Order Preparation</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="ms-form-group has-icon">
                            <label>Order preparation time</label>
                            <input type="number" placeholder="preparation time in minutes" class="form-control" name="preparation_time" value="" step="2" min="10">
                            <i class="material-icons">timer</i>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-none"
                                {{--                            data-dismiss="modal"--}}
                                id="submit_model" >Submit</button>
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
                        $("#" + id).text(data.order_status.replace('_', ' '));
                        <?php
                        $if_stat = '';
                        foreach ($status_class as $status => $class) {
                            $remove_class = "btn-$class ";
                            $if_stat .= "if(data.order_status=='$status')";
                            $if_stat .= " $('#'+id).addClass('btn-$class');";

                        }?>
                        $("#" + id).removeClass('{{$remove_class}}');
                        <?php echo $if_stat;?>
                        toastr.success(data.msg, 'Success');
                    } else
                        toastr.info('Something went wrong', 'Info');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.info('Something went wrong', 'Info');
                }
            });
        }

        $('#modal-7').modal({ show: false})

        // $( "#modal-7" ).on('shown', function(){
        //     alert("I want this to appear after the modal has opened!");
        // });

        function preparation_form(url, id) {
            $('#preparation_form').attr('action', url);
            $('#myModal').modal('show');
        }

    </script>

    <!-- Page Specific CSS (Slick Slider.css) -->
    <link href="{{ asset('frontend') }}/assets/css/slick.css" rel="stylesheet">

    <!-- Page Specific Scripts Start -->
    <script src="{{ asset('frontend') }}/assets/js/slick.min.js"> </script>
    <script src="{{ asset('frontend') }}/assets/js/moment.js"> </script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.webticker.min.js"> </script>
    <script src="{{ asset('frontend') }}/assets/js/Chart.bundle.min.js"> </script>
    <script src="{{ asset('frontend') }}/assets/js/Chart.Financial.js"> </script>
@endpush
