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
    $status_class['confirmed'] = 'info';


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


            <div class="ms-panel col-md-8">
                <div class="ms-panel-header header-mini">
                    <div class="d-flex justify-content-between">
                        <h6>Order Id</h6>
                        <h6>#{{$order->order_id}}</h6>
                    </div>
                </div>
                <div class="ms-panel-body">
                    <!-- Invoice To -->
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="invoice-address">
                                <h3>Reciever: </h3>
                                <h5>{{$order->customer_name}}</h5>
                                <p>{{$order->mobile_number}}</p>
                                @if (isset($order->lat) && isset($order->long))
                                    <a target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$order->lat }}+{{$order->long }}">
                                        {{ trim($order->delivery_address) }}
                                    </a>
                                @else
                                    <p>{{ $order->delivery_address }}</p>
                                @endif
                                <p class="mb-0"><b>Landmark address :</b> {{$order->landmark_address}}</p>
                                <!-- <p class="mb-0"><b>Pincode :</b> {{$order->pincode}}</p>
                                <p class="mb-0"><b>City :</b> {{$order->pincode}}</p> -->
                                <p class="mb-0"><b>Send Cutlery :</b> <?php if($order->send_cutlery == '1'){echo 'Yes';}else{echo 'No';} ?></p>
                                <p class="mb-0"><b>Message to Chef :</b> <?php echo $order->chef_message ; ?></p>

                            </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <ul class="invoice-date">
                                <li><b>Invoice Date :</b> {{front_end_date($order->created_at)}}</li>
                                {{--                                <li>Due Date : Sunday, April 19 2020</li>--}}
                            </ul>
                        </div>
                    </div>
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
                                    <td class="text-center">
                                        <?php
                                            
                                        $Product_master = \App\Models\Product_master::withTrashed()->find($product->product_id);
                                        echo "<img style='max-width: 100px;max-hieght: 100px;' src='" . url('/') . '/products/' . $Product_master->product_image . "'>";

                                        ?></td>
                                    </td>
                                    <td class="text-left"> <b>Product :</b> {{$product->product_name}}
                                        <?php

                                        $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $product->id)->first();
                                        if (!empty($OrderProductVariant) && $Product_master->customizable == 'true') {
                                           
                                            echo "<br/> <b>Variant :</b> $OrderProductVariant->variant_name";

                                            $unit_price = $OrderProductVariant->variant_price;
                                            $price      = $OrderProductVariant->variant_price*$OrderProductVariant->variant_qty;
                                        } else {
                                            $unit_price = @(@$product->product_price);
                                            $price      = $product->product_price*$product->product_qty;
                                        }

                                        ?>
                                        <br/>

                                    </td>
                                    <td>{{$product->product_qty}}</td>
                                    <td><?php echo "&#8377;" . $unit_price;?></td>
                                    <td><?php echo "&#8377;" . $price;?></td>
                                </tr>
                                <?php
                                $addons=\App\Models\OrderProductAddon::join('addons','addons.id','order_product_addons.addon_id')->where('order_product_id',$product->id)->get();
//                                print_r($addon);
                                if(isset($addons[0])){
                                    foreach ($addons as $k1=>$addon)
                                        if(isset($addon->addon) && $addon->addon!=''){
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td class="text-left">{{"Addon : ".$addon->addon}}</td>
                                                <td>{{$addon->addon_qty}}</td>
                                                <td>{{($addon->addon_price)}}</td>
                                                <td>{{$addon->addon_price}}</td>
                                            </tr>
                                                                        <?php
                                        }
                                    }
                                ?>
                            @endforeach
                            <tr>
                                <td colspan="4">Items Total:</td>
                                <td><b><?php echo "&#8377; " . number_format($order->total_amount,2);?></b></td>
                            </tr>
                            <tr>
                                <td colspan="4">Tax & Charge:</td>
                                <td>&#8377; <?php echo number_format( (float)$order->tex+$order->platform_charges,2);?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Delivery Charge:</td>
                                <td>&#8377; <?php echo number_format( $order->delivery_charge,2);?></td>
                            </tr>
                            @if(!empty($coupon))
                            <tr>

                                <td colspan="4">Discount: <br>Coupon Applied <span class="text-success">({{$coupon->name}})</span></td>
                                <td>-<?php echo "&#8377; ";?> <?php echo number_format( $order->discount_amount,2);?></td>
                            </tr>
                            @endif
                            @if($order->wallet_apply)
                            <tr>

                                <td colspan="4">Wallet Apply:</td>
                                <td>-<?php echo "&#8377; ";?> <?php echo number_format( $order->wallet_cut,2);?></td>
                            </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4">Net Amount:</td>
                                <td><b><?php echo "&#8377; " . $order->net_amount;?></b></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="ms-panel {{--ms-panel-fh--}}">
                    <div class="ms-panel-header">
                        <h6>    <a style="width: 100%" href="{{route('restaurant.order.invoice',$order->id)}}" class="btn btn-primary">Send Invoice</a> </h6>
                    </div>
                    <div class="ms-panel-body p-0">
                        <ul class="ms-list ms-feed ms-twitter-feed">

                            <li class="ms-list-item">
                                <div class="media clearfix">
                                    {{--                                        <img src="{{url('/').'/dliver-boy/'.$rider->image}}" class="ms-img-round ms-img-small" alt="people">--}}
                                    <div class="media-body">
                                        <p><b>Payment Methode : </b>{{$order->payment_type}}</p>
                                        <p><b>Payment Staus : </b>
                                            @if($order->payment_status=='pending')
                                                <span class="badge badge-primary">Pending</span>
                                            @endif
                                            @if($order->payment_status=='paid')
                                                <span class="badge badge-success">Paid</span>
                                            @endif</p>
                                        <p><b>Status : </b>
                                        <div class="input-group">
                                            <div class="">
                                            <?php
                                                if($order->order_status == 'confirmed'){
                                                $status = 'Pending';
                                            }else{
                                                $status = $order->order_status;
                                            } ?>
                                                <button class="btn {{'btn-'.@$status_class[$order->order_status]}}  dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="{{$order->id}}" style="padding: 0.25rem 0.5rem !important;  line-height: 1 !important">{{ucfirst(str_replace('_',' ',$status))}}</button>
                                                <div class="dropdown-menu">

                                                    <?php
                                                    if($order->order_status == 'confirmed'){
                                                    ?>
                                                    <a data-toggle="modal" data-target="#modal-7" class="dropdown-item {{'ms-text-'.$status_class['preparing']}}" onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})">Preparing</a>
                                                    <a class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}" onclick="ajax_post_on_link('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})">Reject</a>
                                                    <?php }
                                                    if($order->order_status == 'preparing') {?>
                                                    <a class="dropdown-item {{'ms-text-'.$status_class['ready_to_dispatch']}}" onclick="ajax_post_on_link('{{route('restaurant.order.ready_to_dispatch',[$order->id])}}',{{$order->id}})">Ready
                                                        To Dispatch</a>
                                                    <?php }
//                                                    if($order->order_status == 'ready_to_dispatch') { ?>
{{--                                                    <a class="dropdown-item {{'ms-text-'.$status_class['dispatched']}}" onclick="ajax_post_on_link('{{route('restaurant.order.dispatched',[$order->id])}}',{{$order->id}})">Dispatched</a>--}}
                                                    <?php //}
                                                        if($order->order_status != 'completed' &&
                                                        $order->order_status != 'cancelled_by_customer_before_confirmed' &&
                                                        $order->order_status != 'cancelled_by_customer_after_confirmed' &&
                                                        $order->order_status != 'cancelled_by_vendor' &&
                                                        $order->order_status != 'dispatched'){?>

                                                    
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

{{--                                        <div class="input-group">--}}
{{--                                            <div class="">--}}
{{--                                                <button--}}
{{--                                                    class="btn {{'btn-'.@$status_class[$order->order_status]}}  dropdown-toggle btn-sm"--}}
{{--                                                    data-toggle="dropdown" aria-haspopup="true"--}}
{{--                                                    aria-expanded="false"--}}
{{--                                                    id="{{$order->id}}"--}}
{{--                                                    style="padding: 0.25rem 0.5rem !important;  line-height: 1 !important;">{{ucfirst(str_replace('_',' ',$order->order_status))}} </button>--}}
{{--                                                <div class="dropdown-menu">--}}
{{--                                                    <a class="dropdown-item  {{'ms-text-'.$status_class['accepted']}}"--}}
{{--                                                       onclick="ajax_post_on_link('{{route('restaurant.order.accept',[$order->id])}}',{{$order->id}})">Accept</a>--}}
{{--                                                    <a class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}"--}}
{{--                                                       onclick="ajax_post_on_link('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})">Reject</a>--}}
{{--                                                    <a data-toggle="modal" data-target="#modal-7"--}}
{{--                                                       class="dropdown-item {{'ms-text-'.$status_class['preparing']}}"--}}
{{--                                                       onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})"--}}
{{--                                                    >Preparing</a>--}}
{{--                                                    <a class="dropdown-item {{'ms-text-'.$status_class['ready_to_dispatch']}}"--}}
{{--                                                       onclick="ajax_post_on_link('{{route('restaurant.order.ready_to_dispatch',[$order->id])}}',{{$order->id}})">Ready--}}
{{--                                                        To Dispatch</a>--}}
{{--                                                    <a class="dropdown-item {{'ms-text-'.$status_class['dispatched']}}"--}}
{{--                                                       onclick="ajax_post_on_link('{{route('restaurant.order.dispatched',[$order->id])}}',{{$order->id}})">Dispatched</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
                                        </p>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>


                <div class="ms-panel {{--ms-panel-fh--}}">
                    <div class="ms-panel-header">
                        <h6>Customer</h6>
                    </div>
                    <div class="ms-panel-body p-0">
                        <ul class="ms-list ms-feed ms-twitter-feed">
                            <li class="ms-list-item">
                                <div class="media clearfix">
                                    <img src="{{url('/').'/default_user.jpg'}}" class="ms-img-round ms-img-small" alt="people">
                                    <div class="media-body">
                                        <h6 class="ms-feed-user"><b>Customer Name : </b>{{$order->user->name}}</h6>
                                        <p><b>Mobile :</b> {{$order->user->mobile_number.',',$order->user->alternative_number}} </p>

                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                @if(!empty($order->rider_assign_orders))
                <div class="ms-panel {{--ms-panel-fh--}}">
                    <div class="ms-panel-header">
                        <h6>Rider</h6>
                    </div>
                    <div class="ms-panel-body p-0">
                        <ul class="ms-list ms-feed ms-twitter-feed">
                            @foreach($order->rider_assign_orders as $k=>$rider)                    
                                <li class="ms-list-item">
                                    <div class="media clearfix">
                                        <img src="
                                        @if($rider->image!='')
                                        {{url('/').'/dliver-boy/'.$rider->image}}@else{{url('/').'/default_user.jpg'}} @endif" class="ms-img-round ms-img-small" alt="people">
                                        <div class="media-body">
                                            <h6 class="ms-feed-user"><b>Rider Name : </b>{{$rider->name}}</h6><br/>
                                            <p><b>Email :</b> {{$rider->email}}</p>
                                            <p><b>Mobile :</b> {{$rider->mobile}}</p>
                                            @if($rider->pivot->action==0)
                                                <span class="badge badge-primary">Pending</span>
                                            @endif
                                            @if($rider->pivot->action==1)
                                                <span class="badge badge-success">Accepted</span>
                                            @endif
                                            @if($rider->pivot->action==2)
                                                <span class="badge badge-dark">Rejected</span>
                                                <p>Cancel Reason : {{$rider->cancel_reason}}</p>
                                            @endif
                                            @if($rider->pivot->action==3)
                                                <span class="badge badge-info">Delivered</span>
                                            @endif
                                            @if($rider->pivot->action==4)
                                                <span class="badge badge-info">Pickuped</span>
                                            @endif
                                            @if($rider->pivot->action==6)
                                                <span class="badge badge-info">User Cancelled</span>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif                                             
                
            </div>



        </div>
    </div>

@endsection
@push('model')

    <div class="modal fade" id="modal-7" tabindex="-1" role="dialog" aria-labelledby="modal-7" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="preparation_form">
                    @csrf
                    <div class="modal-header bg-primary">
                        <h3 class="modal-title has-icon text-white">Order preparation </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <input type="hidden" name="orignel_preparation_time" value="" id="orignel_preparation_time">
                    <div class="modal-body">
                        <div class="ms-form-group has-icon">
                            <label>Order preparation time</label>
                            <input type="number" readonly placeholder="preparation time in minutes" class="form-control" name="preparation_time" value="" step="1" id="preparation_time">
                            <i class="material-icons">timer</i>
                        </div>

                        <div class="ms-form-group has-icon" id="extend_time_div">
                            <label>Order preparation time Extend(in minutes)</label>
                            <input type="number" placeholder="preparation time extend in minutes" class="form-control" name="extend_preparation_time" value="" step="1" id="extend_preparation_time" onchange="extend_time()">
                            <i class="material-icons">timer</i>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-none" {{--data-dismiss="modal"--}} id="submit_model">
                            Submit
                        </button>
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
                            $if_stat      .= "if(data.order_status=='$status')";
                            $if_stat      .= " $('#'+id).addClass('btn-$class');";

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

        $('#modal-7').modal({show: false})

        function preparation_form(url, id) {
            $('#preparation_form').attr('action', url);

            $.ajax({
                url: '{{route('restaurant.order.get_preparation_time')}}',
                type: 'post',
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": id
                },
                success: function (data) {

                    if (data.total_preparation_time != '') {
                        $("#orignel_preparation_time").val(data.total_preparation_time);
                        $("#preparation_time").val(data.total_preparation_time);
                    }

                    $("#extend_time_div").hide();
                    if (data.is_extend_time) {
                        $("#extend_time_div").show();
                        $("#extend_preparation_time").prop('max', data.max_preparation_time);
                        $("#extend_preparation_time").attr('placeholder', "maximum value " + data.max_preparation_time);
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    // toastr.info('Something went wrong', 'Info');
                }
            });
            $('#myModal').modal('show');
        }

        function extend_time() {
            var pre_time = parseInt($("#orignel_preparation_time").val());
            $("#preparation_time").val((pre_time + parseInt($("#extend_preparation_time").val())));
        }


    </script>

    <!-- Page Specific CSS (Slick Slider.css) -->
    <link href="{{ asset('frontend') }}/assets/css/slick.css" rel="stylesheet">

    <!-- Page Specific Scripts Start -->
    <script src="{{ asset('frontend') }}/assets/js/slick.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/moment.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.webticker.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/Chart.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/Chart.Financial.js"></script>
@endpush
