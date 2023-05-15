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
                <!-- <div class="row">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <form action="{{route('admin.user.list')}}">
                                    <input type="text" name="search" style="width:40%;" placeholder="Search" value="{{$keyword}}">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Search">
                                </form>

                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">

                            <div class="card-header">
                                <h3 class="card-title">Listing of Registered app users </h3>
                                

                            </div>
                            <div class="card-body pad table-responsive">
                            <table id="example1" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">User id</th>
                                        <th> Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        
                                        <th>Wallet</th>
                                        <th>Active/Inactive</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php //$deliver_boy_type=config('custom_app_setting.deliver_boy_type');?>
                                    
                                    </tbody>

                                </table>

                                
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
        let table = $('#example1').dataTable({
            processing: true,
            serverSide: true,
            "lengthMenu": [[10 ,50, 100, 500, -1], [10 ,50, 100, 500, "Show All"]],
            //ajax: "{{ route('admin.vendors.datatable') }}",
            ajax: {
                url: "{{ route('admin.users.datatable') }}"
                // data: function (d) {
                //     d.rolename = $('#filter_by_role').val()
                // }

            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'mobile_number', name: 'mobile_number'},
                {data: 'wallet', name: 'wallet'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $(document).on('click','.add_wallet',function(){
            $('.modal-title').text($(this).attr('data-name'));
            $('#myForm').attr('action',$(this).attr('data-url'));
            $('#myModal').modal('show');
        })
        
    })
</script>
@endsection

