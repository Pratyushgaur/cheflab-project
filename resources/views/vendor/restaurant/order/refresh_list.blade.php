
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
<div class="table-responsive" style="overflow: hidden; min-height:200px; overflow-x: scroll;">
    <table class="table table-hover thead-primary" id="order">
        <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Address</th>
            <th scope="col">Item Total</th>
            <th scope="col">Net Amount</th>
            <th scope="col">Discount</th>
            <!-- <th scope="col">Payment Type</th>
            <th scope="col">Payment Status</th> -->
            <th scope="col">Remaining Time</th>
            <th scope="col">Date</th>
            <th scope="col"><?php if($staus_filter=='ready_to_dispatch'){echo 'Rider';}else{echo 'Order Status';} ?></th>
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
                    <td><a href="{{route('restaurant.order.view',$order->id)}}" target="_blank">{{$order->order_id}}</a></td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->delivery_address}}</td>
                    <td>{{$order->total_amount}}</td>
                    <td>{{$order->net_amount}}</td>
                    <td>{{$order->discount_amount}}</td>
                    <!-- <td>{{$order->payment_type}}</td>
                    <td>
                        <span class="badge {{$payment_status_class[$order->payment_status]}}"> {{ucwords(str_replace('_',' ',$order->payment_status))}}</span>
                    </td> -->
                    <td>
                            @if($order->order_status=='preparing' && $order->preparation_time_to!='')

                            <?php if (mysql_date_time($order->preparation_time_to) < mysql_date_time()) {
                                echo "time out";
                            }else{?>
                            <span class="clock" data-countdown="{{ mysql_date_time($order->preparation_time_to)}}"></span>
                            <?php } ?>
                            <br/>
                            <a href="#" data-toggle="modal" data-target="#modal-8" class="" onclick="preparation_form1('{{route('restaurant.order.order_need_more_time',[$order->id])}}',{{$order->id}})" style="font-size:12px;">more time</a>
                            @endif    
                        
                        

                        
                    </td>
                    <td>{{date('d M Y h:i A',strtotime($order->created_at))}}</td>
                    <td col-2> 
                        @if($order->order_status!='ready_to_dispatch')
                          <?php
                                if($order->order_status == 'confirmed'){
                            $status = 'Pending';
                          }else{
                            $status = $order->order_status;
                          } ?>
                        <div class="input-group">
                            <div class="">
                                <button class="btn {{'btn-'.@$status_class[$order->order_status]}}  dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="{{$order->id}}" style="padding: 0.25rem 0.5rem !important;  line-height: 1 !important">{{ucfirst(str_replace('_',' ',$status))}}</button>
                                <div class="dropdown-menu">
                                    <?php
                                    
                                    if($order->order_status == 'confirmed'){
                                    ?>
                                    <a data-toggle="modal" data-target="#modal-7" class="dropdown-item {{'ms-text-'.$status_class['preparing']}}" onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})">Preparing</a>
                                    <a data-toggle="modal" data-target="#modal-confirm" class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}" data-id="{{$order->id}}" onclick="confirm_reject('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})" >Reject</a>
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

                                    
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        @else
                            <?php  
                                $rider = \App\Models\RiderAssignOrders::where('order_id','=',$order->id)->join('deliver_boy','rider_assign_orders.rider_id','=','deliver_boy.id')->whereNotIn('action',['0','2'])->select('rider_assign_orders.*','deliver_boy.name','deliver_boy.mobile')->first();
                                if(!empty($rider)){
                                    ?>
                                    
                                    <b>{{$rider->name}}</b><br>
                                    <span>({{$rider->mobile}})</span> <br>
                                    <b>OTP-{{$rider->otp}}</b>
                                    <?php
                                    
                                }else{
                                    echo '<button class="btn btn-danger btn-xs blink-btn" >Wait For Rider</button>';
                                }
                            ?>
                        @endif
                    </td>

                    <td>

                        <a href="{{route('restaurant.order.view',$order->id)}}"><i class="fa fa-eye text-success "></i></a>
                        <a href="{{route('restaurant.order.invoice',$order->id)}}"><span class="badge badge-success" >Invoice</span></a>
                        <a href="{{route('restaurant.order.qot',$order->id)}}"><span class="badge badge-danger" >KOT</span></a>
                        
                        
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
