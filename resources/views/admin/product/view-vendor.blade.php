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
                      <li class="breadcrumb-item active">Vendor Profile</li>
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
                            <b>Expe.</b> <a class="float-right">{{$vendor->experience}}</a>
                          </li>
                          <li class="list-group-item text-success">
                            <b>Restorent Type</b> <a class="float-right">
                              @if($vendor->vendor_food_type == 1)
                              veg
                              @elseif($vendor->vendor_food_type == 2)
                              Nonveg
                              @else
                              Eggs
                              @endif
                            </a>
                          </li>
                         
                          <li class="list-group-item ">
                            <b>Menu</b> <a class="float-right">{{$menu->menuName}}</a>
                          </li>                          
                        </ul>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-9">
                    <div class="card">
                      <div class="card-header p-2">
                        <ul class="nav nav-pills">
                          <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Product List</a></li>                          
                        </ul>
                      </div><!-- /.card-header -->
                      <div class="card-body">
                        <div class="tab-content">
                          <div class="active tab-pane" id="activity">
                            <!-- product list -->
                            <table id="example" class="table table-bordered table-hover dtr-inline datatable table-responsive" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Product Name</th>
                                    <th> Image</th>
                                    <th  >Status</th>
                                    <th  >Product Price</th>
                                    <th  >Categoris</th>
                                    <th  >Type</th>
                                    <th  >created at</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
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
              <div class="modal fade" id="modal-default">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Product Reject Rejoin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <form id="restaurant-form" action="{{route('admin.product.reject')}}" method="post" enctype="multipart/form-data">
                          @if ($errors->any())
                              @foreach ($errors->all() as $error)
                                  <div class="alert alert-danger">{{$error}}</div>
                              @endforeach
                          @endif
                          @csrf
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Rejoin</label>
                                          <div id="slot_id"></div>
                                          <textarea type="text" name="comment_reason" class="form-control"  id="exampleInputEmail1" placeholder="Enter Your Rejoin"></textarea>   
                                         
                                        </div>  
                                    </div>
                                </div>
                            </div>
  
                            <button class="btn btn-primary float-right" type="submit">Submit</button>
                      </form>
                  </div>
                  
                </div>
               
              </div>
             
            </div>
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
         ajax: "{{ route('admin.vendor.productList',$vendor->id)}}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
             {data: 'product_name', name: 'product_name',orderable: false, searchable: false},
             {data: 'product_image', name: 'product_image'},
             {data: 'status', name: 'status'},
             {data: 'product_price', name: 'product_price'},
             {data: 'categoryName', name: 'categoryName'},
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
         ],
    });
   
    $(document).on('click', '.openModal', function () {
        var id = $(this).data('id');
       // alert(id);die;
        $('#slot_id').append("<input type='hidden' name='id' value="+id+">");
    });
    $(document).on('click', '.close', function () {
      $('#slot_id').empty(); 
    });
     function reload_table() {
      table1.DataTable().ajax.reload(null, false);
    }
  </script>
@endsection