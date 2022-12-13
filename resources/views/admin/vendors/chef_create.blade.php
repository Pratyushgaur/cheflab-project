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
        /*  */
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
                      <h3 class="card-title">Create New Chef </h3>

                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.chef.store')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold" >Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Chef <span class="text-danger">*</span></label>
                                        <input type="text" name="restourant_name" class="form-control"  id="exampleInputEmail1" placeholder="Enter Chef Name">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control"  id="" placeholder="Enter Chef Email">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">DOB <span class="text-danger">*</span></label>
                                        <input type="date" name="dob" class="form-control"  id="" placeholder="Enter Chef Email">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Origin/Address <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control"  id="" placeholder="Enter Chef Origin">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Cooking Exp <span class="text-danger">*</span></label>
                                        <input type="number" name="experience" class="form-control"  id="" placeholder="Enter Cooking Experence ">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" class="form-control"  id="" placeholder="Enter Pincode">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control"  id="" placeholder="Enter Mobile Number">
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="exampleInputEmail1">Deal With Categories <span class="text-danger">*</span></label>
                                          <select name="deal_categories[]" class="select2" multiple="multiple" data-placeholder="Select Deal Categories" style="width: 100%;">
                                              @foreach($categories as $k =>$v)
                                              <option value="{{$v->id}}">{{$v->name}}</option>
                                              @endforeach
                                            </select>
                                      </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Deal With Cuisines <span class="text-danger">*</span></label>
                                        <select name="deal_cuisines[]" class="select2" multiple="multiple" data-placeholder="Select Deal Cuisines" style="width: 100%;">
                                            @foreach($cuisines as $k =>$v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                          </select>
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="exampleInputEmail1">Speciality <span class="text-danger">*</span></label>
                                          <select name="speciality[]" class="select2" multiple="multiple" data-placeholder="Select Deal Categories" style="width: 100%;">
                                              @foreach($cuisines as $k =>$v)
                                              <option value="{{$v->id}}">{{$v->name}}</option>
                                              @endforeach
                                            </select>
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group">

                                          <label for="exampleInputEmail1"> Food Type</label><br>

                                          <div class="form-group clearfix">
                                            <div class="icheck-success d-inline">
                                              <input type="radio" id="veg" name="type" value="1" checked>
                                              <label for="veg">Veg</label>
                                            </div>
                                            <div class="icheck-danger d-inline">
                                              <input type="radio" id="non_veg" name="type" value="3">
                                              <label for="non_veg">Veg + Non Veg</label>
                                            </div>


                                          </div>
                                      </div>
                                    </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control"  id="" placeholder="Enter Chef Address">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">FSSAI Lic. No. <span class="text-danger">*</span></label>
                                        <input type="text" name="fssai_lic_no" class="form-control"  id="" placeholder="Enter FSSAI licence Number">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control"  id="" placeholder="Enter Password">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="confirm_password" class="form-control"  id="" placeholder="Enter Confirm Password">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vendor Commission Persentage <span class="text-danger">*</span></label>
                                        <input type="text" name="vendor_commission" class="form-control"  id="" placeholder="Enter Commission">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tax<span class="text-danger">*</span></label>
                                        <input type="text" name="tax" class="form-control"  id="" placeholder="Tax">
                                    </div>
                                  </div>

                                </div>

                              </div>

                          </div>
                          <!-- basic information end -->
                          <hr>
                          <!-- schedule information start -->
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Identity  Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-3">
                                        <div>
                                          <label for="">Chef logo</label>
                                        </div>
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <div class="upload-icon">
                                                    <img class="icon" src="{{asset('add-image.png')}}">
                                                </div>
                                            </label>
                                            <input id="file-input" type="file" name="image">
                                        </div>
                                  </div>
                                  <div class="col-sm-3">
                                        <div>
                                          <label for="">Chef Profile Images</label>
                                        </div>
                                        <div class="image-upload">
                                            <label for="file-input4">
                                                <div class="upload-icon4">
                                                    <img class="icon4" src="{{asset('add-image.png')}}">
                                                </div>
                                            </label>
                                            <input id="file-input4" type="file" name="profile_image">
                                        </div>
                                  </div>
                                  <div class="col-sm-3">
                                        <div>
                                          <label for="">FSSAI Registration </label>
                                        </div>
                                        <div class="image-upload">
                                            <label for="file-input2">
                                                <div class="upload-icon2">
                                                    <img class="icon2" src="{{asset('add-image.png')}}">
                                                </div>
                                            </label>
                                            <input id="file-input2" type="file" name="fassai_image"/>

                                        </div>
                                  </div>
                                  <div class="col-sm-3">
                                        <div>
                                          <label for="">Other Document </label>

                                        </div>
                                        <div class="image-upload">

                                            <label for="file-input3">
                                                <div class="upload-icon3">
                                                    <img class="icon3" src="{{asset('add-image.png')}}">
                                                </div>
                                            </label>
                                            <input id="file-input3" type="file" name="other_document"/>

                                        </div>
                                        <input type="text" name="other_document_name" class="form-control" placeholder="Document Name">
                                  </div>

                                </div>
                                <!-- div row -->
                            </div>


                          </div>
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">About  Information</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="form-group">
                                          <label for="exampleInputEmail1">Bio</label>
                                          <textarea name="bio" rows="10" col="10" class="form-control" ></textarea>
                                      </div>
                                  </div>



                                </div>
                                <!-- div row -->
                              </div>


                          </div>
                          <!-- time setup -->
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Order Accept Time Schedule Setup</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-12">

                                    <div class="form-row">
                                      <div class="col-md-3 mb-4">
                                          <h6>Day</h6>
                                          <div class="input-group">
                                              <span> Sun </span>
                                          </div>
                                      </div>

                                      <div class="col-md-3 mb-4">
                                          <h6>Opening times</h6>
                                          <div class="input-group">
                                              <input type="time" class=" start_time form-control" name="start_time[0]" id='start_time_0' data-item-id="0"
                                                  <?= isset($VendorOrderTime[0]['start_time']) ? 'value="' . $VendorOrderTime[0]['start_time'] . '"' : '' ?> required>
                                              <span class="start_time_0_error text-danger"></span>
                                          </div>
                                      </div>
                                      <div class="col-md-3 mb-4">
                                          <h6>Closing times</h6>
                                          <div class="input-group">
                                              <input type="time" class="end_time form-control" name="end_time[0]" id="end_time_0" data-item-id="0"
                                                  <?= isset($VendorOrderTime[0]['end_time']) ? 'value="' . $VendorOrderTime[0]['end_time'] . '"' : '' ?> required>
                                          </div>
                                      </div>

                                      <div class="col-md-3 mb-4">
                                          <h6>available</h6>
                                          <div class="input-group">
                                              <select class="form-control select-av" id="available_0" name="available[0]" data-item-id="0">
                                                  <option value="1" @if (@$VendorOrderTime[0]['available'] == '1') {{ 'selected' }} @endif>
                                                      Available
                                                  </option>
                                                  <option value="0" @if (@$VendorOrderTime[0]['available'] == '0') {{ 'selected' }} @endif>Not
                                                      available</option>
                                              </select>
                                              @if ($errors->has('available.0'))
                                                  <span class="ms-text-danger">
                                                      <strong>{{ $errors->first('available.0') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                      </div>
                                    </div>
                                      <!--  -->
                                      <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <span> Mon </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="start_time form-control" name="start_time[1]" data-item-id='1'
                                                    id="start_time_1"
                                                    <?= isset($VendorOrderTime[1]['start_time']) ? 'value="' . $VendorOrderTime[1]['start_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="end_time form-control" name="end_time[1]" data-item-id='1' id="end_time_1"
                                                    <?= isset($VendorOrderTime[1]['end_time']) ? 'value="' . $VendorOrderTime[1]['end_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <select class="form-control select-av" id="available_1" name="available[1]" data-item-id="1">
                                                    <option value="1" @if (@$VendorOrderTime[1]['available'] == '1') {{ 'selected' }} @endif>
                                                        Available
                                                    </option>
                                                    <option value="0" @if (@$VendorOrderTime[1]['available'] == '0') {{ 'selected' }} @endif>Not
                                                        available</option>
                                                </select>

                                                @if ($errors->has('available.1'))
                                                    <span class="ms-text-danger">
                                                        <strong>{{ $errors->first('available.1') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                      <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <span> Tus </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="start_time form-control" name="start_time[2]" data-item-id='2'
                                                    id="start_time_2"
                                                    <?= isset($VendorOrderTime[2]['start_time']) ? 'value="' . $VendorOrderTime[2]['start_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="end_time form-control" name="end_time[2]" data-item-id='2' id="end_time_2"
                                                    <?= isset($VendorOrderTime[2]['end_time']) ? 'value="' . $VendorOrderTime[2]['end_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <select class="form-control select-av" id="available_2" name="available[2]" data-item-id="2">
                                                    <option value="1" @if (@$VendorOrderTime[2]['available'] == '1') {{ 'selected' }} @endif>
                                                        Available
                                                    </option>
                                                    <option value="0" @if (@$VendorOrderTime[2]['available'] == '0') {{ 'selected' }} @endif>Not
                                                        available</option>
                                                </select>

                                                @if ($errors->has('available.2'))
                                                    <span class="ms-text-danger">
                                                        <strong>{{ $errors->first('available.2') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <span> Wed </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="start_time form-control" name="start_time[3]" data-item-id='3'
                                                    id="start_time_3"
                                                    <?= isset($VendorOrderTime[3]['start_time']) ? 'value="' . $VendorOrderTime[3]['start_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="end_time form-control" name="end_time[3]" data-item-id='3' id="end_time_3"
                                                    <?= isset($VendorOrderTime[3]['end_time']) ? 'value="' . $VendorOrderTime[3]['end_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <select class="form-control select-av" id="available_3" name="available[3]" data-item-id="3">
                                                    <option value="1" @if (@$VendorOrderTime[3]['available'] == '1') {{ 'selected' }} @endif>
                                                        Available
                                                    </option>
                                                    <option value="0" @if (@$VendorOrderTime[3]['available'] == '0') {{ 'selected' }} @endif>Not
                                                        available</option>
                                                </select>

                                                @if ($errors->has('available.3'))
                                                    <span class="ms-text-danger">
                                                        <strong>{{ $errors->first('available.3') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <span> Thus </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="start_time form-control" name="start_time[4]" data-item-id='4'
                                                    id="start_time_4"
                                                    <?= isset($VendorOrderTime[4]['start_time']) ? 'value="' . $VendorOrderTime[4]['start_time'] . '"' : '' ?> required><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-4">

                                            <div class="input-group">
                                                <input type="time" class="end_time form-control" name="end_time[4]" data-item-id='4' id="end_time_4"
                                                    <?= isset($VendorOrderTime[4]['end_time']) ? 'value="' . $VendorOrderTime[4]['end_time'] . '"' : '' ?> required>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-4">
                                            <div class="input-group">
                                                <select class="form-control select-av" id="available_4" name="available[4]" data-item-id="4">
                                                    <option value="1" @if (@$VendorOrderTime[4]['available'] == '1') {{ 'selected' }} @endif>
                                                        Available
                                                    </option>
                                                    <option value="0" @if (@$VendorOrderTime[4]['available'] == '0') {{ 'selected' }} @endif>Not
                                                        available</option>
                                                </select>

                                                @if ($errors->has('available.4'))
                                                    <span class="ms-text-danger">
                                                        <strong>{{ $errors->first('available.4') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                      <div class="col-md-3 mb-4">
                                          <div class="input-group">
                                              <span> Fri </span>
                                          </div>
                                      </div>

                                      <div class="col-md-3 mb-4">

                                          <div class="input-group">
                                              <input type="time" class="start_time form-control" name="start_time[5]" data-item-id='5'
                                                  id="start_time_5"
                                                  <?= isset($VendorOrderTime[5]['start_time']) ? 'value="' . $VendorOrderTime[5]['start_time'] . '"' : '' ?> required>
                                          </div>
                                      </div>
                                      <div class="col-md-3 mb-4">

                                          <div class="input-group">
                                              <input type="time" class="end_time form-control" name="end_time[5]" data-item-id='5' id="end_time_5"
                                                  <?= isset($VendorOrderTime[5]['end_time']) ? 'value="' . $VendorOrderTime[5]['end_time'] . '"' : '' ?> required>
                                          </div>
                                      </div>

                                      <div class="col-md-3 mb-4">
                                          <div class="input-group select-av">
                                              <select class="form-control" id="available_5" name="available[5]" data-item-id="5">
                                                  <option value="1" @if (@$VendorOrderTime[5]['available'] == '1') {{ 'selected' }} @endif>
                                                      Available</option>
                                                  <option value="0" @if (@$VendorOrderTime[5]['available'] == '0') {{ 'selected' }} @endif>Not
                                                      available</option>
                                              </select>

                                              @if ($errors->has('available.5'))
                                                  <span class="ms-text-danger">
                                                      <strong>{{ $errors->first('available.5') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="col-md-3 mb-4">
                                          <div class="input-group">
                                              <span> Sat </span>
                                          </div>
                                      </div>

                                      <div class="col-md-3 mb-4">

                                          <div class="input-group">
                                              <input type="time" class="start_time form-control" name="start_time[6]" data-item-id='6'
                                                  id="start_time_6"
                                                  <?= isset($VendorOrderTime[6]['start_time']) ? 'value="' . $VendorOrderTime[6]['start_time'] . '"' : '' ?> required>
                                          </div>
                                      </div>
                                      <div class="col-md-3 mb-4">

                                          <div class="input-group">
                                              <input type="time" class="end_time form-control" name="end_time[6]" data-item-id='6' id="end_time_6"
                                                  <?= isset($VendorOrderTime[6]['end_time']) ? 'value="' . $VendorOrderTime[6]['end_time'] . '"' : '' ?> required>
                                          </div>
                                      </div>

                                      <div class="col-md-3 mb-4">
                                          <div class="input-group">
                                              <select class="form-control select-av" id="available_6" name="available[6]" data-item-id="6">
                                                  <option value="1" @if (@$VendorOrderTime[6]['available'] == '1') {{ 'selected' }} @endif>
                                                      Available</option>
                                                  <option value="0" @if (@$VendorOrderTime[6]['available'] == '0') {{ 'selected' }} @endif>Not
                                                      available</option>
                                              </select>

                                              @if ($errors->has('available.6'))
                                                  <span class="ms-text-danger">
                                                      <strong>{{ $errors->first('available.6') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                      </div>
                                  </div>

                                  </div>
                                  <!--  -->




                                </div>
                                <!-- div row -->
                              </div>


                          </div>
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title text-bold">Location for Order Pickup</h3>
                              </div>
                              <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                          <label>Location</label>
                                          <div class="input-group">
                                              <input type="text" id="address-input" name="location" class="form-control map-input" value="" placeholder="Enter Location">
                                          </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="address-map-container" style="width:100%;height:400px; ">
                                            <div style="width: 100%; height: 100%" id="address-map"></div>
                                            <input type="hidden" name="address_latitude" id="" value="{{ old('address_latitude') ?? '0' }}" />
                                            <input type="hidden" name="address_longitude" id="" value="{{ old('address_longitude') ?? '0' }}" />
                                            <input id="address-latitude" type="hidden" class="form-control" placeholder="Latitude" step="" name="lat" value="" readonly required>
                                            <input id="address-longitude" type="hidden" class="form-control" placeholder="Latitude" step="" name="long" value="" readonly required>
                                        </div>
                                    </div>



                                </div>
                                <!-- div row -->
                              </div>


                          </div>
                          <div class="card-footer">
                            <button class="btn btn-success" ><i class="fa fa-save"></i>Register Chef </button>
                          </div>
                      </form>

                    </div>

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
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>







<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();

      $("#restaurant-form").validate({
          rules: {
              restourant_name: {
                  required: true,
                  maxlength: 40,
              },
              dob: {
                  required: true,
              },
              experience: {
                  required: true,
              },
              deal_categories: {
                  required: true,
              },
              deal_cuisines: {
                  required: true,
              },
              email: {
                  required: true,
                  maxlength: 30,
                  email: true,
                  remote: '{{route("admin.vendor.emailcheck")}}',
              },
              address: {
                  required: true,
                  minlength: 5,
                  maxlength: 60
              },
              phone: {
                  required: true,
                  minlength: 10,
                  maxlength: 10,
                  number: true,
                  remote: '{{route("admin.vendor.mobilecheck")}}',
              },
              pincode: {
                  required: true,
                  minlength: 6,
                  maxlength: 6,
                  number: true
              },
              fassai_lic_no: {
                required: true,
              },
              password:{
                required: true,
                maxlength: 20,
                minlength: 5,

              },
              confirm_password:{
                 required: true,
                 equalTo : '[name="password"]'
              },
              vendor_commission:{
                required:true,
                number: true
              },'deal_categories[]':{
                required:true,
              },
              'deal_cuisines[]':{
                required:true,
              },
              'speciality[]':{
                required:true,
              },
              location: {
                //checkLocation: true
                checkLocation:true
              },


          },
          messages: {
              restourant_name: {
                  required: "Name is required",
                  maxlength: "First name cannot be more than 40 characters"
              },
              email: {
                  required: "Please Enter Email",
                  maxlength: "Email cannot be more than 30 characters",
                  email: "Email must be a valid email address",
                  remote:"This Email is Already has been Taken"
              },
              address: {
                  required: "Address is required",
                  maxlength: "Address cannot be more than 60 characters",
                  minlength: "Address cannot be Less than 5 characters"
              },
              pincode: {
                  required: "pincode is required",
                  maxlength: "pincode cannot be more than 6 characters",
                  minlength: "pincode cannot be Less than 6 characters",
                  number: "Pincode must be an number"
              },
              confirm_password:{
                equalTo:"Field Not Match with Passowrd Field"
              },
              phone:{
                remote:"Mobile Number Already use in Onther Account"
              },
              'deal_categories[]':{
                required:"Select Deals categories"
              },
              'deal_cuisines[]':{
                required:"Select Deals cuisines"
              },
              'speciality[]':{
                required:"Select Your speciality of chef"
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
      $('#file-input3').change( function(event) {
          $("img.icon3").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon3").parents('.upload-icon3').addClass('has-img3');
      });
      $('#file-input4').change( function(event) {
          $("img.icon4").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon4").parents('.upload-icon4').addClass('has-img4');
      });
  });

  $.validator.addMethod('checkLocation',function (value, element) {

            var check = true;
            if($('#address-latitude').val() == ''){
                check =  false;
            }
            else if($('#address-longitude').val() == ''){
                check =  false
            }
            if(check){
                return true;
            }else{
                Swal.fire({icon: 'error',title: 'Oops...',text: "Please Select Location Properly", footer: ''});
            }




    },'Please Select Location Properly ');
    function initialize() {

$('form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});
const locationInputs = document.getElementsByClassName("map-input");

const autocompletes = [];
const geocoder = new google.maps.Geocoder;
for (let i = 0; i < locationInputs.length; i++) {

    const input = locationInputs[i];
    const fieldKey = input.id.replace("-input", "");
    const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

    const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 51.5073509;
    const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || -0.12775829999998223;

    const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
        center: {
            lat: latitude,
            lng: longitude
        },
        zoom: 13
    });
    const marker = new google.maps.Marker({
        map: map,
        position: {
            lat: latitude,
            lng: longitude
        },
    });

    marker.setVisible(isEdit);

    const autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.key = fieldKey;
    autocompletes.push({
        input: input,
        map: map,
        marker: marker,
        autocomplete: autocomplete
    });
}

for (let i = 0; i < autocompletes.length; i++) {
    const input = autocompletes[i].input;
    const autocomplete = autocompletes[i].autocomplete;
    const map = autocompletes[i].map;
    const marker = autocompletes[i].marker;

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        marker.setVisible(false);
        const place = autocomplete.getPlace();

        geocoder.geocode({
            'placeId': place.place_id
        }, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                const lat = results[0].geometry.location.lat();
                const lng = results[0].geometry.location.lng();
                setLocationCoordinates(autocomplete.key, lat, lng);
            }
        });

        if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            input.value = "";
            return;
        }

        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

    });
}
}
function setLocationCoordinates(key, lat, lng) {
const latitudeField = document.getElementById(key + "-" + "latitude");
const longitudeField = document.getElementById(key + "-" + "longitude");
latitudeField.value = lat;
longitudeField.value = lng;
}
 </script>
 <script>
        (function($) {
            $(".select-av").change(function() {

                if ($(this).val() == 0) {

                    $("#start_time_" + $(this).attr('data-item-id')).val(null);
                    $("#end_time_" + $(this).attr('data-item-id')).val(null);
                    $('#start_time_'+ $(this).attr('data-item-id')).prop('required', false);
                    $('#end_time_'+ $(this).attr('data-item-id')).prop('required', false);
                }else
                {
                    $('#start_time_'+ $(this).attr('data-item-id')).prop('required', true);
                    $('#end_time_'+ $(this).attr('data-item-id')).prop('required', true);
                }
            });

            $(".start_time").focusout(function() {
                var v = $(this).val();

                $(".start_time").each(function() {
                    if ($(this).val() == '' && $("#available_" + $(this).attr('data-item-id')).val() ==
                        1) {
                        $(this).val(v);
                    }

                });
            });
            $(".end_time").focusout(function() {
                var v = $(this).val();
                $(".end_time").each(function() {
                    if ($(this).val() == '' && $("#available_" + $(this).attr('data-item-id')).val() ==
                        1) {
                        $(this).val(v);
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
