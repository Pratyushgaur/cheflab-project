@extends('admin.layouts.layoute')
@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">

            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">WALLET BALANCE</span>
                            <span class="info-box-number">
                         
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                   
                    
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary card-outline">

                            <div class="card-header">
                                <h3 class="card-title">Listing of Registered app users </h3>


                            </div>
                            <div class="card-body pad table-responsive">
                                <table id="users" class="table table-bordered table-hover dtr-inline datatable"
                                       aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sr No.</th>
                                        <th> Name</th>
                                        <th>Order ID</th>
                                        <th>Total</th>
                                        <th>Aaction</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $deliver_boy_type=config('custom_app_setting.deliver_boy_type');?>
                                    @foreach($order as $k=>$valu)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$valu->customer_name}}</td>
                                            <td>{{$valu->id}}</td>
                                            <td>{{$valu->total_amount}}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            
                            </div>

                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                        <div class="row invoice-info">
                            <div class="col-sm-5 invoice-col">
                            <b>User Name:</b>{{$user->name}}<br>
                            <b>Email</b>:{{$user->email}} <br>
                            <b>Mobile</b>:{{$user->mobile_number}} <br>
                            </div>
                            
                            
                        </div>
                        </div>
                    </div>


                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- /.content-wrapper -->

    <!-- /.row -->
@endsection


