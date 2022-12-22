<?php
$breadcrumb[] = ["name"  => "Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Orders",
                 'route' => route("restaurant.order.list")];
$breadcrumb[] = ["name"  => "List",
                 'route' => ''];
?>
@extends('vendor.restaurants-layout')
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

    $payment_status_class['paid'] = 'badge-success';
    $payment_status_class['pending'] = 'badge-danger';

    ?>
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])
            </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6> Order List</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div id="load"></div>

                        <div class="row">{{ $orders->links('vendor.pagination.bootstrap-4') }}</div>
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
                            <code>Sum of All Preparation Time of Products for particular Order will be order preparation
                                time </code>
                        </div>

                        {{--                        <div class="ms-form-group has-icon" id="extend_time_div">--}}
                        {{--                            <label>Order preparation time Extend(in minutes)</label>--}}
                        {{--                            <input type="number" placeholder="preparation time extend in minutes" class="form-control" name="extend_preparation_time" value="" step="1" id="extend_preparation_time" onchange="extend_time()">--}}
                        {{--                            <i class="material-icons">timer</i>--}}
                        {{--                        </div>--}}

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-none" {{--data-dismiss="modal"--}} id="submit_model">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    {{--    Need more time --}}
    <div class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-labelledby="modal-8" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="preparation_form1">
                    @csrf
                    <div class="modal-header bg-primary">
                        <h3 class="modal-title has-icon text-white">Order preparation </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <input type="hidden" name="orignel_preparation_time" value="" id="orignel_preparation_time1">
                    <div class="modal-body">
                        <div class="ms-form-group has-icon">
                            <label>Order preparation time </label>
                            <input type="number" readonly placeholder="preparation time in minutes" class="form-control" name="preparation_time" value="" step="1" id="preparation_time1">
                            <i class="material-icons">timer</i>
                            <code>This much amount of time already lapse</code>
                        </div>

{{--                        <div class="ms-form-group has-icon" id="extend_time_div">--}}
{{--                            <label>Order preparation time Extend(in minutes)</label>--}}
{{--                            <input type="number" placeholder="preparation time extend in minutes" class="form-control" name="extend_preparation_time" value="" step="1" id="extend_preparation_time" onchange="extend_time()">--}}
{{--                            <i class="material-icons">timer</i>--}}
{{--                        </div>--}}
                        <div class="ms-form-group has-icon" id="extend_time_div">
                            <label>Order preparation time Extend(in minutes)</label>
                            <select id="extend_preparation_time" placeholder="preparation time extend in minutes" class="form-control" name="extend_preparation_time" onchange="extend_time()">

                            </select>
{{--                            <input type="number" placeholder="preparation time extend in minutes" class="form-control" name="extend_preparation_time" value="" step="1" id="extend_preparation_time" onchange="extend_time()">--}}
{{--                            <i class="material-icons">timer</i>--}}
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-none" {{--data-dismiss="modal"--}} id="submit_model">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endpush
@push('scripts')
    <script src="{{ asset('frontend') }}/assets/js/jquery.countdown.min.js"></script>

    <script>
        function ajax_post_on_link(url, id) {
            toastr.options =
                {
                    "progressBar": true,
                    "showDuration": "300"
                }

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
                            $if_stat      .= "if(data.order_status=='$status')";
                            $if_stat      .= " $('#'+id).addClass('btn-$class');";

                        }?>
                        $("#" + id).removeClass('{{$remove_class}}');
                        <?php echo $if_stat;?>
                        toastr.success(data.msg, 'Success');
                        $('#load').load('{{route('restaurant.order.refresh_list',["staus_filter"=>$staus_filter])}}').fadeIn("slow");
                    } else
                        toastr.info('Something went wrong', 'Info');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.info('Something went wrong', 'Info');
                }
            });
        }

        $('#modal-7').modal({show: false});

        // $( "#modal-7" ).on('shown', function(){
        //     alert("I want this to appear after the modal has opened!");
        // });

        function preparation_form(url, id) {
            $('#preparation_form').attr('action', url);

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

        function preparation_form1(url, id) {
            $('#preparation_form1').attr('action', url);

            $.ajax({
                url: '{{route('restaurant.order.get_set_preparation_time')}}',
                type: 'post',
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": id
                },
                success: function (data) {

                    if (data.total_preparation_time != '') {
                        $("#orignel_preparation_time1").val(data.total_preparation_time);
                        $("#preparation_time1").val(data.total_preparation_time);
                    }

                    $("#extend_time_div").hide();
                    if (data.is_extend_time) {
                        $("#extend_time_div").show();
                        $("#extend_preparation_time").html(data.options);
                        // $("#extend_preparation_time").prop('max', data.max_preparation_time);
                        // $("#extend_preparation_time").attr('placeholder', "maximum value " + data.max_preparation_time);
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    // toastr.info('Something went wrong', 'Info');
                }
            });
            $('#myModal').modal('show');
        }

        function extend_time() {
            var pre_time = parseInt($("#orignel_preparation_time1").val());
            $("#preparation_time1").val((pre_time + parseInt($("#extend_preparation_time").val())));
        }

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

    <script type="text/javascript">
        <?php $query_string = request()->all();
        $query_string["staus_filter"] = $staus_filter;?>
        $('#load').load('{{route('restaurant.order.refresh_list',$query_string)}}').fadeIn("slow");
        var auto_refresh = setInterval(
            function () {

                $('#load').load('{{route('restaurant.order.refresh_list',$query_string)}}').fadeIn("slow");
            }, 300000); // refresh every 10000 milliseconds

    </script>
@endpush
