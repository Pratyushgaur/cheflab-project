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

    $payment_status_class['paid'] = 'badge-success';
    $payment_status_class['pending'] = 'badge-danger';

    ?>
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        <li class="breadcrumb-item active" aria-current="page">Orders List</li>
                    </ol>
                </nav>


{{--                          <div class="col-md-12">--}}
{{--                            <div class="ms-panel ms-panel-fh">--}}
{{--                              <div class="ms-panel-header">--}}
{{--                                <h6>Favourite Orders</h6>--}}
{{--                              </div>--}}
{{--                              <div class="ms-panel-body order-circle">--}}

{{--                                <div class="row">--}}
{{--                                  <div class="col-xl-3 col-lg-3 col-md-6">--}}
{{--                                      <h6 class="text-center">Pizza</h6>--}}
{{--                                    <div class="progress-rounded progress-round-tiny">--}}

{{--                                      <div class="progress-value">12%</div>--}}
{{--                                      <svg>--}}
{{--                                        <circle class="progress-cicle bg-success" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="12" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">--}}
{{--                                        </circle>--}}
{{--                                      </svg>--}}
{{--                                    </div>--}}
{{--                                  </div>--}}
{{--                                  <div class="col-xl-3 col-lg-3 col-md-6">--}}
{{--                                        <h6 class="text-center">Mexican Noodels</h6>--}}
{{--                                    <div class="progress-rounded progress-round-tiny">--}}
{{--                                      <div class="progress-value">38.8%</div>--}}
{{--                                      <svg>--}}
{{--                                        <circle class="progress-cicle bg-primary" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="38.8" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">--}}
{{--                                        </circle>--}}
{{--                                      </svg>--}}
{{--                                    </div>--}}
{{--                                  </div>--}}
{{--                                  <div class="col-xl-3 col-lg-3 col-md-6">--}}
{{--                                      <h6 class="text-center">Spicy Salad</h6>--}}
{{--                                    <div class="progress-rounded progress-round-tiny">--}}
{{--                                      <div class="progress-value">78.8%</div>--}}
{{--                                      <svg>--}}
{{--                                        <circle class="progress-cicle bg-secondary" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="78.8" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">--}}
{{--                                        </circle>--}}
{{--                                      </svg>--}}
{{--                                    </div>--}}
{{--                                  </div>--}}
{{--                                  <div class="col-xl-3 col-lg-3 col-md-6">--}}
{{--                                      <h6 class="text-center">French Fries</h6>--}}
{{--                                    <div class="progress-rounded progress-round-tiny">--}}
{{--                                      <div class="progress-value">100%</div>--}}
{{--                                      <svg>--}}
{{--                                        <circle class="progress-cicle bg-dark" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="100" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">--}}
{{--                                        </circle>--}}
{{--                                      </svg>--}}
{{--                                    </div>--}}
{{--                                  </div>--}}
{{--                                </div>--}}
{{--                              </div>--}}
{{--                            </div>--}}
{{--                          </div>--}}
                <div class="col-12">
                    <div class="ms-panel">
                        <div class="ms-panel-header">
                            <h6> Order List</h6>
                        </div>
                        <div class="ms-panel-body">

                            <div class="table-responsive">
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
                                        <th scope="col">Order Status</th>
                                    </tr>
                                    </thead>

                                    <thbody>
                                        @foreach($orders as $k=>$order)
                                            <tr>
                                                <td>{{$order->id}}</td>
                                                <td>{{$order->customer_name}}</td>
                                                <td>{{$order->delivery_address}}</td>
                                                <td>{{$order->total_amount}}</td>
                                                <td>{{$order->net_amount}}</td>
                                                <td>{{$order->discount_amount}}</td>
                                                <td>{{$order->payment_type}}</td>
                                                <td> <span class="badge {{$payment_status_class[$order->payment_status]}}"> {{ucwords(str_replace('_',' ',$order->payment_status))}}</span> </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="">
                                                            <button
                                                                class="btn {{'btn-'.@$status_class[$order->order_status]}}  dropdown-toggle btn-sm"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"
                                                                id="{{$order->id}}"
                                                                style="padding: 0.25rem 0.5rem !important;  line-height: 1 !important">{{ucfirst(str_replace('_',' ',$order->order_status))}} </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item  {{'ms-text-'.$status_class['accepted']}}"
                                                                   onclick="ajax_post_on_link('{{route('restaurant.order.accept',[$order->id])}}',{{$order->id}})">Accept</a>
                                                                <a class="dropdown-item {{'ms-text-'.$status_class['cancelled_by_vendor']}}"
                                                                   onclick="ajax_post_on_link('{{route('restaurant.order.vendor_reject',[$order->id])}}',{{$order->id}})">Reject</a>
                                                                <a  data-toggle="modal" data-target="#modal-7"
                                                                    class="dropdown-item {{'ms-text-'.$status_class['preparing']}}"
                                                                   onclick="preparation_form('{{route('restaurant.order.preparing',[$order->id])}}',{{$order->id}})"
                                                                >Preparing</a>
                                                                <a class="dropdown-item {{'ms-text-'.$status_class['ready_to_dispatch']}}"
                                                                   onclick="ajax_post_on_link('{{route('restaurant.order.ready_to_dispatch',[$order->id])}}',{{$order->id}})">Ready
                                                                    To Dispatch</a>
                                                                <a class="dropdown-item {{'ms-text-'.$status_class['dispatched']}}"
                                                                   onclick="ajax_post_on_link('{{route('restaurant.order.dispatched',[$order->id])}}',{{$order->id}})">Dispatched</a>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </thbody>
                                </table>
                                <div class="">{{ $orders->links('vendor.pagination.bootstrap-4') }}</div>

                            </div>
                        </div>
                    </div>
                </div>


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
                    <h3 class="modal-title has-icon text-white"><i class="flaticon-share"></i> Subscribe to our Newsletter</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                        <div class="ms-form-group has-icon">
                            <label>Order preparation time</label>
                            <input type="number" placeholder="preparation time in minutes" class="form-control" name="preparation_time" value="" step="2" min="10">
                            <i class="material-icons">timer</i>
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary shadow-none"
{{--                            data-dismiss="modal"--}}
                            id="submit_model" >Submit</button>
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
                            $if_stat .= "if(data.order_status=='$status')";
                            $if_stat .= " $('#'+id).addClass('btn-$class');";

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

        $('#modal-7').modal({ show: false})

        // $( "#modal-7" ).on('shown', function(){
        //     alert("I want this to appear after the modal has opened!");
        // });

        function preparation_form(url, id) {
            $('#preparation_form').attr('action', url);
            $('#myModal').modal('show');
        }

    </script>
@endpush
