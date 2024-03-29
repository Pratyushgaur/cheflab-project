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
                  <h1>Settings And Management </h1>
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
                <div class="col-lg-12 col-6">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Update Genral Setting </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.globle.storeGernel')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                  <div class="col-md-6" style="display:none;">
                                      <div>
                                        <label for="">Company  Logo</label>
                                      </div>
                                      <div class="image-upload">
                                          <label for="file-input">
                                              <div class="upload-icon">
                                                  <img class="icon" src="{{ asset('logo'.'/'.$data->logo ) }}">
                                              </div>
                                          </label>
                                          <input id="file-input" type="file" name="logo">
                                      </div>   
                                  </div>
                                  <div class="col-md-6" style="display:none;">
                                       <div>
                                        <label for="">Company Favicon </label>
                                      </div>
                                      <div class="image-upload">
                                          <label for="file-input2">
                                              <div class="upload-icon2">
                                                  <img class="icon2" src="{{ asset('logo'.'/'.$data->favicon ) }}">
                                              </div>
                                          </label>
                                          <input id="file-input2" type="file" name="favicon"/>
                                          
                                      </div> 
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Business Name<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->company_name}}" name="company_name" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                      <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Email<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->email}}" name="email" class="form-control"  id="exampleInputEmail1" placeholder="Enter Suport Email">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Contact Number<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->phone}}" name="phone" class="form-control"  id="exampleInputEmail1" placeholder="Enter Contact Number">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Support Contact Number<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->suport_phone}}" name="suport_phone" class="form-control"  id="exampleInputEmail1" placeholder="Enter Support Conteact Number">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Office Address<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->office_addres}}" name="office_addres" class="form-control"  id="exampleInputEmail1" placeholder="Enter Office Address">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">GST NO<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->gstno}}" name="gstno" class="form-control"  id="exampleInputEmail1" placeholder="Enter GST NO">
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">CIN NO<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->cin_no}}" name="cin_no" class="form-control"  id="exampleInputEmail1" placeholder="Enter CIN NO">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">FSSAI NO<span class="text-danger">*</span></label>
                                      <input type="text" value="{{$data->fssai_no}}" name="fssai_no" class="form-control"  id="exampleInputEmail1" placeholder="Enter FSSAI NO">
                                    </div>
                                  </div>


                                  <div class="col-md-6" style="display:none;">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Google Map Key<span class="text-danger">*</span></label>
                                      <input type="text" name="goofle_map_key" value="{{$data->goofle_map_key}}" class="form-control"  id="" placeholder="Enter Google Map Key">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">About Us<span class="text-danger">*</span></label>
                                      <textarea name="aboutus" class="form-control" value="{{$data->aboutus}}"  id="" placeholder="About..">{{$data->aboutus}}</textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Facebook Link<span class="text-danger">*</span></label>
                                      <textarea name="facebook_link" class="form-control" value="{{$data->facebook_link}}"  id="" placeholder="Facebook Link..">{{$data->facebook_link}}</textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Instagram Link<span class="text-danger">*</span></label>
                                      <textarea name="instagram_link" class="form-control" value="{{$data->instagram_link}}"  id="" placeholder="Instagram Link..">{{$data->instagram_link}}</textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Youtube Link<span class="text-danger">*</span></label>
                                      <textarea name="youtube_link" class="form-control" value="{{$data->youtube_link}}"  id="" placeholder="Youtube Link..">{{$data->youtube_link}}</textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Application Get Order Switch<span class="text-danger">* (This Attempt Will Stop get Order in Application)</span></label>
                                      <select class="form-control app_run"  name="app_run" id="">
                                        <option value="1" @if($data->app_run == '1') selected @endif >On</option>
                                        <option value="0" @if($data->app_run == '0') selected @endif>Off</option>
                                      </select>
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-6 close-reason" style="@if($data->app_run == '1')display:none;@endif">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Reason Why We are Not Getting Ordres <span class="text-danger">* </span></label>
                                      <textarea name="reason_close" class="form-control" value="{{$data->app_close_reason}}"  id="" placeholder="Reason Why We are Not Getting Ordres..">{{$data->app_close_reason}}</textarea>
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-6 " style="">
                                      <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-group">
                                          <label for="exampleInputEmail1">Free Delivery</label>

                                            <select name="free_delivery" id="" class="form-control">
                                              <option value="0" @if($data->free_delivery == '0') selected @endif>OFF</option>
                                              <option value="1" @if($data->free_delivery == '1') selected @endif>ON</option>
                                            </select>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">Free Delivery criteria in Km</label>
                                            
                                            <input type="number" name="free_delivery_criteria" class="form-control" value="{{$data->free_delivery_criteria}}"  id="" placeholder="Enter number in km" required>
                                            
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">Charge of per Km after out of criteria</label>
                                            
                                            <input type="number" name="charge_after_criteria" class="form-control" value="{{$data->charge_after_criteria}}"  id="" placeholder="Enter Amount for per Km out of Criteria" required>
                                            
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
                <!-- End of Genral Setting -->
                
                
                <!-- End of Payemnt Setting -->
                <!-- application version and update setting  -->
                <div class="col-lg-12 col-12">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Application (User) Version And Update Setup for Android </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.globle.store_user_app_version')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >User Application Update</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Current Version of User App<span class="text-danger">*</span></label>
                                    <input type="text" value="{{$data->user_app_current_version}}" name="user_app_current_version" class="form-control"  id="exampleInputEmail1" placeholder="User App Current Version" required>
                                    <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Soft Update</label>
                                    
                                    <select name="soft_update" class="form-control soft_update">
                                      <option value="0" @if($data->user_app_soft_update == "0") selected @endif  >false</option>
                                      <option value="1" @if($data->user_app_soft_update == "1") selected @endif>True</option>
                                    </select>
                                  </div>
                                  <!--  -->
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Force Update</label>
                                    
                                    <select name="force_update" class="form-control force_update">
                                      <option value="0" @if($data->user_app_force_update == "0") selected @endif>false</option>
                                      <option value="1" @if($data->user_app_force_update == "1") selected @endif>True</option>
                                    </select>
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
                <div class="col-lg-12 col-12">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Application (User) Version And Update Setup for Ios </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.globle.store_ios_user_app_version')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >User Application Update</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Current Version of User IOS App<span class="text-danger">*</span></label>
                                    <input type="text" value="{{$data->ios_user_app_version}}" name="user_app_current_version" class="form-control"  id="exampleInputEmail1" placeholder="User App Current Version" required>
                                    <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Soft Update</label>
                                    
                                    <select name="soft_update" class="form-control soft_update2">
                                      <option value="0" @if($data->ios_user_app_soft_update == "0") selected @endif  >false</option>
                                      <option value="1" @if($data->ios_user_app_soft_update == "1") selected @endif>True</option>
                                    </select>
                                  </div>
                                  <!--  -->
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Force Update</label>
                                    
                                    <select name="force_update" class="form-control force_update2">
                                      <option value="0" @if($data->ios_user_app_force_update == "0") selected @endif>false</option>
                                      <option value="1" @if($data->ios_user_app_force_update == "1") selected @endif>True</option>
                                    </select>
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
                <div class="col-lg-12 col-12">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Application (Rider) Version And Update Setup  </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.globle.store_rider_app_version')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >User Application Update</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Current Version of Rider App<span class="text-danger">*</span></label>
                                    <input type="text" value="{{$data->driver_app_current_version}}" name="user_app_current_version" class="form-control"  id="exampleInputEmail1" placeholder="User App Current Version" required>
                                    <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Soft Update</label>
                                    
                                    <select name="soft_update" class="form-control soft_update3">
                                      <option value="0" @if($data->driver_app_soft_update == "0") selected @endif  >false</option>
                                      <option value="1" @if($data->driver_app_soft_update == "1") selected @endif>True</option>
                                    </select>
                                  </div>
                                  <!--  -->
                                  <div class="form-group">
                                    <label for="exampleInputEmail1">Force Update</label>
                                    
                                    <select name="force_update" class="form-control force_update3">
                                      <option value="0" @if($data->driver_app_force_update == "0") selected @endif>false</option>
                                      <option value="1" @if($data->driver_app_force_update == "1") selected @endif>True</option>
                                    </select>
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
                <!-- end of version setting -->
                <!-- Change Password start  -->
                <div class="col-lg-12 col-6">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Payment gateway setup </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <!-- <form id="restaurant-form" action="{{route('admin.globle.change_password')}}" method="post" enctype="multipart/form-data"> -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="row">
                            <div class="col-md-6">
                              <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title text-bold" >CashFree credentials setup</h3>
                                </div>
                                <div class="card-body">
                                  <div class="error">
                                    @if($errors->any())
                                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                    @endif
                                  </div>
                                  <form action="{{route('admin.globle.setting.cashfree.setup')}}">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">App Id<span class="text-danger">*</span></label>
                                          <input type="text"  name="cashfree_app_id" class="form-control"  id="exampleInputEmail1" placeholder="Enter App Id" value="{{$data->cashfree_app_id}}" required>
                                          
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Secret key <span class="text-danger">*</span></label>
                                          <input type="text"  name="cashfree_secret_key" class="form-control"  id="exampleInputEmail1" placeholder="Secret Key" value="{{$data->cashfree_secret_key}}" required>
                                        </div>
                                        <div class="form-group">
                                          <input type="submit" class="btn btn-success" value="Save">
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="card card-default">
                                  <div class="card-header">
                                      <h3 class="card-title text-bold" >RazorPay Credentials setup</h3>
                                  </div>
                                  <div class="card-body">
                                    <div class="error">
                                      @if($errors->any())
                                          {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                      @endif
                                    </div>
                                    <form action="{{route('admin.globle.setting.razorpay.setup')}}">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">RAZOR KEY<span class="text-danger">*</span></label>
                                            <input type="text"  name="razorpay_key" class="form-control"  id="exampleInputEmail1" placeholder="Enter App Id" value="{{$data->razorpay_key}}" required>
                                            
                                          </div>
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">RAZOR SECRET <span class="text-danger">*</span></label>
                                            <input type="text" name="razorpay_key_secret_key" class="form-control"  id="exampleInputEmail1" placeholder="Secret Key" value="{{$data->razorpay_secret_key}}" required>
                                          </div>
                                          <div class="form-group">
                                            <input type="submit" class="btn btn-success" value="Save">
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                              </div>
                          </div>
                        </div>
                        
                         <div class="card-footer">
                            <!-- <button class="btn btn-success" ><i class="fa fa-save"></i>Update </button> -->
                          </div>
                      <!-- </form> -->
                    </div>

                  </div>
                </div>
                <!-- Change Password -->
                <div class="col-lg-12 col-6">
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Update Delivery Person Setting </h3>  
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.globle.storeDelivercharge')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Platform Delivery Charges<span class="text-danger">*</span></label>
                                        <input type="text" value="{{$data->platform_charges}}" name="platform_charges" class="form-control"  id="exampleInputEmail1" placeholder="Enter Fix Charge">
                                      <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
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
                    <!-- small box -->
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Update  Refer And Earn Massage</h3>  
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.refer.amountUpdate')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>
                            </div>
                            <div class="card-body">
                              <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                <div class="form-group">
                                      <label for="exampleInputEmail1">Refer Ammount <span class="text-danger">*</span></label>
                                      <input type="text" name="refer_amount" value="{{$data->refer_amount}}" class="form-control"  id="" placeholder="Enter Refer Ammount">
                                  </div> 
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Massage<span class="text-danger">*</span></label>
                                        <textarea type="text" value="{{$data->refer_earn_msg}}" name="refer_earn_msg" class="form-control"  id="exampleInputEmail1" placeholder="Enter Refer Earn Massage">{{$data->refer_earn_msg}}</textarea>
                                      <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
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
                <!-- End of charges -->
                <div class="col-lg-12 col-6">
                  <div class="card card-primary card-outline">
                      <div class="card-header">
                        <h3 class="card-title">Update Default Time Setup Setting </h3>  
                      </div>
                      <div class="card-body pad table-responsive">
                        <form id="restaurant-form" action="{{route('admin.globle.storeDefaultTime')}}" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                  <h3 class="card-title text-bold" >Basic Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="error">
                                  @if($errors->any())
                                      {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                  @endif
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="exampleInputEmail1">Default Preparation Time<span class="text-danger">*</span></label>
                                          <input type="text" value="{{$data->max_preparation_time}}" name="default_cooking_time" class="form-control"  id="exampleInputEmail1" placeholder="Cook Default Time">
                                          <input type="hidden" name="id" value="{{$data->id}}" class="form-control"  id="exampleInputEmail1" placeholder="Enter Business Name">
                                    </div> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Default Delivery Time<span class="text-danger">*</span></label>
                                        <input type="text" name="default_delivery_time" value="{{$data->default_delivery_time}}" class="form-control"  id="" placeholder="Delivery Boy Default Time">
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
                </div>
                <!-- End of Default Time Setup Setting -->
                
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
    $('.app_run').change(function(){
      if($(this).val() =='0'){
        $('.close-reason').show();
      }else{
        $('.close-reason').hide();

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
    $('.soft_update').change(function(){
      if($(this).val() == '0'){
        $('.force_update').val('1');
      }else{
        $('.force_update').val('0');
      }
    });
    $('.force_update').change(function(){
      if($(this).val() == '0'){
        $('.soft_update').val('1');
      }else{
        $('.soft_update').val('0');
      }
    });
    $('.soft_update2').change(function(){
      if($(this).val() == '0'){
        $('.force_update2').val('1');
      }else{
        $('.force_update2').val('0');
      }
    });
    $('.force_update2').change(function(){
      if($(this).val() == '0'){
        $('.soft_update2').val('1');
      }else{
        $('.soft_update2').val('0');
      }
    });
    $('.soft_update3').change(function(){
      if($(this).val() == '0'){
        $('.force_update3').val('1');
      }else{
        $('.force_update3').val('0');
      }
    });
    $('.force_update3').change(function(){
      if($(this).val() == '0'){
        $('.soft_update3').val('1');
      }else{
        $('.soft_update3').val('0');
      }
    });
        
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection