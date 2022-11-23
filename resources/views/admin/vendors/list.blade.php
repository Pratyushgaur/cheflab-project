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
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Restaurants</span>
                            <span class="info-box-number">
                           {{$restaurant}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active Restaurants</span>
                            <span class="info-box-number">{{$active_resto}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-building"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Delivery Boy</span>
                            <span class="info-box-number">{{$delivery_boy}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fa-solid fa-hat-chef"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Chef's</span>
                            <span class="info-box-number">{{$chef}}</span>
                        </div>
                        <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
                    <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <!-- <form action="{{route('admin.vendors.list')}}"> -->
                                <div class="row">
                                    <div class="col-md-2">
                                        
                                        <select name="rolename" class="form-control" id="filter_by_role">
                                            <option value="">Filter By Role</option>
                                            <option value="restaurant">Restaurant</option>
                                            <option value="chef">Chef</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-md-2">
                                        <input type="text" name="search" class="form-control" placeholder="Search" value="{{request()->search}}">
                                    </div> -->

                                    <div class="col-md-2">
                                    <button type="button" class="pull-right btn btn-sm btn-success" onclick="reload_table();" style="color:#fff;"><i class="fas fa-search"> </i> Search</button>
                                        <a href="" class="pull-right btn btn-sm btn-primary "><i class="fas fa-refresh"> </i> Reset</a>

                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{route('admin.restourant.create')}}" class="pull-right btn btn-sm btn-success " style="float: right;  color:#fff;"><i class="fa fa-plus"> </i> Create New Restaurant</a>
                                    </div>
                                    <div class="col-md-3">
                                    <a href="{{route('admin.chef.create')}}" class="pull-right btn btn-sm btn-success " style="  color:#fff;"><i class="fa fa-user"> </i> Create New Chef</a>
                                    </div>
                                </div>
                                <!-- </form> -->
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
                                        <th>Vendor name / Owner name</th>
                                        <th>Email/Mobile</th>
                                        <th>Type</th>
                                        <th> Status</th>
                                        <th> Image</th>
                                        <th>Wallet</th>
                                        <th>created at</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- @foreach($vendors as $k=>$vendor)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$vendor->name}}</td>
                                            <td>{{$vendor->email}}</td>
                                            <td>{{$vendor->vendor_type}}</td>
                                            <td>
                                                @if($vendor->status == '1')
                                                <a href="javascript:void(0);" class="btn btn-success btn-xs inactive-record" data-alert-message="Are You Sure to Inactive this Vendor" flash="User" data-action-url="{{route('admin.vendors.inactive',['id'=>encrypt($vendor->id)])}}" title="Inactive">Active</a>
                                                @else
                                                 <a href="javascript:void(0);" class="btn btn-danger btn-xs active-record"  data-alert-message="Are You Sure to Active this Vendor" flash="User" data-action-url="{{route('admin.vendors.active',['id'=>encrypt($vendor->id)])}} " title="Active">Inactive</a>
                                                @endif
                                            </td>
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
                                                         @if($vendor->vendor_type == 'restaurant')
                                                            <a class="dropdown-item text-info" href="{{route('admin.chef.edit',Crypt::encryptString($vendor->id))}}'"><i class="fas fa-edit"></i> Edit</a>
                                                            @endif
                                                            <a class="dropdown-item text-info" href="{{route('admin.vendor.view',Crypt::encryptString($vendor->id))}}"><i class="fa fa-eye"></i> View More</a>
                                                            <a href="javascript:void(0);" data-id="' . Crypt::encryptString($data->id) . '" class="delete-record" data-alert-message="Are You Sure to Delete this Product" flash="City"  data-action-url="' . route('admin.vendors.ajax.delete') . '" title="Delete" ><i class="fa-solid fa-bowl-food"></i>Delete</a> 
                                                            @if($vendor->vendor_type == 'chef')
                                                               <a class="dropdown-item text-info" href="{{route('admin.chef.editchef', Crypt::encryptString($vendor->id))}}"><i class="fas fa-edit"></i> Edit Chef</a>
                                                              <a class="dropdown-item text-danger" href="{{route('admin.chefproduct.view',Crypt::encryptString($vendor->id))}}"><i class="fa-solid fa-bowl-food"></i>Add/View  Product</a>
                                                            @endif
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach -->
                                    </tbody>
                                </table>
                                <!-- <div class="">{{ $vendors->links('vendor.pagination.bootstrap-4') }}</div> -->
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
        let table = $('#example1').dataTable({
            processing: true,
            serverSide: true,
            //ajax: "{{ route('admin.vendors.datatable') }}",
            ajax: {
                url: "{{ route('admin.vendors.datatable') }}",
                data: function (d) {
                    d.rolename = $('#filter_by_role').val()
                }

            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'userName', name: 'name'},
                {data: 'userEmailMob', name: 'email'},
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