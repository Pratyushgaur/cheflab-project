@extends('vendor.restaurants-layout')
@section('page-css')
<style>
    #printableArea * {
        color: black !important;
    }

    @media print {
        .non-printable {
            display: none;
        }

        .printable {
            display: block;
            font-family: emoji !important;
        }

        body {
            -webkit-print-color-adjust: exact !important;
            /* Chrome, Safari */
            color-adjust: exact !important;
            font-family: emoji !important;
        }
    }
</style>

<style type="text/css" media="print">
    @page {
        size: auto;
        /* auto is the initial value */
        margin: 2px;
        /* this affects the margin in the printer settings */
        font-family: emoji !important;
    }
</style>

@endsection
@section('main-content')
<div class="row">

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
                {{-- <li class = "breadcrumb-item"><a href = "#"><i class = "material-icons">home</i> Home</a></li>--}}
                {{-- <li class = "breadcrumb-item active" aria-current = "page">Orders</li>--}}
                {{-- <li class = "breadcrumb-item active" aria-current = "page">Orders List</li>--}}
            </ol>
        </nav>
    </div>

    <div class="col-md-2"></div>
    <div class="ms-panel col-md-8" id="printableArea">

        <div class="col-md-12">
            <center>
                <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')" value="Proceed, If thermal printer is ready." />
                <a href="{{ url()->previous() }}" class="btn btn-danger non-printable">Back</a>
            </center>
            <hr class="non-printable">
        </div>
        <div class="ms-panel-header header-mini">
            <div class="d-flex ">
                <h4>ChefLab Order Id : {{$order->order_id}}</h4>

            </div>
            <h4>OTP : @if(!empty($rider)) {{$rider->otp}} @endif </h4>
        </div>
        <div class="ms-panel-body">
            <!-- Invoice To -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="invoice-address">
                        <h5>Restaurant : {{$vendorData->name}}</h5>
                        <h5>Address : {{$vendorData->address}}</h5><br>
                        <h5>Date / Time : {{ $order_date }}</h5><br>
                        <h5>Name : {{$order->customer_name}}</h5>
                        @if (isset($order->lat) && isset($order->long))
                        <a target="_blank" href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$order->lat }}+{{$order->long }}">
                            <h5>Address : {{ trim($order->delivery_address) }}</h5><br>
                        </a>
                        @else
                        <h5>Address : {{ $order->delivery_address }}</h5><br>
                        @endif

                        


                    </div>
                </div>

            </div>
            <!-- Invoice Table -->
            <div class="ms-invoice-table table-responsive mt-5">
                <table class="table table-hover text-right thead-light">
                    <thead>
                        <tr class="text-capitalize">
                            <th class="text-center">
                                <h6>QTY</h6>
                            </th>
                            <th class="text-center" width="30%">
                                <h6>Item</h6>
                            </th>
                            <th class="text-left">
                                <h6>Price</h6>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $k=>$product)
                        <?php 
                                $Product_master = \App\Models\Product_master::withTrashed()->find($product->product_id);
                                
                            ?>
                        <tr>
                            <td class="text-center w-5">
                                <h6>{{$product->product_qty}} X </h6>
                            </td>
                            </td>
                            <td class="text-center w-5">
                                <h6>{{$product->product_name}}</h6>
                                
                                <?php

                                $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $product->id)->first();
                                if (!empty($OrderProductVariant) && $Product_master->customizable == 'true') {
                                    echo " ($OrderProductVariant->variant_name)";

                                    $unit_price = $OrderProductVariant->variant_price / $OrderProductVariant->variant_qty;
                                    $price      = $OrderProductVariant->variant_price;
                                } else {
                                    $unit_price = @(@$product->product_price / @$product->product_qty);
                                    $price      = $product->product_price;
                                }

                                ?>
                                

                            </td>
                            <td class="text-left">
                                <h6><?php echo "&#8377;" . $unit_price; ?></h6>
                            </td>
                        </tr>
                        <?php 
                        $addons=\App\Models\OrderProductAddon::join('addons','addons.id','order_product_addons.addon_id')->where('order_product_id',$product->id)->get();
                            if(isset($addons[0])){
                                foreach ($addons as $k1=>$addon)
                                        if(isset($addon->addon) && $addon->addon!=''){
                                            
                                            ?>
                                            <tr>
                                                <td class="text-center w-5"><h6>1 X </h6></td>
                                                <td class="text-left"><h6>{{$addon->addon}}</h6></td>
                                                <td class="text-left">
                                                    <h6><?php echo "&#8377;" . $addon->addon_price; ?></h6>
                                                </td>
                                            </tr>
                                            <?php
                                        }

                            }

                        ?>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                <h6>Total:</h6>
                            </td>
                            <td class="text-left">
                                <h6><?php echo "&#8377;" . $order->total_amount; ?></h6>
                            </td>
                        </tr>

                        </tfoot>
                </table>
            </div>

            <div class="">
                <h6>This is not a tax invoice</h6>
                <h6>ChefLab Fssai No. : 21422850007236</h6>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endpush