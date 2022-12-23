@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
    
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
        .image-upload{
            display:inline-block;
            margin-right:15px;
            position:relative;
        }
        .image-upload > input
        {
            display: none;
        }
        .upload-icon{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        
        
        .upload-icon img{
          width: 100px;
          height: 100px;
          margin:19px;
          cursor: pointer;
        }
        
        
        .upload-icon.has-img {
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon.has-img img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        /*  */
        .upload-icon2{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon2 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon2.has-img2{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon2.has-img2 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
      </style>
@endsection
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Position List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Slot List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
  		<div class="card card-info col-md-12">
            <div class="card-header">
              <h3 class="card-title">List</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th  class="text-center">Sr No.</th>
                                    <th >Slot Name</th>
                                    <th >Position</th>
                                    <th >Price</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            
                        </table>
                    </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
		</div>
    </section>
    <!-- /.content -->
    <section class="content">
            <div class="container-fluid">
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
                                        <a href="#" class="pull-right btn btn-sm btn-success " style="float: right;  color:#fff;"><i class="fa fa-plus"> </i> Create New Restaurant</a>
                                    </div>
                                    <div class="col-md-3">
                                    <a href="#" class="pull-right btn btn-sm btn-success " style="  color:#fff;"><i class="fa fa-user"> </i> Create New Chef</a>
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
                                <h3 class="card-title">Listing of Promotion Booking </h3>
                            </div>
                            <div class="card-body pad table-responsive">
                                <table id="example1" class="table1 table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="text-center">Sr No.</th>
                                        <th>Vendor name </th>
                                        <th>Email/Mobile</th>
                                        <th>Slot Name</th>
                                        <th> Position</th>
                                        <th> Price</th>
                                        <th>Image</th>
                                        <th>created at</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                               
                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </section>   

  </div>
  <!-- /.content-wrapper -->
 
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('admin.slot.data')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'slot_name', name: 'slot_name'},
            {data: 'position', name: 'position'},
            {data: 'price', name: 'price'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    let table1 = $('#example1').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('admin.slot.booking.data')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'vendorName', name: 'vendorName'},
            {data: 'mobile', name: 'mobile'},
            {data: 'slotName', name: 'slotName'},
            {data: 'from_date', name: 'from_date'},
            {data: 'to_date', name: 'to_date'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#banner-form").validate({
      rules: {
            name: {
                required: true,
                maxlength: 20,
                remote: '{{route("admin.banner.slotcheck")}}',
            },
            slote_date: {
                required: true,
                remote: '{{route("admin.banner.slotchecktime",)}}',
            },
            max_no_banner:{
              required: true,
            },
            banner: {
                required: true,
                number: true,
            },
        },
        messages: {
            name: {
                remote:"Name  Already Exist",
            },
            slote_date:{
                remote:"Date is  Required",
                remote:"Date is  allreadt Taken",
            },
            max_no_banner:{
                remote:"Select Max Banner Required",
            },
            banner:{
                remote:"Select Max Banner Required",
            }
            
        }
      });
      $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
      $('#file-input2').change( function(event) {
          $("img.icon2").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon2").parents('.upload-icon2').addClass('has-img2');
      });
       //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    });
    $('#timepicker1').datetimepicker({
      format: 'LT'
    });
    $("#timeSlote").change(function() {
        var value = +$(this).val();
        value *= 1;
        var nr = 0;
        var elem = $('#games').empty();
     
        while (nr < value) {
            elem.append($('<label for="category_name"> Banner priority amount <span class="text-danger">*</span></label><input type="text" id="name" name="banner[]" value="{{!empty($class_name[0]->name) ? $class_name[0]->name : ''}}" class="form-control" placeholder="Slot Name"><br>',{name : "whateverNameYouWant"}));
            nr++;
        }
        }); 
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection