@extends('vendor.restaurants-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route("restaurant.dashboard")}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('restaurant.globleseting.ordertime')}}">Global Setting</a></li>
                        <li class="breadcrumb-item">Order Time</li>
                    </ol>
                </nav>
            </div>

            @include('vendor.restaurant.globleseting.setting_menu')

            <div class="col-md-9">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6>Order Time Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form class="validation-fill clearfix " id="menu-form"
                            action="{{ route('restaurant.ordertime.store') }}" method="post">
                            @csrf

                            @include('vendor.restaurant.alertMsg')
                            {{-- Order time form start --}}
                            @include('vendor.restaurant.globleseting.order_time_fields')

                            <div class="form-row">
                                <div class="col-md-6 mb-6"></div>
                                <div class="col-md-6 mb-6">
                                    <button class="btn btn-primary" type="submit" style="float: right">Submit </button>
                                </div>
                            </div>

                            {{-- Order time form end --}}

                        </form>
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection

@section('page-js')
    <script>
        (function($) {
            let table = $('#order').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('order.datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'order_status',
                        name: 'order_status'
                    },
                    {
                        data: 'order_total_price',
                        name: 'order_total_price'
                    },
                    {
                        data: 'pyment_type',
                        name: 'pyment_type'
                    },
                    {
                        data: 'order_time',
                        name: 'order_time'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action-js',
                        name: 'action-js',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        })(jQuery);
    </script>
@endsection
