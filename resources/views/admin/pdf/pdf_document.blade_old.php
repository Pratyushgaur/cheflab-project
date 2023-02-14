<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>PDF</title>
    <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
	<!-- Ionicons -->
  
    <style>
        
        .mainpart p {
            font-size: 18px;
        }

        .initial-38-1 {
            max-width: 400px;
            margin: 0 auto;
            padding-right: 4px;
        }

        .initial-38-1 * {
            font-family: roboto mono, monospace !important;
            font-weight: 500;
            color: #000;
        }

        .initial-38-4 {
            font-size: 16px;
            font-weight: lighter;
        }

        .initial-38-1 h5 {
            font-size: 16px;
            font-weight: revert;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">

        <section class="content">
            <div class="container-fluid">
                <div class="initial-38-1" style="width: 400px;" id="printableArea">
                    <div class="pt-3" style="text-align:center;">
                        <img src="https://stackfood-admin.6amtech.com/public/assets/admin/img/restaurant-invoice.png" class="initial-38-2" alt="" width="80px">
                    </div>
                    <div class="text-center pt-2 mb-3">
                        <h2 class="initial-38-3"> {{ ucwords($vendor->name) }}</h2>
                        <h5 class="text-break initial-38-4">
                            {{ $vendor->address }}
                        </h5>
                        <h5 class="initial-38-4 initial-38-3">
                            Phone : {{ $vendor->mobile }}
                        </h5>
                    </div>
                    <span class="initial-38-5" style="border-bottom: 2px dashed #838383;"></span>
                    <div class="row mt-3">
                        <div class="col-6">
                            <h5>Order ID :
                                <span class="font-light"> {{ $order->order_id }} </span>
                            </h5>
                        </div>
                        <div class="col-6">
                            <span class="font-light">
                                {{ date('d M Y H:s',strtotime($order->created_at)) }}

                            </span>
                        </div>
                        <div class="col-12">
                            <h5>
                                Customer Name :
                                <span class="font-light">
                                    {{ $users->name }}
                                </span>
                            </h5>
                            <h5>
                                Phone :
                                <span class="font-light">
                                    {{ $users->mobile_number }}
                                </span>
                            </h5>

                        </div>
                    </div>
                    <h5 class="text-uppercase"></h5>
                    <span class="initial-38-5" style="border-bottom: 2px dashed #838383;"></span>
                    <table class="table table-bordered mt-1 mb-1">
                        <thead>
                            <tr>
                                <th class="initial-38-6">S.No.</th>
                                <th class="initial-38-6">QTY</th>
                                <th class="initial-38-7">DESC</th>
                                <th class="initial-38-7">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($orderProduct as $val) { ?>
                                <tr>
                                    <td class="">
                                    <?php echo $i; ?>
                                    </td>
                                    <td class="">
                                    {{$val['product_qty']}}
                                    </td>
                                    <td class="">
                                        {{$val['product_name']}} <br>
                                    </td>
                                    <td class="w-28p">
                                        {{ $val['product_price'] }}
                                    </td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                    <span class="initial-38-5" style="border-bottom: 2px dashed #838383;"></span>
                    <div class="table-responsive text-right">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Items Price:</th>
                                <td>{{ $orderProductAmount }}</td>
                            </tr>
                            <tr>
                                <th>Tax ({{$vendor->tax}}%)</th>
                                <td>{{ $taxAmount }}</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>{{ $totalAmount }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="d-flex flex-row justify-content-between border-top pt-3">
                        <span class="text-capitalize">Paid by: cash on delivery</span>
                    </div>
                    <span class="initial-38-7" style="border-bottom: 2px dashed #838383;"> </span>
                    <h4 class="text-center pt-1">
                        <span class="d-block">"""THANK YOU"""</span>
                    </h4>
                    <span class="initial-38-7" style="border-bottom: 2px dashed #838383;"></span>
                    <span class="d-block text-center">© 2022 Chelab. All rights reserved.</span>
                </div>
            </div>
    </div>
    </section>
    <!-- /.content -->
    </div>
</body>

</html>