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
              
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12"> 
                <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
               User Conta Management
            </h3>
          </div>
          <div class="card-body">
           
            <div class="row">
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Privacy Policy</a>
                  <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Terms & Condition</a>
                  <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Refund Cancellation</a>
                  <a class="nav-link" id="vert-tabs-refund-tab" data-toggle="pill" href="#vert-tabs-refund" role="tab" aria-controls="vert-tabs-refund" aria-selected="false">FAQ</a>
                </div>
              </div>
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                            Privacy Policy
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pad table-responsive">
                            <form id="restaurant-form" action="{{route('admin.user.storePrivacy')}}" method="post" enctype="multipart/form-data">
                               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                 <div class="card card-default">
                                    <div class="card-body">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <textarea id="summernote" name="user_privacy_policy">
                                            {{$data->user_privacy_policy}}
                                        </textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success" ><i class="fa fa-save"></i>Update </button>
                                    </div>
                                  </div>
                              </form>
                          </div>
                            

                    </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                    <div class="card card-outline card-info">
                          <div class="card-header">
                              <h3 class="card-title">
                                User Terms & Condition
                              </h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body pad table-responsive">
                              <form id="restaurant-form" action="{{route('admin.user.storeVendorTC')}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                  <div class="card card-default">
                                      <div class="card-body">
                                          <input type="hidden" name="id" value="{{$data->id}}">
                                          <textarea id="privacy_policy" name="terms_conditions_user">
                                              {{$data->terms_conditions_user}}
                                          </textarea>
                                      </div>
                                      <div class="card-footer">
                                          <button class="btn btn-success" ><i class="fa fa-save"></i>Update </button>
                                      </div>
                                    </div>
                                </form>
                            </div>
                              

                      </div>
                  </div>
                  
                  <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                            Refund Cancellation 
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pad table-responsive">
                            <form id="restaurant-form" action="{{route('admin.globle.storeDeliveryTC')}}" method="post" enctype="multipart/form-data">
                               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                 <div class="card card-default">
                                    <div class="card-body">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <textarea id="deliveryboy" name="refund_cancellation_user">
                                            {{$data->refund_cancellation_user}}
                                        </textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success" ><i class="fa fa-save"></i>Update </button>
                                    </div>
                                  </div>
                              </form>
                          </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="vert-tabs-refund" role="tabpanel" aria-labelledby="vert-tabs-refund-tab">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                            FAQ
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pad table-responsive">
                            <form id="restaurant-form" action="" method="post" enctype="multipart/form-data">
                               <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                 <div class="card card-default">
                                    <div class="card-body">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <textarea id="refund" name="refund_cancellation_cheflab">
                                            {{$data->refund_cancellation_cheflab}}
                                        </textarea>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-success" ><i class="fa fa-save"></i>Update </button>
                                    </div>
                                  </div>
                              </form>
                          </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- /.card -->
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>





    

<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
    $('#summernote').summernote()
    $('#privacy_policy').summernote()
    $('#cheflabtc').summernote() 
    $('#deliveryboy').summernote()
    $('#refund').summernote()
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    $('.custmization-block').hide();
    $('.gstavailable').change(function(){
      if ($(this).val()  == 'yes') {
        $('.custmization-block').show();
      } else {
        $('.custmization-block').hide();
      }
    })
    

      $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
      $('#file-input2').change( function(event) {
          $("img.icon2").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon2").parents('.upload-icon2').addClass('has-img2');
      });
      $('#file-input3').change( function(event) {
          $("img.icon3").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon3").parents('.upload-icon3').addClass('has-img3');
      });
      $('#file-input4').change( function(event) {
          $("img.icon4").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon4").parents('.upload-icon4').addClass('has-img4');
      });
  });
 </script>
@endsection