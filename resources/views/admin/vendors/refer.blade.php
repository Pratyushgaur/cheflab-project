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
                
                    <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <form action="{{route('admin.vendors.list')}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a href="{{route('admin.refer.referamount')}}" class="pull-right btn btn-sm btn-success " style="float: right;  color:#fff;"><i class="fa fa-plus"> </i> Update Refer Amount</a>
                                    </div>
                                </div>
                                </form>
                            </div>
                            
                          </div>
                          
                      </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">

                            <div class="card-header">
                                <h3 class="card-title">Listing User Refer Adn Earn </h3>


                            </div>
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sr No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th> Refer Code</th>
                                        <th> Refer By</th>
                                        <th>By Earn</th>
                                        <th>created at</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user as $k=>$user)
                                            <tr>
                                                <td>{{$k+1}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email }}</td>
                                                <td>{{$user->mobile_number }}</td>
                                                <td>{{$user->referralCode }}</td>
                                                <td>{{$user->referby}}</td>
                                                <td>{{$user->by_earn}}</td>
                                                
                                                <td>{{front_end_date($user->created_at)}}</td>
                                                
                                            </tr>
                                        @endforeach
                                        </tbody>
                                </table>
                          
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


@section('js_section')
    <script>
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>

    <script type="text/javascript">
        // $(function () {
        let table = $('#example').dataTable({
            processing: true,
            serverSide: true,
            //ajax: "{{ route('admin.vendors.datatable') }}",
            ajax: {
                url: "{{ route('admin.vendors.datatable') }}",
                data: function (d) {
                    d.rolename = $('#filter-by-role').val()
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'vendor_type', name: 'vendor_type'},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'wallet', name: 'wallet'},
                {data: 'date', name: 'created_at'},
                {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
            ]
        });

        // });

        function reload_table() {
            table.DataTable().ajax.reload(null, false);
        }

    </script>
@endsection
