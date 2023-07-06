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
    $status_class['cancelled_by_customer_after_confirmed'] = 'danger';

    ?>
            @forelse ($orders as $key => $order)
                
                    <?php $orderProducts  = \App\Models\OrderProduct::where('order_id','=',$order->id)->get(); ?>
                    <?php $coupon  = \App\Models\Coupon::where('id','=',$order->coupon_id)->first(); ?>
                <div class="card border-{{$status_class[$order->order_status]}} mb-3 order_container_{{$order->id}}" style="">
                    <div class="card-header bg-transparent border-success text-center">
                        <div class="otp_block_{{$order->id}}" style="width:60px; height:60px; border:1px solid black; position:absolute; @if($order->order_status != 'ready_to_dispatch')display:none; @endif">OTP <br> <b class="text-danger">2022</b></div>
                        <b>#{{$order->order_id}}</b>
                    </div>
                    <div class="card-body text-success" style="padding-top: 0px; padding-bottom: 0px;">
                        <h5 class="card-title text-center">{{$order->customer_name}}</h5>
                        
                        <h5 class="text-right text-success">Rs.{{number_format( $order->net_amount,2)}}</h5>
                        <p class="card-text"><b>Order Date</b> <br> {{date('d-M-Y h:i A')}}.</p>
                        <!-- <p class="card-text"><b>Landmark address</b> <br> {{$order->delivery_address}}.</p> -->
                        @if($order->chef_message!='')
                        <p class="card-text"><b>Message to Chef </b><br> <b class=" text-danger">{{strtoupper($order->chef_message)}}.</b> </p>
                        @endif
                        <p class="card-text "><b>Send Cutlery - </b>  <b class="text-danger">@if($order->send_cutlery == '1')Yes @else No @endif</b> </p>
                        
                        <!-- <p class="card-text otp_block_{{$order->id}}" style="@if($order->order_status != 'ready_to_dispatch')display:none; @endif"><b>Pickup OTP - </b> <b class="text-danger ">{{$order->pickup_otp}}</b>   </p> -->

            
                        <button class="btn btn-block " data-toggle="modal" data-target="#modal-8" onclick="viewProduct('{{$order->id}}')" style="border:1px solid black; color:#333;" type="button"  aria-expanded="false" aria-controls="collapseExample_{{$key}}">
                            View Products
                        </button>
                        <div  id="" style="display:none;" class="product_container_{{$order->id}}">
                            <div class="card card-body">
                                <div class="row">
                                            
                                    <div class="col-xl-12 col-md-12">
                                        <table class="table">
                                            @foreach($orderProducts as $okey => $ovalue)
                                                <?php 
                                                    $Product_master = \App\Models\Product_master::withTrashed()->find($ovalue->product_id);
                                                    $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $ovalue->id)->first();
                                                    
                                                ?>
                                                    
                                                            
                                                                <tr>
                                                                    <th style="width:30%;" style="text-align:left;"><h6>{{$ovalue->product_qty}} <i class="fa fa-times"></i></h6></th>

                                                                    <th style="width:70%;" style="text-align:left;">
                                                                        {{$Product_master->product_name}} <br>
                                                                        <?php 
                                                                        if (!empty($OrderProductVariant) && $Product_master->customizable == 'true'){
                                                                            echo '('.$OrderProductVariant->variant_name.')';
                                                                        }
                                                                        ?>
                                                                    </th>
                                                                </tr>
                                                                <?php 
                                                                    $addons=\App\Models\OrderProductAddon::join('addons','addons.id','order_product_addons.addon_id')->where('order_product_id',$ovalue->id)->get();
                                                                    if(isset($addons[0])){
                                                                        foreach ($addons as $k1=>$addon)
                                                                            if(isset($addon->addon) && $addon->addon!=''){
                                                                                
                                                                                ?>
                                                                                
                                                                                <tr>
                                                                                    <th style="width:30%;" style="text-align:left;"><h6>1 <i class="fa fa-times"></i></h6></th>

                                                                                    <th width="70%">
                                                                                        Addon : <br>{{$addon->addon }}
                                                                                    </th>
                                                                                    
                                                                                    
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                    }
                                                                ?>
                                                            
                                                    
                                                
                                                
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-success" style="padding-bottom: 12px;padding-top: 0px;">
                        <div class="row status_container_<?php echo $order->id; ?>">
                            
                            @if($order->order_status == 'confirmed')
                            <div class="col-xs-6 col-md-6">
                                <button data-toggle="modal" data-target="#modal-7" onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})" class="btn btn-block btn-success" style="border-radius:10px;">Accept</button>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <button class="btn btn-block btn-danger " onclick="reject_order({{$order->id}})" style="border-radius:10px;">Reject</button>
                            </div>
                            @endif
                            @if($order->order_status == 'preparing')
                            <div class="col-xs-12 col-md-12">
                                <button class="btn btn-block btn-success" onclick="ready_to_dispatch_form({{$order->id}})" style="border-radius:10px;">Preparing</button>
                            </div>
                            
                            @endif
                            @if($order->order_status == 'ready_to_dispatch')
                            <div class='col-xs-12 col-md-12'>
                                
                                <button class='btn btn-block btn-info'>Ready to Dispatch</button>
                                
                            </div>
                            
                            @endif
                            @if($order->order_status == 'completed')
                                    <div class="col-xs-12 col-md-12">
                                        <button class="btn btn-block btn-success" style="border-radius:10px;">Completed</button>
                                    </div>
                            @endif
                            @if($order->order_status == 'cancelled_by_vendor')
                                    <div class="col-xs-12 col-md-12">
                                        <button class="btn btn-block btn-danger" style="border-radius:10px;">Rejected</button>
                                    </div>
                            @endif
                            
                            
                            
                        </div>
                    </div>
                </div>
                @empty
                <div class="card mb-3">
                    <div class="card-body text-success" style="padding-top: 0px; padding-bottom: 0px;">
                        <img src="{{URL::TO('no_order_found.jpg')}}" alt="">
                        <h4 class="text-center">No Order Found</h4>
                    </div>
                    
                </div>
                
                @endforelse