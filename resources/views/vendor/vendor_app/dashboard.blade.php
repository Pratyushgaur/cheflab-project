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
                <div class="card border-{{$status_class[$order->order_status]}} mb-3" style="">
                    <div class="card-header bg-transparent border-success text-center"><b>#{{$order->order_id}}</b></div>
                    <div class="card-body text-success" style="padding-top: 0px;">
                        <h5 class="card-title text-center">{{$order->customer_name}}</h5>
                        
                        <h5 class="text-right text-success">200.00</h5>
                        <p class="card-text"><b>Order Date</b> <br> {{date('d-M-Y h:i A')}}.</p>
                        <p class="card-text"><b>Landmark address</b> <br> {{$order->delivery_address}}.</p>
                        @if($order->chef_message!='')
                        <p class="card-text"><b>Message to Chef</b> <br> {{strtoupper($order->chef_message)}}.</p>
                        @endif
                        <p class="card-text"><b>Send Cutlery</b> @if($order->send_cutlery == '1')Yes @else No @endif </p>
                        <button class="btn btn-block " style="border:1px solid black; color:#333;" type="button" data-toggle="collapse" data-target="#collapseExample_{{$key}}" aria-expanded="false" aria-controls="collapseExample_{{$key}}">
                            View Products
                        </button>
                        <div class="collapse" id="collapseExample_{{$key}}">
                            @foreach($orderProducts as $okey => $ovalue)
                                <?php 
                                    $Product_master = \App\Models\Product_master::withTrashed()->find($ovalue->product_id);
                                    $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $ovalue->id)->first();
                                    
                                ?>
                                <div class="card card-body">
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
                                                $unit_price = @(@$product->product_price);
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
                                                <tr>
                                                    <th width="70%">
                                                        Addon : <br>Salt (200)*(5)
                                                    </th>
                                                    <th width="30%" style="text-align:right;"><h6>1000.00</h6></th>

                                                    
                                                </tr>
                                                <tr>
                                                    <th width="70%">
                                                        Total
                                                    </th>
                                                    <th width="30%" style="text-align:right;"><h6>5000.00</h6></th>

                                                    
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-success" style="padding-bottom: 12px;padding-top: 0px;">
                        <div class="row">
                            <div class="col-xs-6 col-md-6">
                                <button class="btn btn-block btn-success" style="border-radius:10px;">Accept</button>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <button class="btn btn-block btn-danger" style="border-radius:10px;">Reject</button>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                @empty
                <h4 class="text-center">No Order Found</h4>
                @endforelse
            </div>
            
            
            @forelse ($orders as $user)
                
            @empty
            <!-- <div class="col-xl-12 col-md-12 "  >
                <h4 class="text-center">No Order Found</h4>
            </div> -->
            @endforelse
        
    </div>

@endsection

@push('scripts')
    <script>
        $("#dashboard_input").change(function() {
            this.form.submit();
        });
        $('.click-box').click(function(){
            window.location.href = $(this).attr('data-link');
        })
    </script>
@endpush

