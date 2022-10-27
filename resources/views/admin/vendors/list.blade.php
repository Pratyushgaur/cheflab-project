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
                                <form action="{{route('admin.vendors.list')}}">
                                <div class="row">
                                    <div class="col-md-2">
                                        {{Form::select('rolename',['restaurant'=>'Restaurant','chef'=>'Chef'],request()->rolename,['class'=>'form-control','placeholder'=>'Filter By Role'])}}
{{--                                        <select name="rolename" class="form-control">--}}
{{--                                            <option value="">Filter By Role</option>--}}
{{--                                            <option value="restaurant">Restaurant</option>--}}
{{--                                            <option value="chef">Chef</option>--}}
{{--                                        </select>--}}
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search" value="{{request()->search}}">
                                    </div>

                                    <div class="col-md-2">
                                    <button type="submit" class="pull-right btn btn-sm btn-success " style="  color:#fff;"><i class="fas fa-search"> </i> Search</button>
                                        <a href="{{route('admin.vendors.list')}}" class="pull-right btn btn-sm btn-primary "><i class="fas fa-refresh"> </i> Reset</a>

                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{route('admin.restourant.create')}}" class="pull-right btn btn-sm btn-success " style="float: right;  color:#fff;"><i class="fa fa-plus"> </i> Create New Restaurant</a>
                                    </div>
                                    <div class="col-md-3">
                                    <a href="{{route('admin.chef.create')}}" class="pull-right btn btn-sm btn-success " style="  color:#fff;"><i class="fa fa-user"> </i> Create New Chef</a>
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
                                <h3 class="card-title">Listing of Registered Restaurant And Chef </h3>


                            </div>
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sr No.</th>
                                        <th>Vendor Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th> Status</th>
                                        <th> Image</th>
                                        <th>Wallet</th>
                                        <th>created at</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($vendors as $k=>$vendor)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$vendor->name}}</td>
                                            <td>{{$vendor->email}}</td>
                                            <td>{{$vendor->vendor_type}}</td>
                                            <td><?php echo (!empty($vendor->status)) && ($vendor->status == 1) ? '<button class="btn btn-xs btn-success">Active</button>' : '<button class="btn btn-xs btn-danger">In active</button>'?></td>
                                            <td><img src="{{asset('vendors').'/'.$vendor->image}}"  style='width: 50px;' /></td>
                                            <td>{{$vendor->wallet}}</td>
                                            <td>{{front_end_date($vendor->created_at)}}</td>
                                            <td>
                                                <ul class="navbar-nav">
                                                    <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                            <a class="dropdown-item text-info" href="{{route('admin.chef.edit',Crypt::encryptString($vendor->id))}}'"><i class="fas fa-edit"></i> Edit</a>
                                                            <a class="dropdown-item text-info" href="{{route('admin.vendor.view',Crypt::encryptString($vendor->id))}}"><i class="fa fa-eye"></i> View More</a>
                                                            <a class="dropdown-item text-danger vendor-delete" href="javascript:void(0);" data-id="{{ Crypt::encryptString($vendor->id) }}"  data-alert-message="Are You Sure to Delete this Vendor" flash="Vendor"  data-action-url="{{route('admin.vendors.ajax.delete')}}" title="Delete" > <i class="fa fa-trash"></i> Delete</a>
                                                            <a class="dropdown-item text-danger" href="{{route('admin.chefproduct.view',Crypt::encryptString($vendor->id))}}"><i class="fa-solid fa-bowl-food"></i>Add/View  Product</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="">{{ $vendors->links('vendor.pagination.bootstrap-4') }}</div>
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
