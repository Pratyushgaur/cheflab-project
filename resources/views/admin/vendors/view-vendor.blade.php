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
                      <li class="breadcrumb-item active">User Profile</li>
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
                            <b>Like's</b> <a class="float-right">1,322</a>
                          </li>
                          <li class="list-group-item text-success">
                            <b>Success Order's</b> <a class="float-right">50</a>
                          </li>
                          <li class="list-group-item text-danger">
                            <b>Cancel Order's</b> <a class="float-right">10</a>
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
                        </ul>
                        @if($vendor->vendor_type == 'chef')
                        <a href="#" class="btn btn-primary btn-block"><b>Add New Product</b></a>
                        @endif
                        
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
                        <p class="text-muted">Bhawar Kua , Indore</p>
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
                          <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Add New Product</a></li>
                          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Order's</a></li>
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
                                    <th  >Product Price</th>
                                    <th  >Customizable</th>
                                    <th> Status</th>
                                    <th> Image</th>
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
                              <div class="card-header">
                                    <h3 class="card-title">Product Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Name of Product</label>
                                          <input type="text" name="product_name" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Product Name">
                                        
                                      </div>  
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Cuisines</label>
                                          <select class="form-control select2" name="category" style="width: 100%;">
                                                @foreach($cuisines as $k =>$value)
                                                  <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                          </select>
                                      </div>  
                                    </div>


                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Categories</label>
                                        <select class="form-control select2" style="width: 100%;">
                                          @foreach($categories as $k =>$value)
                                          <option value="{{$value->id}}">{{$value->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    
                                    

                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Product Description</label>
                                          <textarea class="form-control" name="dis" ></textarea>
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                        
                                          <label for="exampleInputEmail1">Product Type</label><br>
                                          
                                          <div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                              <input type="radio" id="veg" name="type" value="veg" checked>
                                              <label for="veg">Veg</label>
                                            </div>
                                            <div class="icheck-danger d-inline">
                                              <input type="radio" id="non_veg" name="type" value="non_veg">
                                              <label for="non_veg">Non Veg</label>
                                            </div>
                                            <div class="icheck-warning d-inline">
                                              <input type="radio" id="eggs" name="type" value="eggs">
                                              <label for="eggs">Eggs</label>
                                            </div>
                                            
                                          </div>
                                      </div>  
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="">Product Price</label>
                                          <input type="text" name="product_price" class="form-control"  id="product_owner" placeholder="Product Price">
                                      </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="">Customizable Availablity</label>

                                          
                                          <select name="customizable" id="customizable" class="form-control">
                                            <option value="false">No</option>
                                            <option value="true">Yes</option>
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-md-3">
                                      <div class="form-group">
                                          <label for="">Addons </label>
                                          <select name="customizable" id="" class="form-control">
                                            <option value="false">No</option>
                                            <option value="true">Yes</option>
                                          </select>
                                      </div>
                                    </div>

                                
                                  </div>

                                    
                                </div>
                                <div class="custmization-block" style="display:none">
                                  <div class="row">
                                    <div class="col-md-12">
                                        <h3>Add More Variant</h3>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control variant_name"  placeholder="Enter Variant Name">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control price" placeholder="Enter Price">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary add">Add This Variant</button>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="variant-container"> 
                                  </div>
                                  
                                </div>
                                
                                

                              </div>
                              <div class="card-footer">
                                  <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                            
                          </div>
                          <!-- /.tab-pane -->

                          <div class="tab-pane" id="settings">
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
  // $(function () {
    // let table = $('#example').dataTable({
    //     processing: true,
    //     serverSide: true,
    //     //ajax: "{{ route('admin.vendors.datatable') }}",
    //     ajax:{
    //         url:"{{ route('admin.vendors.datatable') }}",
    //         data: function (d) {
    //             d.rolename = $('#filter-by-role').val()
    //         }
    //     },
    //     columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'name', name: 'name'},
    //         {data: 'email', name: 'email'},
    //         {data: 'vendor_type', name: 'vendor_type'},
    //         {data: 'status', name: 'status',orderable: false, searchable: false},
    //         {data: 'image', name: 'image',orderable: false, searchable: false},
    //         {data: 'wallet', name: 'wallet'},
    //         {data: 'date', name: 'created_at'},
    //         {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
    //     ]
    // });
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
@endsection