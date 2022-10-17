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
                                <h3 class="card-title">Listing of Registered app users </h3>


                            </div>
                            <div class="card-body pad table-responsive">
                                <table id="users" class="table table-bordered table-hover dtr-inline datatable"
                                       aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sr No.</th>
                                        <th> Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Alternate mobile no</th>
                                        <th>Wallet</th>
{{--                                        <th>Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $deliver_boy_type=config('custom_app_setting.deliver_boy_type');?>
                                    @foreach($users as $k=>$user)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->mobile_number}}</td>
                                            <td>{{$user->alternative_number}}</td>
                                            <td><?php echo front_end_currency($user->wallet_amount)?></td>
{{--                                            <td>--}}
{{--                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Category" flash="City" data-action-url="{{route('admin.user.delete',['id'=>encrypt($user->id)])}}" title="Delete"><i class="fa fa-trash"></i></a>--}}
{{--                                            </td>--}}


                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                                {{ $users->links('vendor.pagination.bootstrap-4') }}
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


