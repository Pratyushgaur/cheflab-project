@extends('vendor.restaurants-layout')
@section('page-css')
    <style>
        #printableArea *{
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
{{--                            <li class = "breadcrumb-item"><a href = "#"><i class = "material-icons">home</i> Home</a></li>--}}
{{--                            <li class = "breadcrumb-item active" aria-current = "page">Orders</li>--}}
{{--                            <li class = "breadcrumb-item active" aria-current = "page">Orders List</li>--}}
                </ol>
            </nav>
        </div>

        <div class="col-md-2"></div>
    <div class="ms-panel col-md-8" id="printableArea">

        <div class="col-md-12">
            <center>
                <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                       value="Proceed, If thermal printer is ready." />
                <a href="{{ url()->previous() }}" class="btn btn-danger non-printable">Back</a>
            </center>
            <hr class="non-printable">
        </div>
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
                    
                   

                </div>
            </div>
            <div class="col-md-6 text-md-right">
                @if(!empty($rider))
                <h3>{{$rider->otp}} </h3>
                @endif

                <ul class="invoice-date">
                    <li><b>Invoice Date :</b> {{front_end_date($order->created_at)}}</li>
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
                            {{($k+1)}}</td>
                        </td>
                        <td class="text-left"><b>Product :</b> {{$product->product_name}}
                            <?php

                            $OrderProductVariant = \App\Models\OrderProductVariant::where('order_product_id', $product->id)->get();
                            if (!$OrderProductVariant) {
                                echo "<br/> <b>Variant :</b> $OrderProductVariant->variant_name";

                                $unit_price = $OrderProductVariant->variant_price / $OrderProductVariant->variant_qty;
                                $price      = $OrderProductVariant->variant_price;
                            } else {
                                $unit_price = @(@$product->product_price / @$product->product_qty);
                                $price      = $product->product_price;
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
