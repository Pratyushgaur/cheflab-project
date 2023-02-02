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
                  <h1>Payout Settings</h1>
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
                <div class="col-lg-12 col-6">
                  <div class="card card-primary card-outline">                    
                    <div class="card-header">
                      <h3 class="card-title">Update Payout Setting </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.payout.storeGernel')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="id" value="{{ $data->id }}" />
                        
                              <div class="row align-items-center">  
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="additions">Additions <small> (Cancellation refund to vendor)</small></label>
                                      <div class="input-group mb-3">
                                          <input type="text" class="form-control" name="additions" value="{{ $data->additions }}">
                                          <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                  <label for="additions">Convenience Fee for vendor (Including GST)</label>
                                    <div class="custom-control custom-switch">
                                      
                                      <input type="checkbox" class="custom-control-input" id="switch1" name="toggle" onchange="get_toggle()" value="0" @if($data->toggle == '1') checked @endif>

                                      <input type="hidden" class="custom-input"  name="hiddentoggle" onchange="get_toggle()" value="0">
                                      <label class="custom-control-label" for="switch1"></label>
                                    </div>
                                  </div>
                                  <div class="col-md-6" id="convenience_id">
                                    <div class="form-group">
                                      <!-- <label for="additions">Convenience Fee for vendor (Including GST)</label> -->
                                      <div class="input-group mb-3">
                                          <input type="text" class="form-control" name="convenience_fee" value="{{ $data->convenience_fee }}">
                                          <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="additions">Order Rejection Charges for vendor </label>
                                      <div class="input-group mb-3">
                                          <input type="text" class="form-control" name="order_rejection" value="{{ $data->order_rejection }}">
                                          <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              
                         <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i> Update </button>
                          </div>
                      </form>
                    </div>

                  </div>
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
$(document).ready(function(){
  get_toggle();
});
function get_toggle(){  
  if($('.custom-control-input').is(":checked")){
      $('#convenience_id').show();
      var check = $('.custom-input').val(1);
   }else{
    $('#convenience_id').hide();
    var check = $('.custom-input').val(0);
   }
};
  

 </script>
@endsection