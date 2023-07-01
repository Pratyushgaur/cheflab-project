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
                <div class="card border-{{$status_class[$order->order_status]}} mb-3" style="">
                    <div class="card-header bg-transparent border-success text-center"><b>#{{$order->order_id}}</b></div>
                    <div class="card-body text-success" style="padding-top: 0px; padding-bottom: 0px;">
                        <h5 class="card-title text-center">{{$order->customer_name}}</h5>
                        
                        <h5 class="text-right text-success">Rs.{{number_format( $order->net_amount,2)}}</h5>
                        <p class="card-text"><b>Order Date</b> <br> {{date('d-M-Y h:i A')}}.</p>
                        <p class="card-text"><b>Landmark address</b> <br> {{$order->delivery_address}}.</p>
                        @if($order->chef_message!='')
                        <p class="card-text"><b>Message to Chef</b> <br> {{strtoupper($order->chef_message)}}.</p>
                        @endif
                        <p class="card-text"><b>Send Cutlery</b> @if($order->send_cutlery == '1')Yes @else No @endif </p>
                        
                        <p class="card-text otp_block_{{$order->id}}" style="@if($order->order_status != 'ready_to_dispatch')display:none; @endif"><b>Pickup OTP</b>  {{$order->pickup_otp}} </p>

            
                        <button class="btn btn-block " style="border:1px solid black; color:#333;" type="button" data-toggle="collapse" data-target="#collapseExample_{{$key}}" aria-expanded="false" aria-controls="collapseExample_{{$key}}">
                            View Products
                        </button>
                        <div class="collapse" id="collapseExample_{{$key}}">
                            @foreach($orderProducts as $okey => $ovalue)
                                <?php 
                                    $Product_master = \App\Models\Product_master::withTrashed()->find($ovalue->product_id);
                                    $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $ovalue->id)->first();
                                    
                                ?>
                                <div class="card card-body" style="border-bottom:1px solid black;">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <h6 class="text-center">{{$Product_master->product_name}}</h6>
                                            <?php 
                                            if (!empty($OrderProductVariant) && $Product_master->customizable == 'true'){
                                                ?>
                                                    <p class="text-center">{{$OrderProductVariant->variant_name}}</p>
                                                <?php
                                                $unit_price = $OrderProductVariant->variant_price;
                                                $price      = $OrderProductVariant->variant_price*$OrderProductVariant->variant_qty;
                                            }else{
                                                $unit_price = @(@$ovalue->product_price);
                                                $price      = $ovalue->product_price*$ovalue->product_qty;
                                            }
                                            ?>
                                            
                                        </div>
                                        <div class="col-xl-12 col-md-12">
                                            <table class="table">
                                                <tr>
                                                    <th width="70%">
                                                        Price -{{number_format($unit_price,2)}} <br>
                                                        Qty - {{$ovalue->product_qty}} <br>
                                                        
                                                    </th>
                                                    <th width="30%" style="text-align:right;"><h6>{{number_format($price,2)}}</h6></th>
                                                </tr>
                                                <?php 
                                                    $addons=\App\Models\OrderProductAddon::join('addons','addons.id','order_product_addons.addon_id')->where('order_product_id',$ovalue->id)->get();
                                                    if(isset($addons[0])){
                                                        foreach ($addons as $k1=>$addon)
                                                            if(isset($addon->addon) && $addon->addon!=''){
                                                                $price = $price+$addon->addon_price;
                                                                ?>
                                                                
                                                                <tr>
                                                                    <th width="70%">
                                                                        Addon : <br>{{$addon->addon }}
                                                                    </th>
                                                                    <th width="30%" style="text-align:right;"><h6>{{(number_format($addon->addon_price,2))}}</h6></th>

                                                                    
                                                                </tr>
                                                                <?php
                                                            }
                                                    }
                                                ?>
                                                <tr>
                                                    <th width="70%">
                                                        Total
                                                    </th>
                                                    <th width="30%" style="text-align:right;"><h6>{{number_format($price,2)}}</h6></th>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            @endforeach
                            <div class="card card-body" style="padding-bottom: 0px; padding-top: 5px;">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12">
                                        <table class="table">
                                            <tr>
                                                <th width="70%">
                                                    Item-Total
                                                </th>
                                                <th width="30%" style="text-align:right;"><h6>{{number_format($order->total_amount,2)}}</h6></th>

                                                
                                            </tr>
                                            <tr>
                                                <th width="70%">
                                                    Tax & charge
                                                </th>
                                                <th width="30%" style="text-align:right;"><h6><?php echo number_format( (float)$order->tex+$order->platform_charges,2);?></h6></th>

                                                
                                            </tr>
                                            <tr>
                                                <th width="70%">
                                                    Delivery Charge 
                                                </th>
                                                <th width="30%" style="text-align:right;"><h6><?php echo number_format( $order->delivery_charge,2);?></h6></th>

                                                
                                            </tr>
                                            @if(!empty($coupon))
                                            <tr>
                                                <th width="70%">
                                                    Discount <br>Coupon Applied <span class="text-success">({{$coupon->name}})</span>
                                                </th>
                                                <th width="30%" style="text-align:right;"><h6><?php echo number_format( $order->discount_amount,2);?></h6></th>

                                                
                                            </tr>
                                            @endif
                                            @if($order->wallet_apply)
                                            <tr>
                                                <th width="70%">
                                                    Wallet Cut
                                                </th>
                                                <th width="30%" style="text-align:right;"><h6><?php echo number_format( $order->wallet_cut,2);?></h6></th>

                                                
                                            </tr>
                                            @endif
                                            <tr>
                                                <th width="70%">
                                                    Net-Amount
                                                </th>
                                                <th width="30%" style="text-align:right;"><h6><?php echo number_format( $order->net_amount,2);?></h6></th>

                                                
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
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
                                <button class="btn btn-block btn-danger" style="border-radius:10px;">Reject</button>
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