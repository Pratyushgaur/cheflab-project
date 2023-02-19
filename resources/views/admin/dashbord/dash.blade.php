

@extends('admin.layouts.layouts')
@section('content')
<style>
   .table>tbody>tr>td {
      font-size: 16px !important;
   }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Admin-Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">App Users</span>
                <span class="info-box-number">
                  {{$total_app_user}}
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
                <span class="info-box-text">Delivery Boys</span>
                <span class="info-box-number">{{$total_delivery_boy}}</span>
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
                <span class="info-box-text">Restaurant</span>
                <span class="info-box-number">{{$total_restaurant}}</span>
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
                <span class="info-box-number">{{$total_chef}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('admin/orders/dashboard') }}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Pending Orders</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('admin/orders/dashboard/delay_restaurant') }}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Delay (Restaurant)</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('admin/orders/dashboard/delay_rider') }}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Delay (Riders)</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('admin/orders/dashboard/preparing') }}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Preparing</span>
                       </div>
              <!-- /.info-box-content -->
            </div>
</a>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('admin/orders/dashboard/not_pickup_rider') }}">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Not Picked Up (Rider)</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
          <a href="{{ url('admin/orders/dashboard/out_of_dellivery') }}">
            <div class="info-box mb-3">            
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-motorcycle"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Out for delivery</span>
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
                <h5 class="card-title">Monthly Sale Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
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
                      <strong>Last 6 Month Sale Report</strong>
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
                      <strong>Order Report Bar's</strong>
                    </p>

                    <div class="progress-group">
                     Sucessfully Order's
                      <span class="float-right"><b>160</b>/200</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 80%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Cancelled Order's
                      <span class="float-right"><b>310</b>/400</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" style="width: 75%"></div>
                      </div>
                    </div>

                    
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header"><i class="fas fa-rupee-sign"></i> 35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header"><i class="fas fa-rupee-sign"></i> 10,390.90</h5>
                      <span class="description-text">TOTAL VENDOR'S REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header"><i class="fas fa-rupee-sign"></i> 24,813.53</h5>
                      <span class="description-text">TOTAL CHEF'S REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-success"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header"><i class="fas fa-rupee-sign"></i> 1200</h5>
                      <span class="description-text">TOTAL DELIVERY BOY REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
            <!-- MAP & BOX PANE -->
            
            <!-- /.card -->
            <div class="row">
               
               <div class="col-md-4">
                  <!-- USERS LIST -->
                  <div class="card">
                     <div class="card-header">
                     <h3 class="card-title">Top Rated Delivery Boys</h3>

                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                     </div>
                     </div>
                     <!-- /.card-header -->
                     <div class="card-body p-0">
                     <ul class="users-list clearfix">
                        @forelse ($top_deliveryBoy as $Key =>$value)
                        <li>
                           @if($value->image !='')
                           <img src="{{asset('dliver-boy')}}/{{$value->image}}" onerror="this.onerror=null;this.src='{{asset('commonarea')}}/dist/img/avatar5.png';" alt="User Image">
                           @else
                           <img src="{{asset('commonarea')}}/dist/img/avatar5.png" alt="User Image">
                           @endif
                           
                           <a class="users-list-name" href="{{route('admin.deliverboy.view',Crypt::encryptString($value->id))}}">{{$value->name}}</a>
                           <span class="users-list-date">{{$value->ratings}} Rating</span>
                        </li>
                        @empty
                           <h4 style="text-align:center; padding:5px;">No Data found</h4>
                        @endforelse
                        
                        
                     </ul>
                     <!-- /.users-list -->
                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer text-center">
                     <a href="{{route('admin.deliverboy.list')}}">View All Delivery Boys</a>
                     </div>
                     <!-- /.card-footer -->
                  </div>
                  <!--/.card -->
               </div>
               
               <!-- /.col -->

               <div class="col-md-4">
                  <!-- USERS LIST -->
                  <div class="card">
                     <div class="card-header">
                     <h3 class="card-title">Top Rated Vendor's</h3>

                     <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                        </button>
                     </div>
                     </div>
                     <!-- /.card-header -->
                     <div class="card-body p-0">
                     <ul class="users-list clearfix">
                        
                        @forelse ($top_vendors as $Key =>$value)
                        <li>
                           @if($value->image !='')
                           <img src="{{asset('vendors')}}/{{$value->image}}" onerror="this.onerror=null;this.src='{{asset('commonarea')}}/dist/img/avatar5.png';" alt="User Image">
                           @else
                           <img src="{{asset('commonarea')}}/dist/img/avatar5.png" alt="User Image">
                           @endif
                           
                           <a class="users-list-name" href="route('admin.vendor.view', Crypt::encryptString($value->id))">{{$value->name}}</a>
                           <span class="users-list-date">{{round($value->vendor_ratings,2)}} Rating</span>
                        </li>
                        @empty
                           <h4 style="text-align:center; padding:5px;">No Data found</h4>
                        @endforelse
                     </ul>
                     <!-- /.users-list -->
                     </div>
                     <!-- /.card-body -->
                     <div class="card-footer text-center">
                     <a href="{{route('admin.vendors.list')}}">View All Vendor's</a>
                     </div>
                     <!-- /.card-footer -->
                  </div>
                  <!--/.card -->
               </div>
               <!-- /.col -->
                <div class="col-md-4">
                  <!-- Info Boxes Style 2 -->
                  <div class="info-box mb-3 bg-warning">
                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Active Restaurants</span>
                      <span class="info-box-number">{{$active_res}}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                  <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="far fa-heart"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Online & Active Restaurants</span>
                      <span class="info-box-number">{{$active_online_res}}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                  <div class="info-box mb-3 bg-danger">
                    <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Active Delivery Boys</span>
                      <span class="info-box-number">{{$active_rider}}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                  <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon"><i class="far fa-comment"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Online & Active Delivery Boys</span>
                      <span class="info-box-number">{{$active_online_rider}}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->

                  
                  <!-- /.card -->

                  <!-- PRODUCT LIST -->
                  
                </div>
            </div>
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Latest Orders</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table m-0">
                      <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($letestOrders as $key =>$value) 
                        <tr>
                        <td><a href="{{route('admin.order.view',Crypt::encryptString($value->id))}}">{{$value->order_id}}</a></td>
                        <td>{{$value->name}}</td>
                        <td>
                          @if($value->order_status == 'confirmed')
                          <span class="badge badge-warning">Pending</span>
                          @endif
                          @if($value->order_status == 'preparing')
                          <span class="badge badge-success">Preparing</span>
                          @endif
                          @if($value->order_status == 'ready_to_dispatch')
                          <span class="badge badge-success">Ready To Dispatch</span>
                          @endif
                        
                          @if($value->order_status == 'dispatched')
                          <span class="badge badge-warning">Dispatched</span>
                          @endif
                          @if($value->order_status == 'completed')
                          <span class="badge badge-success">Completed</span>
                          @endif
                          @if($value->order_status == 'cancelled_by_customer_before_confirmed')
                          <span class="badge badge-danger">cancelled by customer In 30 Seconds</span>
                          @endif
                          @if($value->order_status == 'cancelled_by_customer_after_confirmed')
                          <span class="badge badge-danger">cancelled by customer After 30 Seconds</span>
                          @endif
                          @if($value->order_status == 'cancelled_by_customer_during_prepare')
                          <span class="badge badge-danger">cancelled by customer After Accept</span>
                          @endif
                          @if($value->order_status == 'cancelled_by_customer_after_disptch')
                          <span class="badge badge-danger">cancelled by customer After Dispatched</span>
                          @endif
                          @if($value->order_status == 'cancelled_by_vendor')
                          <span class="badge badge-danger">Reject By Vendor</span>
                          @endif
                          
                        </td>
                        <td>
                          <div class="sparkbar" data-color="#00a65a" data-height="20">{{date('d M Y h:i A',strtotime($value->created_at))}}</div>
                        </td>
                      </tr>
                        @endforeach
                      
                      
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  
                  <a href="{{route('admin.order.list')}}" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                </div>
                <!-- /.card-footer -->
              </div>
          </div>
          
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-- /.content-wrapper -->
@endsection
