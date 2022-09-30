@extends('admin.layouts.layoute')
@section('content')


      <!-- Content Wrapper. Contains page content -->
          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Profile</h1>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Chef Profile</li>
                    </ol>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                      <div class="card-body box-profile">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle"
                              src="{{asset('vendors').'/'.$vendor->image}}"
                              alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{$vendor->name}}</h3>

                        <p class="text-muted text-center">{{strtoupper($vendor->vendor_type)}}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                            <b>Like's</b> <a class="float-right">{{$vendorLike}}</a>
                          </li>
                          <li class="list-group-item text-success">
                            <b>Success Order's</b> <a class="float-right">{{vendorOrderCountByStatus($vendor->id,'completed')}}</a>
                          </li>
                          <li class="list-group-item text-danger">
                            <b>Cancel Order's</b> <a class="float-right">{{vendorOrderCountByStatus($vendor->id,'cancelled_by_customer')}}</a>
                          </li>
                          <li class="list-group-item ">
                            <b>Mobile</b> <a class="float-right">{{$vendor->mobile}}</a>
                          </li>
                          <li class="list-group-item ">
                            <b>Wallet</b> <a class="float-right">{{$vendor->wallet}}</a>
                          </li>
                          <li class="list-group-item ">
                            <b>Commission</b> <a class="float-right">{{$vendor->commission}}%</a>
                          </li>
                          @if($vendor->vendor_type == 'chef')
                          
                          <li class="list-group-item ">
                          <a href="{{ route('admin.cherf.product',\Crypt::encryptString($vendor->id)) }}" class="btn btn-primary btn-rounded btn-block"><b>Add New Product</b></a>
                          <a href="{{ route('admin.cherf.videolink',\Crypt::encryptString($vendor->id)) }}" class="btn btn-primary btn-block"><b>Add Video Link</b></a>    
                          </li>
                          
                          @endif
                          
                          
                        </ul>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <hr>
                        <iframe width="300" height="170"  src="//maps.google.com/maps?q={{$vendor->lat}},{{$vendor->long}}&z=20&output=embed"></iframe>
                        
                        <hr>

                        <strong><i class="far fa-building-alt mr-1"></i> Address</strong>

                        <p class="text-muted">{{$vendor->address}}</p>
                        

                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-9">
                    <div class="card">
                      <div class="card-header p-2">
                        <ul class="nav nav-pills">
                          <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Product List</a></li>
                          <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Video List</a></li>
                          <li class="nav-item"><a class="nav-link" href="#settingslink" data-toggle="tab">Order's</a></li>
                          
                        </ul>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content">
                          <div class="active tab-pane" id="activity">
                            <!-- product list -->
                            <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Product Name</th>
                                    <th> Image</th>
                                    <th  >Product Price</th>
                                    <th  >Type</th>
                                    <th  >created at</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
                          </div>
                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="timeline">
                              <input type="hidden"  name="userId" value="{{\Crypt::encryptString($vendor->id)}}">
                              @csrf
                            <div class="card card-default">
                            <table id="example1" class="table1 table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th > Title</th>
                                    <th> Sub Title</th>
                                    <th  >Link</th>
                                    <th  >created at</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
                            
                          </div>
                          <!-- /.tab-pane -->

                          <div class="tab-pane" id="settingslink">
                            <form class="form-horizontal">
                             
                            
                            </form>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
          </div>
      <!-- /.content-wrapper -->

        

<!-- /.row -->
@endsection


@section('js_section')

<script type="text/javascript">
  //$(function () {
     let table = $('#example').dataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('admin.chef.productlists',$vendor->id)}}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
             {data: 'product_name', name: 'product_name',orderable: false, searchable: false},
             {data: 'product_image', name: 'product_image'},
             {data: 'product_price', name: 'product_price'},
            {data: 'type', name: 'type'},
            {data: 'date', name: 'created_at'},
             {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
         ]
     });
    
    $('#customizable').change(function(){
        if ($(this).val() == 'true') {
          $('.custmization-block').show();
        } else {
          $('.custmization-block').hide();
        }
      })
      $('.add').click(function(){
        if ($('.variant_name').val() !='' && $('.price').val() !='') {
          var html = '<div class="row"><div class="col-md-4" style="text-align:center"><span>'+$('.variant_name').val()+'</span></div><div class="col-md-2"><span>'+$('.price').val()+'</span></div><div class="col-md-2"><button class="btn btn-danger "><i class="fa fa-trash"></i></button></div></div><br>';  
          $('.variant-container').append(html);
        }else{
          return false;
        }
        
        
      })
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
 <script type="text/javascript">
    let table1 = $('#example1').dataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('admin.cherf.video.link',\Crypt::encryptString($vendor->id))}}",
      //   {{ route('admin.cherf.videolink',\Crypt::encryptString($vendor->id)) }}
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
             {data: 'title', name: 'title',orderable: false, searchable: false},
             {data: 'sub_title', name: 'sub_title'},
             {data: 'link', name: 'link'},
             {data: 'date', name: 'created_at'},
             {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
         ]
    });
     function reload_table() {
      table1.DataTable().ajax.reload(null, false);
    }
  </script>
@endsection