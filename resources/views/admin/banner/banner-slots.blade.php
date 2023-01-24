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
                                    
                                    <th>Position</th>
                                    <th >Price</th>
                                    <th>Banner For</th>
                                    <th>Action</th>
                                  </tr>
                            </thead>
                            <tbody>
                              @foreach($slots as $Key =>$value)
                              <tr>
                                <td>1</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->position}}</td>
                                <td>{{$value->price}}</td>
                                <td>{{$value->banner_for}}</td>
                                <td>
                                  <a href="#" class="edit-btn" data-price="{{$value->price}}"  data-id="{{$value->id}}" data-name="{{$value->name}}"><i class="fas fa-edit"></i></a>
                                  <a href="{{route('banner.promotion.booking.list',$value->id)}}" class="btn btn-primary btn-xs">Bookings</i></a>
                                  <!-- <a href="{{route('banner.promotion.booking.list',$value->id)}}" class="btn btn-primary btn-xs">Active</i></a> -->
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                            
                        </table>
                    </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
		</div>
    </section>
    <!-- /.content -->
  </div>
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('banner.promotion.slot.edit')}}" method="post">
        @csrf
        <input type="hidden" class="position_id" name="position_id" required>
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Banner Slot</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="">Name Position</label>
            <input type="text" name="position_name" class="form-control position_name" required>
          </div>
          <div class="form-group">
            <label for="">Price</label>
            <input type="number" name="position_price" class="form-control position_price" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
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
    // let table = $('#example').dataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{route('admin.slot.data')}}",
    //     columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'slot_name', name: 'slot_name'},
    //         {data: 'position', name: 'position'},
    //         {data: 'price', name: 'price'},
    //         {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
    //     ]
    // });
    let table = $('#example').dataTable({
      paging: false
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
    $('.edit-btn').click(function(){
      $('.position_name').val($(this).attr('data-name'));
      $('.position_price').val($(this).attr('data-price'));
      $('.position_id').val($(this).attr('data-id'));
      $('#exampleModal').modal('show');
    })
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection