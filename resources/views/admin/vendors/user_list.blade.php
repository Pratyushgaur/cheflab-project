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
                                        <th>Total Order</th>
                                        <th>Wallet</th>
                                        <th>Active/Inactive</th>
                                        <th>Action</th>
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
                                            <td><?php if($user->wallet_amount!=null){echo $user->wallet_amount;}else{echo '0';}; //front_end_currency($user->wallet_amount)?> &#8377;<br><a href="#" class="add_wallet" data-url="{{route('user.wallet.add',$user->id)}}" data-name="{{$user->name}}" data-id="{{$user->id}}">Add</a></td>
                                            <td> 
                                                @if($user->status == '1')
                                                <!--<a href="javascript:void(0);" class="btn btn-success btn-xs inactive-record" data-alert-message="Are You Sure to Inactive this User" flash="User" data-action-url="{{route('admin.user.inactive',['id'=>encrypt($user->id)])}}" title="Inactive">Active</a>-->
                                                <a href="javascript:void(0);" class="btn btn-success btn-xs inactive-record" data-alert-message="Are You Sure to Inactive this User" flash="User" data-action-url="{{route('admin.user.inactive',['id'=>encrypt($user->id)])}} " title="Inactive">Active</a>
                                                @else
                                                 <a href="javascript:void(0);" class="btn btn-danger btn-xs active-record"  data-alert-message="Are You Sure to Active this User" flash="User" data-action-url="{{route('admin.user.active',['id'=>encrypt($user->id)])}} " title="Active">Inactive</a>
                                                @endif
                                            </td>
                                             <td>
                                               <a href="{{route('admin.user.view',['id'=>encrypt($user->id)])}}"><i class="fa fa-eye"></i></a>
                                               <a href="javascript:void(0);" class="btn btn-danger btn-xs delete-record" data-alert-message="Are You Sure to Delete this Category" flash="City" data-action-url="{{route('admin.user.delete',['id'=>encrypt($user->id)])}}" title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>


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
            <!--  -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <form action="" id="myForm" method="post">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">

                                <h4 class="modal-title">sdf</h4>
                            </div>
                            <div class="modal-body">

                                    <div class="form-group">
                                        <label for="">Enter Amount For Add</label>
                                        <input type="number" name="amount" class="form-control" required
                                        >

                                    </div>
                                    <div class="form-group">
                                        <label for="">Enter Narration</label>
                                        <textarea name="narration" class="form-control" id="" cols="30" rows="10" required></textarea>

                                    </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Add Amount</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!--  -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- /.content-wrapper -->

    <!-- /.row -->
@endsection
@section('js_section')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.add_wallet').click(function(){
            $('.modal-title').text($(this).attr('data-name'));
            $('#myForm').attr('action',$(this).attr('data-url'));
            $('#myModal').modal('show');
        })
    })
</script>
@endsection

