<?php
$status_class['pending'] = 'primary';
$status_class['confirmed'] = 'warning';
$status_class['preparing'] = 'secondary';
$status_class['ready_to_dispatch'] = 'info';
$status_class['dispatched'] = 'success';
$status_class['completed'] = 'success';
$status_class['payment_pending'] = 'warning';
$status_class['cancelled_by_vendor'] = 'danger';
$status_class['cancelled_by_customer'] = 'danger';

$payment_status_class['paid'] = 'badge-success';
$payment_status_class['pending'] = 'badge-danger';

?>
<div class="table-responsive" style="overflow: hidden;">
    <table class="table table-hover thead-primary" id="order">
        <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Address</th>
            <th scope="col">Total amount</th>
            <th scope="col">Net Amount</th>
            <th scope="col">Discount</th>
            {{--                                        <th scope="col">Order Status</th>--}}
            <th scope="col">Payment Type</th>
            <th scope="col">Payment Status</th>
            <th scope="col">Remaining Time</th>
            <th scope="col">Order Status</th>
            <th>Action</th>
        </tr>
        </thead>

        <thbody>
            @if(count($orders)<=0)
                <tr>
                    <td colspan="5">No record found</td>
                </tr>
            @endif
            @foreach($orders as $k=>$order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->delivery_address}}</td>
                    <td>{{$order->total_amount}}</td>
                    <td>{{$order->net_amount}}</td>
                    <td>{{$order->discount_amount}}</td>
                    <td>{{$order->payment_type}}</td>
                    <td>
                        <span class="badge {{$payment_status_class[$order->payment_status]}}"> {{ucwords(str_replace('_',' ',$order->payment_status))}}</span>
                    </td>
                    <td>@if($order->order_status=='preparing' && $order->preparation_time_to!='')

                            <?php if (mysql_date_time($order->preparation_time_to) < mysql_date_time()) {
                                echo "time out";
                            }else{?>
                            <span class="clock" data-countdown="{{ mysql_date_time($order->preparation_time_to)}}"></span>
                            <?php } ?>
                            <br/>
                            <a data-toggle="modal" data-target="#modal-8" class="btn btn-sm btn-primary" onclick="preparation_form1('{{route('restaurant.order.order_need_more_time',[$order->id])}}',{{$order->id}})">need
                                more time</a>
                        @endif
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="">
                                <button class="btn {{'btn-'.@$status_class[$order->order_status]}}  dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="{{$order->id}}" style="padding: 0.25rem 0.5rem !important;  line-height: 1 !important">{{ucfirst(str_replace('_',' ',$order->order_status))}}</button>
                                <div class="dropdown-menu">
                                    <?php //if($order->order_status == 'pending') { ?>
                                    {{--                                                                    <a class="dropdown-item  {{'ms-text-'.$status_class['accepted']}}" onclick="ajax_post_on_link('{{route('restaurant.order.accept',[$order->id])}}',{{$order->id}})">Accept</a>--}}
                                    {{--                                                                <a data-toggle="modal" data-target="#modal-7" class="dropdown-item {{'ms-text-'.$status_class['accepted']}}" onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})">Accept--}}
                                    {{--                                                                    and send for preparing</a>--}}
                                    {{--                                                                <a class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}" onclick="ajax_post_on_link('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})">Reject</a>--}}
                                    <?php
                                    //                                                                } else
                                    if($order->order_status == 'confirmed'){
                                    ?>
                                    <a data-toggle="modal" data-target="#modal-7" class="dropdown-item {{'ms-text-'.$status_class['preparing']}}" onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})">Preparing</a>
                                    <?php }
                                    if($order->order_status == 'preparing') {?>
                                    <a class="dropdown-item {{'ms-text-'.$status_class['ready_to_dispatch']}}" onclick="ajax_post_on_link('{{route('restaurant.order.ready_to_dispatch',[$order->id])}}',{{$order->id}})">Ready
                                        To Dispatch</a>
                                    <?php }if($order->order_status == 'ready_to_dispatch') { ?>
                                    <a class="dropdown-item {{'ms-text-'.$status_class['dispatched']}}" onclick="ajax_post_on_link('{{route('restaurant.order.dispatched',[$order->id])}}',{{$order->id}})">Dispatched</a>
                                    <?php } if($order->order_status != 'completed' &&
                                    $order->order_status != 'cancelled_by_customer_before_confirmed' &&
                                    $order->order_status != 'cancelled_by_customer_after_confirmed' &&
                                    $order->order_status != 'cancelled_by_vendor' &&
                                    $order->order_status != 'dispatched' && $order->order_status != 'ready_to_dispatch'){?>

                                    <a class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}" onclick="ajax_post_on_link('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})">Reject</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>

                        <a href="{{route('restaurant.order.view',$order->id)}}"><i class="fa fa-eye text-success "></i></a>
                        <a href="{{route('restaurant.order.invoice',$order->id)}}"><i class="fa fa-print text-info "></i></a>
                        {{--                                                    <a href="#"><i class="fas fa-pencil-alt text-secondary"></i></a>--}}
                        {{--                                                    <a href="a.html"><i class="far fa-trash-alt ms-text-danger"></i></a>--}}
                    </td>
                </tr>
            @endforeach
        </thbody>
        <tfoot>
        <tr></tr>
        </tfoot>
    </table>




</div>
<script>
    (function ($) {

        $('[data-countdown]').each(function () {
            var $this = $(this), finalDate = $(this).data('countdown');
// if ($(this).data('countdown') != '')
//     $this.countdown(finalDate, function (event) {
//         $this.html(event.strftime('%H:%M:%S'));
//     });
            if ($(this).data('countdown') != '')
                $(this).countdown(finalDate, function (event) {
                    $(this).html(event.strftime('%H:%M:%S'));
                });
        });
    })(jQuery);
</script>
