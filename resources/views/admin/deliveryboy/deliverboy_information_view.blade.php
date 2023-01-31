<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">

        <div class="col-12 col-sm-6 col-md-3">
            <a href="javascript:voide(0)">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
                    <div class="info-box-content">
                        <h2 class="title">{{ @$deliverd_order }}</h2>
                        <span class="info-box-text">Order Delivered</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <a href="javascript:voide(0)">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
                    <div class="info-box-content">
                        <h2 class="title">{{ @$canceled_order }}</h2>
                        <span class="info-box-text">Order Canceled</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <a href="javascript:voide(0)">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
                    <div class="info-box-content">
                        <h2 class="title">{{ @$total_earning }}</h2>
                        <span class="info-box-text">Total Earning</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <a href="javascript:voide(0)">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
                    <div class="info-box-content">
                        <h2 class="title">{{ @$total_incentive }}</h2>
                        <span class="info-box-text">Total Incentive</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </a>
            <!-- /.info-box -->
        </div>


    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ $user->name }}</h5>

                    <div class="card-tools">
                        <button type="button" class="btn btn-danger">Suspend This Delivery Boy
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <select name="" id="filter-by-role" class="form-control">
                                <option value="">Woring Type</option>
                                <option value="1">Part Time </option>
                                <option value="2">Full Time</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-center">
                                <!-- <strong>Last 6 Month Sale Report</strong> -->
                            </p>

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <p class="text-center">
                                <strong\>User Review</strong>
                            </p>


                            <div class="progress-group">
                                Excellent
                                <span class="float-right"><b>0</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: 23%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->

                            <div class="progress-group">
                                Good
                                <span class="float-right"><b>0</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width: 34%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                Average
                                <span class="float-right"><b>0</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width: 23%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                Below Average
                                <span class="float-right"><b>0</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width: 43%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                Poor
                                <span class="float-right"><b>0</b></span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" style="width: 67%"></div>
                                </div>
                            </div>



                            <!-- /.progress-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->

                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">

                <div class="card-body pad table-responsive">
                    <table id="example_information" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                        <thead>
                            <tr role="row">
                                <th class="text-center">S. No.</th>
                                <th>Reviewer</th>
                                <th>Order Id</th>
                                <th>Review</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>

        </div>

    </div>
    <!-- Main row -->

    <!-- /.row -->
</div><!--/. container-fluid -->
<script type="text/javascript">
    window.info_table = $('#example_information').dataTable({

        dom: 'Bfrtip',
        buttons: [{
            extend: 'excel',
            className: 'btn-info',
            title: 'Account-rider'
        }],
        processing: true,
        serverSide: true,
        // buttons: true,
        ajax: {
            url: "{{ route('admin.delivery_boy.review.data') }}",
            data: function(d) {}
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'order_id',
                name: 'order_id'
            },
            {
                data: 'review',
                name: 'review'
            },
            {
                data: 'date',
                name: 'date'
            },

        ]
    });
</script>