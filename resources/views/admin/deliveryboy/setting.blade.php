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
        /*  */
        .upload-icon3{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon3 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon3.has-img3{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon3.has-img3 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        




        .upload-icon4{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon4 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon4.has-img4{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon4.has-img4 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        .select2-selection__choice{
          background:#007bff !important;
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
                  <h1>Delivery Boy Settings And Management </h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Settings And Management</li>
                  </ol>
                </div>
              </div>
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="row">
                
                <!-- Start of Genral Setting -->
                
                <!-- End of Genral Setting -->
                
                <!-- End of Payemnt Setting -->
                <div class="col-lg-12 col-6">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Update Delivery Person Setting </h3>  
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.deliveryboy.storeDelivercharge')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >User To Admin</h3><h3 class="card-title text-bold" style="margin-left:600px;">Admin To Rider</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">First three KM Charges (0-3)<span class="text-danger">*</span></label>
                                        <input type="number" value="{{$data->first_three_km_charge_user}}" name="first_three_km_charge_user" class="form-control"  id="exampleInputEmail1" placeholder="Enter Fix Charge">
                                      <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                  </div> 
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">First three KM Charges (0-3) <span class="text-danger">*</span></label>
                                      <input type="number" name="first_three_km_charge_admin" value="{{$data->first_three_km_charge_admin}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div> 
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">3-6 Kms (per km)<span class="text-danger">*</span></label>
                                      <input type="number" name="three_km_to_six_user" value="{{$data->three_km_to_six_user}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>
                                </div> 
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">3-6 Kms (per km) <span class="text-danger">*</span></label>
                                      <input type="number" name="three_km_to_six_admin" value="{{$data->three_km_to_six_admin}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">6 and above Kms (per km) <span class="text-danger">*</span></label>
                                      <input type="number" name="six_km_above_user" value="{{$data->six_km_above_user}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">6 and above Kms (per km) <span class="text-danger">*</span></label>
                                      <input type="number" name="six_km_above_admin" value="{{$data->six_km_above_admin}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Extra charges (per order) <span class="text-danger">*</span></label>
                                      <input type="number" name="extra_charges_user" value="{{$data->extra_charges_user}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                      <br>
                                      <div class="custom-control custom-switch">
                                        <input type="checkbox" name="extra_charge_active" class="custom-control-input" id="customSwitch1" @if($data->extra_charge_active) checked  @endif>
                                        <label class="custom-control-label" for="customSwitch1">Extra Charges (Night Hike & Festival Hike / Order) Switch</label>
                                      </div>
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Extra charges <span class="text-danger">*</span></label>
                                      <input type="number" name="extra_charges_admin" value="{{$data->extra_charges_admin}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                </div>
                                <hr>
                          <!-- schedule information start -->
                            <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Rating Incentive weekly basis</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                <div class="card-header">
                                    <h3 class="card-title text-bold" >4.3 to 4.7</h3><h3 class="card-title text-bold" style="margin-left:600px;">4.8 To 5.0</h3>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">50 orders<span class="text-danger">*</span></label>
                                      <input type="number" name="fifteen_order_incentive_4" value="{{$data->fifteen_order_incentive_4}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">50 orders <span class="text-danger">*</span></label>
                                      <input type="number" name="fifteen_order_incentive_5" value="{{$data->fifteen_order_incentive_5}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">75 orders <span class="text-danger">*</span></label>
                                      <input type="number" name="sentientfive_order_incentive_4" value="{{$data->sentientfive_order_incentive_4}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">75 orders <span class="text-danger">*</span></label>
                                      <input type="number" name="sentientfive_order_incentive_5" value="{{$data->sentientfive_order_incentive_5}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">100 orders <span class="text-danger">*</span></label>
                                      <input type="number" name="hundred_order_incentive_4" value="{{$data->hundred_order_incentive_4}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">100 orders <span class="text-danger">*</span></label>
                                      <input type="number" name="hundred_order_incentive_5" value="{{$data->hundred_order_incentive_5}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">No of order cancel <span class="text-danger">*</span></label>
                                      <input type="number" name="no_of_order_cancel" value="{{$data->no_of_order_cancel}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="card-header">
                                    <h3 class="card-title text-bold" >Rider to restourant distance payout (per km)</h3><h3 class="card-title text-bold" style="margin-left:600px;"></h3>
                                </div>
                               
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Below 1.5 km <span class="text-danger">*</span></label>
                                      <input type="number" name="below_one_five_km" value="{{$data->below_one_five_km}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Above 1.5 km <span class="text-danger">*</span></label>
                                      <input type="number" name="above_one_five_km" value="{{$data->above_one_five_km}}" class="form-control"  id="" placeholder="Enter Per KM Charge">
                                  </div>  
                                </div>
                                </div>  
                              </div>
                            </div>



                              </div>
                            </div>
                        </div>
                         <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i>Update </button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- End of Delivery Person Setting -->
          
                
                <div class="col-lg-12 col-6">
                  <div class="card card-primary card-outline">
                  </div>
                </div>
            </div> 
            <!-- End Of Row -->
          </section>
          <!-- /.content -->
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
        ajax: "{{route('admin.vendorstore.data')}}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'app_position', name: 'app_position'},
            {data: 'blog_type', name: 'blog_type'},
            {data: 'status', name: 'status',orderable: false, searchable: false},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#banner-form").validate({
      rules: {
            blog_position: {
                required: true
            },
            blog_type: {
                required: true
            },
            name:{
              required: true,
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
 <script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
@endsection