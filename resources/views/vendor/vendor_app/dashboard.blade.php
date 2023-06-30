@extends('vendor.vendor_app.restaurants-layout')
@section('main-content')
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
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <h1 class="db-header-title">Welcome, {{ucfirst(Auth::guard('vendor')->user()->name)}}</h1>
            </div>

            
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 "  >
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

                        @if($order->order_status == 'ready_to_dispatch')
                           
                        @endif
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
                <h4 class="text-center">No Order Found</h4>
                @endforelse
            </div>
            
            
            
        
    </div>
    <!-- model for order -->
    <div class="modal fade" id="modal-7" tabindex="-1" role="dialog" aria-labelledby="modal-7" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="preparation_form">
                    <input type="hidden" class="form_order_id" name="order_id">
                   
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
                            
                            
                            <!-- <code>Sum of All Preparation Time of Products for particular Order will be order preparation
                                
                                time </code> -->
                                <code>Default Prepration Minutes Define by admin . You can Increase time by click need more time Button</code>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="button"  class="btn btn-primary shadow-none prepration-submit-button" {{--data-dismiss="modal"--}} id="submit_model">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $("#dashboard_input").change(function() {
            this.form.submit();
        });
        $('.click-box').click(function(){
            window.location.href = $(this).attr('data-link');
        })
        function preparation_form(url, id) {
            $('.form_order_id').val(id);

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
        $('.prepration-submit-button').click(function(){
            //$(this).prop('disabled', true);
            var orderid = $('.form_order_id').val();
            
            $.ajax({
                url: '{{route('app.restaurant.acceptOrder')}}',
                type: 'post',
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "form_data": $('#preparation_form').serialize()
                },
                success: function (data) {
                    console.log(data.status);
                    if(data.status == true){
                        $('#modal-7').hide();
                        Swal.fire('Great job!',data.message,'success');
                        $(".status_container_"+orderid+"").html("<div class='col-xs-12 col-md-12'><button class='btn btn-block btn-success' onclick='ready_to_dispatch_form("+orderid+")' style='border-radius:10px;'>Preparing</button></div>");
                        $(this).prop('disabled', false);
                    }else{
                        Swal.fire({icon: 'error',title: 'Oops...',text: data.error,})
                        $(this).prop('disabled', false)

                    }
                    
                },
                error: function (xhr, textStatus, thrownError) {
                    // toastr.info('Something went wrong', 'Info');
                }
            });
            //$('#preparation_form').submit();
            
        })
        function ready_to_dispatch_form(orderid){
            Swal.fire({
                title: 'Do you want to change Status for ready to disptch',
                
                showCancelButton: true,
                confirmButtonText: 'Save',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route('app.restaurant.ready_to_dispatch')}}',
                        type: 'post',
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "order_id": orderid
                        },
                        success: function (data) {
                            console.log(data.status);
                            if(data.status == true){
                                Swal.fire('Great job!',data.message,'success');
                                $(".status_container_"+orderid+"").html("<div class='col-xs-12 col-md-12'><button class='btn btn-block btn-info'>Ready to Dispatch</button></div>");
                                $(".otp_block_"+orderid+"").show();
                            }else{
                                Swal.fire({icon: 'error',title: 'Oops...',text: data.error,})
                            }
                            
                        },
                        error: function (xhr, textStatus, thrownError) {
                            // toastr.info('Something went wrong', 'Info');
                        }
                    });
                } 
            })
            
        }
    </script>
@endpush

