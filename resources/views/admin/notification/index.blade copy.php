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
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4>Notifications</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{route('admin.notification.create')}}" class="pull-right btn btn-xs btn-success">Send New Notification</a>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach($notifications as $k=>$notification)

                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">{{@$notification->data['sender_name']}}</h3>
                            <div class="card-tools">
                                <span class="my-2 d-block"> <i class="fa fa-clock-o" aria-hidden="true"></i> {{ front_end_date_time($notification->created_at) }}</span>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead> <tr> <th>{{ @$notification->data['msg'] }}</th> </tr> </thead>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <a href="{{ @$notification->data['link'] }}" class="btn btn-sm btn-secondary float-right">View</a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                @endforeach
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


@endsection
