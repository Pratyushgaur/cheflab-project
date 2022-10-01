@extends('admin.layouts.layoute')
@section('content')
<style>
    .image-link {
  cursor: -webkit-zoom-in;
  cursor: -moz-zoom-in;
  cursor: zoom-in;
}


/* This block of CSS adds opacity transition to background */
.mfp-with-zoom .mfp-container,
.mfp-with-zoom.mfp-bg {
	opacity: 0;
	-webkit-backface-visibility: hidden;
	-webkit-transition: all 0.3s ease-out; 
	-moz-transition: all 0.3s ease-out; 
	-o-transition: all 0.3s ease-out; 
	transition: all 0.3s ease-out;
}

.mfp-with-zoom.mfp-ready .mfp-container {
		opacity: 1;
}
.mfp-with-zoom.mfp-ready.mfp-bg {
		opacity: 0.8;
}

.mfp-with-zoom.mfp-removing .mfp-container, 
.mfp-with-zoom.mfp-removing.mfp-bg {
	opacity: 0;
}



/* padding-bottom and top for image */
.mfp-no-margins img.mfp-img {
	padding: 0;
}
/* position of shadow behind the image */
.mfp-no-margins .mfp-figure:after {
	top: 0;
	bottom: 0;
}
/* padding for main container */
.mfp-no-margins .mfp-container {
	padding: 0;
}



/* aligns caption to center */
.mfp-title {
  text-align: center;
  padding: 6px 0;
}
.image-source-link {
  color: #DDD;
}
</style>

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
                          <div class="row">
                          <div class="col-md-3">
                                <select name="" id="filter-by-role" onchange="reload_table()" class="form-control">
                                  <option value="">Filter By Status</option>
                                  <option value="2">Pending </option>
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>
                                  <option value="3">Reject</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                              
                                <select class="form-control select2" style="width: 100%;" id="filter-by-restaurant" onchange="reload_table()">
                                    <option value="">Select Restaurant</option>
                                    @foreach($vendor as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach;
                                </select>
                              </div>
                            </div>
                            
                          </div>
                          
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Vendor Product List </h3>
                   </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Restaurant Name</th>
                                    <th >Product Name</th>
                                    <th  >Image</th>
                                    <th  >Category</th>
                                    <th> Type</th>
                                    <th> Price</th>
                                    <th  >status</th>
                                    <th  >created at</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
                    </div>
                  </div>

                </div>
                
              </div>
            </div>
            <div class="modal fade bd-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                        
                    <div>
                 </div>
                  <div class="col-md-1 accept">
                    
                      <!-- <a href="{{route('admin.chef.create')}}" class="pull-right btn btn-sm btn-success " style=" color:#fff;"><i class="fa fa-search"> </i> Filter</a> -->
                  </div>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="col-md-12">
                      <!-- Widget: user widget style 2 -->
                      <div class="card card-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-warning">
                          <div class="widget-user-image">
                            
                          </div>
                          <h3 class="widget-user-username">

                          </h3> 
                          <h5 class="widget-user-desc"></h5>
                        </div>
                        <div class="card-footer p-0">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a href="#" class="nav-link" id="type">
                                 
                              </a>
                            </li>
                            <li class="nav-item">
                              <a href="#" class="nav-link"  id="menu">
                                Menu 
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>
                      <!-- /.widget-user -->
                    </div>
                    <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                
                      <th >Product Name</th>
                      <th> Image</th>
                      <th  >Cuisines </th>
                      <th  > Category</th>
                      <th  > Catalogue </th>
                      <th  >Product Price</th>
                      <th  >Type</th>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                   
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->



                  </div>
                  
                </div>
               
              </div>
            </div>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Product Reject Reason</h4>
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
                                          <label for="exampleInputEmail1">Reason</label>
                                          <div id="slot_id"></div>
                                          <textarea type="text" name="cancel_reason" class="form-control"  id="exampleInputEmail1" placeholder="Enter Your Rejoin"></textarea>   
                                         
                                        </div>  
                                    </div>
                                </div>
                            </div>
  
                            <button class="btn btn-primary float-right" type="submit">Submit</button>
                      </form>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.magnific-popup/1.0.0/jquery.magnific-popup.js"></script>
<script>
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        //ajax: "{{ route('admin.vendors.datatable') }}",
        ajax:{
            url:"{{ route('admin.product.pendingdata')}}",
            data: function (d) {
                d.rolename = $('#filter-by-role').val(),
                d.restaurant = $('#filter-by-restaurant').val()
            }
        },
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'}, 
          {data: 'restaurantName', name: 'restaurantName'},
          {data: 'product_name', name: 'product_name'},
          {data: 'product_image', name: 'product_image',orderable: false, searchable: false},
          {data: 'categoryName', name: 'categoryName'},
          {data: 'type', name: 'type'},
          {data: 'product_price', name: 'product_price'},
          {data: 'status', name: 'status',orderable: false, searchable: false},
          {data: 'date', name: 'created_at'},
          {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });
  $(document).on('click', '.openModal', function () {
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("admin.vendor.getId")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: { 
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
             
              var uh = JSON.stringify(response);
              var obj = JSON.parse(uh);
              console.log(obj.product['status']);
             // $vendorimg = '<img src=""{{url('vendor')}}/'+obj.vendor['image']+'" />'; 
             $vendorimg = '<img src="{{url('vendors')}}/'+obj.vendor['image']+'" alt="" >';  
             $('.widget-user-image').html($vendorimg);
              $('.widget-user-username').html(obj.vendor['name']); 
              $('.widget-user-desc').html("<p>"+obj.vendor['vendor_type']+"</p>");   
              
              $('#type').html("Food Type<span class='float-right badge bg-info'>"+obj.product['type']+"</span>");     
              $('#menu').html("Menu<span class='float-right badge bg-info'>"+obj.menu['menuName']+"</span>");     
              $btn1 = '<a href="javascript:void(0)" data-id="'+obj.product['id']+'" class="edit btn btn-warning btn-xs accept"  data-alert-message="Are You Sure to Accept this Product" flash="Product" " title="Accept">Accept</a> <a href="javascript:void(0)" data-id="'+obj.product['id']+'" class="btn btn-danger btn-xs rejectdata" data-toggle="modal" data-target="#modal-default"  id="closebtn">Reject</a>';
              $btn2 = '<a href="javascript:void(0)" data-id="'+obj.product['id']+'" class="btn btn-danger btn-xs rejectdata" data-toggle="modal" data-target="#modal-default"  id="closebtn">Reject</a>';
             if(obj.product['status'] == '2'){
              $('.accept').html($btn1);
             }else{
              $('.accept').html($btn2);
             }
              
              $img = '<img src="{{url('products')}}/'+obj.product['product_image']+'" alt=""  style="width: 50px;">';
          
              $('#tbody').html("<tr><td>"+obj.product['product_name']+"</td><td><a href='{{url("products")}}/"+obj.product['product_image']+"' class='without-caption image-link'>"+$img+"</td><td>"+obj.cuisines[0]['cuisinesName']+"</a></td><td>"+obj.category[0]['categoryName']+"</td><td>"+obj.menu['menuName']+"</td><td>"+obj.product['product_price']+"</td><td>"+obj.product['type']+"</td></tr>");
            }
      }); 
    
    
       // $('#slot_id').append("<input type='hidden' name='id' value="+id+">");{{route("admin.vendor.productactive",'obj.product["id"]')}}
    });
    $('#closebtn').click(function() {
        $('.openModal').modal('hide');
    });
    
    $(document).on('click', '.rejectdata', function () {
        var id = $(this).data('id');
       // alert(id);die;
        $('#slot_id').append("<input type='hidden' name='id' value="+id+">");
    });
    $(document).on('click', '.accept', function () {
      var id = $(this).data('id');
     // alert(id);die;
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("admin.vendor.productactive")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: { 
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
            
              $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Success',
                subtitle: '',
                body: 'Product Published on Application'
              })
               window.location.reload();
             // $('#price').append("<p class='text-danger' name='id' value="+obj.id+">Banner Rs.. "+obj.price+"</p>","<input type='hidden' name='price' value="+obj.price+">","<input type='hidden' name='id' value="+obj.id+">","<input type='hidden' name='slot_name' value="+obj.slot_name+">","<input type='hidden' name='position' value="+obj.position+">");      
            }
      }); 
      $('#price').empty().append();
    });




    $(document).on('click', '.close', function () {
      $('#slot_id').empty(); 
    });
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
    
 <script>
    $(document).ready(function() {
      $('.without-caption').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});

$('.with-caption').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		mainClass: 'mfp-with-zoom mfp-img-mobile',
		image: {
			verticalFit: true,
			titleSrc: function(item) {
				return item.el.attr('title') + ' &middot; <a class="image-source-link" href="'+item.el.attr('data-source')+'" target="_blank">image source</a>';
			}
		},
		zoom: {
			enabled: true
		}
	});
});
 </script>
@endsection