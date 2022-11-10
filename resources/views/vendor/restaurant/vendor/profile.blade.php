<?php
$vendor_food_type = config('custom_app_setting.vendor_food_type');
//echo $resturant->vendor_type;
//dd($vendor_type);
$banners = json_decode(\Auth::guard('vendor')->user()->banner_image);
if (is_array($banners))
    $urlbanners = URL::to('vendor-banner/') . '/' . $banners[0];
?>
<?php $vendor = $resturant;
//dd($vendor->image);
?>
@extends('vendor.restaurants-layout')
@section('main-content')
    <?php $vendor_type = config('custom_app_setting.vendor_type')?>
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">

        <div class="ms-profile-overview">
            <div class="ms-profile-cover" style="@if($urlbanners!='') background-image: url({{$urlbanners}}); @endif">

                <img class="ms-profile-img" src="{{($resturant->image!='') ? URL::to('vendors/') . '/' .$resturant->image : '../../assets/img/costic/customer-5.jpg'}}" alt="people">
                <div class="ms-profile-user-info">
                    <h4 class="ms-profile-username text-white">{{\Auth::guard('vendor')->user()->name}}</h4>
                    <h2 class="ms-profile-role">{{$vendor_type[\Auth::guard('vendor')->user()->vendor_type]}}</h2>
                </div>
                <div class="ms-profile-user-buttons">
                    {{--                <a href="#" class="btn btn-primary"> <i class="material-icons">person_add</i> Follow</a>--}}
                    {{--                <a href="#" class="btn btn-light"> <i class="material-icons">file_download</i> Download Resume</a>--}}
                </div>
            </div>
            <ul class="ms-profile-navigation nav nav-tabs tabs-bordered" role="tablist">
                <li role="presentation">
                    <a href="#tab1" aria-controls="tab1" class="active show" role="tab" data-toggle="tab"> Overview </a>
                </li>
                <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"> Professional
                        Skills </a></li>
                <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">
                        Portfolio </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="tab1">

                </div>
                <div class="tab-pane" id="tab2">

                </div>
                <div class="tab-pane" id="tab3">

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-7 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                        <h2 class="section-title">Description</h2>
                        <p>{{$resturant->bio}} </p>

                        <div class="ms-profile-skills">
                            <h2 class="section-title">Deals with categories</h2>
                            <ul class="ms-skill-list">
                                <?php
                                $categories_id = explode(',', $resturant->deal_categories);

                                $deals = \App\Models\Catogory_master::whereIn('id', $categories_id)->get();

                                ?>
                                @foreach($deals as $k=>$category)
                                    <li class="ms-skill">{{$category->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="ms-profile-skills">
                            <h2 class="section-title">Deals with Cuisines</h2>
                            <ul class="ms-skill-list">
                                <?php
                                $cusines_id = explode(',', $resturant->deal_cuisines);

                                $deals = \App\Models\Cuisines::whereIn('id', $cusines_id)->where('is_active', '1')->orderBy('position', 'asc')->get();

                                ?>
                                @foreach($deals as $k=>$cusine)
                                    <li class="ms-skill">{{$cusine->name}}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-5 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                        <ul class="ms-profile-stats">
                            <li>
                                <h3 class="ms-count">{{$product_count}}</h3>
                                <span>Total Products</span>
                            </li>
                            <li>
                                <h3 class="ms-count">{{$like_user_count}}</h3>
                                <span>No of users like</span>
                            </li>
                            <li>
                                <h3 class="ms-count"><?php echo front_end_currency($resturant->wallet)?></h3>
                                <span>Wallet</span>
                            </li>

                            <li>
                                <h3 class="ms-count"><?php echo ($resturant->review_count != 0) ? ($resturant->vendor_ratings / $resturant->review_count) : '0';?></h3>
                                <span>Rating</span>
                            </li>
                        </ul>
                        <h2 class="section-title">Basic Information</h2>
                        <table class="table ms-profile-information">
                            <tbody>
                            <tr>
                                <th scope="row">Full Name</th>
                                <td>{{$resturant->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Birthday</th>
                                <td>{{front_end_date($resturant->dob)}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{$resturant->email}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Experience</th>
                                <td>{{$resturant->experience}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Mobile</th>
                                <td>{{$resturant->mobile}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Pincode</th>
                                <td>{{$resturant->pincode}}</td>
                            </tr>

                            <tr>
                                <th scope="row">address</th>
                                <td>{{$resturant->address}}</td>
                            </tr>

                            <tr>
                                <th scope="row">fssai licence no</th>
                                <td>{{$resturant->fssai_lic_no}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Commission</th>
                                <td>{{$resturant->commission}} %</td>
                            </tr>


                            <tr>
                                <th scope="row">Food Type</th>
                                <td>{{$vendor_food_type[$resturant->vendor_food_type]}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Table Service</th>
                                <td><?php echo ($resturant->table_service) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-dark">Not Active</span>'; ?></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <form id="restaurant-form" action="{{route('restaurant.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-xl-12 col-md-12">
                    <div class="ms-panel ms-panel-fh">
                        <div class="ms-panel-header">
                            <h6>Edit Profile</h6>
                        </div>
                        <div class="ms-panel-body">
                            <div class="error">
                                @if($errors->any())
                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                                @endif
                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Restaurant
                                            <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$vendor->name}}" name="restaurant_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Chef Name">
                                        <input type="hidden" value="{{$vendor->id}}" name="id" class="form-control" id="exampleInputEmail1" placeholder="Enter Chef Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                        <input type="email" readonly="true" name="email" value="{{$vendor->email}}" class="form-control" id="" placeholder="Enter Restaurant Email">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pincode
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" value="{{$vendor->pincode}}" class="form-control" id="" placeholder="Enter Pincode">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{$vendor->mobile}}" class="form-control" id="" placeholder="Enter Mobile Number">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Deal With Categories
                                            <span class="text-danger">*</span></label>
                                        {{ Form::select('categories[]',$categories,@explode(',',$vendor->deal_categories),['class' => 'select2','multiple'=>"multiple", 'data-placeholder'=>"Select Deal Categories",'style'=>"width: 100%;"]) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Deal With Cuisines
                                            <span class="text-danger">*</span></label>
                                        {{ Form::select('deal_cuisines[]',$cuisines,@explode(',',$vendor->deal_cuisines),['class' => 'select2','multiple'=>"multiple", 'data-placeholder'=>"Select Deal Cuisines" ,'style'=>"width: 100%;"]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="address" value="{{$vendor->address}}" class="form-control" id="" placeholder="Enter Restaurant Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="exampleInputEmail1">Vendor Food Type</label><br>

                                        <div class="form-group clearfix">
                                            <div class="icheck-success d-inline">

                                                <input type="radio" id="veg" name="type" value="1" {{($vendor->vendor_food_type==1) ? 'checked' : ''}}>
                                                <label for="veg">Veg</label>
                                            </div>

                                            <div class="icheck-danger d-inline">
                                                <input type="radio" id="non_veg" name="type" value="3" {{($vendor->vendor_food_type==3) ? 'checked' : ''}}>
                                                <label for="non_veg">Veg + Non Veg</label>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">FSSAI Lic. No.
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="fssai_lic_no" value="{{$vendor->fssai_lic_no}}" class="form-control" id="" placeholder="Enter FSSAI licence Number">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vendor Commission
                                            Persentage<span class="text-danger">*</span></label>
                                        <input type="text" value="{{$vendor->commission}}" name="vendor_commission" class="form-control" id="" placeholder="Enter Commission">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tax<span class="text-danger">*</span></label>
                                        <input type="text" name="tax" value="{{$vendor->tax}}" class="form-control" id="" placeholder="Tax">
                                    </div>
                                </div>
{{--                                <div class="col-md-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="exampleInputEmail1">GST Available<span class="text-danger">*</span></label>--}}
{{--                                        <select class="form-control gstavailable" name="gst_available">--}}
{{--                                            @if($vendor->gst_available == '0')--}}
{{--                                                <option value="0">Not Available</option>--}}
{{--                                            @else--}}
{{--                                                <option value="1">Available</option>--}}
{{--                                            @endif--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                @if($vendor->gst_available == '1')
{{--                                    <div class="col-md-6 custmization-block">--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="exampleInputEmail1">GST--}}
{{--                                                No<span class="text-danger">*</span></label>--}}
{{--                                            <input type="password" name="gst_no" class="form-control" id="" placeholder="Enter Confirm Password">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                @endif
                            </div>
                            <div class="card card-default">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div>
                                                <label for="">Restaurant Images</label>
                                            </div>
                                            <div class="image-upload">
                                                <label for="file-input">
                                                    <div class="upload-icon">
                                                        @if($vendor->image == null)
                                                            <?php $is_require=true;?>
                                                            <img class="icon" src="{{asset('add-image.png')}}">
                                                        @else
                                                            <?php $is_require=false;?>
                                                            <img class="icon" src="{{ asset('vendors'.'/'.$vendor->image ) }}">
                                                        @endif
                                                    </div>
                                                </label>
                                                <input id="file-input" type="file" name="image" {{($is_require) ? 'required' : ''}}/>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div>
                                                <label for="">FSSAI Registration </label>
                                            </div>
                                            <div class="image-upload">
                                                <label for="file-input2">
                                                    <div class="upload-icon2">
                                                        @if($vendor->licence_image == null)
                                                            <?php $is_require=true;?>
                                                            <img class="icon2" src="{{asset('add-image.png')}}">
                                                        @else
                                                            <?php $is_require=false;?>
                                                            <img class="icon2" src="{{ asset('vendor-documents'.'/'.$vendor->licence_image ) }}">
                                                        @endif
                                                    </div>
                                                </label>
                                                <input id="file-input2" type="file" name="fassai_image" {{($is_require) ? 'required' : ''}}/>

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div>
                                                <label for="">Other Document </label>

                                            </div>
                                            <div class="image-upload">

                                                <label for="file-input3">
                                                    <div class="upload-icon3">
                                                        @if($vendor->other_document_image == null)
                                                            <?php $is_require=true;?>
                                                            <img class="icon3" src="{{asset('add-image.png')}}">
                                                        @else
                                                            <?php $is_require=false;?>
                                                            <img class="icon3" src="{{ asset('vendor-documents'.'/'.$vendor->other_document_image ) }}">
                                                        @endif
                                                    </div>
                                                </label>
                                                <input id="file-input3" type="file" name="other_document" {{($is_require) ? 'required' : ''}} />

                                            </div>
                                            <input type="text" name="other_document_name" value="{{$vendor->other_document_name}}" class="form-control" placeholder="Document Name">
                                        </div>
                                        <div class="col-sm-3">
                                            <div>
                                                <label for="">Banner Image </label>

                                            </div>
                                            <div class="image-upload">

                                                <label for="file-input4">
                                                    <div class="upload-icon4">
                                                        @if($vendor->banner_image == null)
                                                            <img class="icon4" src="{{asset('add-image.png')}}">
                                                        @else
                                                            <img class="icon4" src="{{ asset('vendor-banner'.'/'.$vendor->banner_image ) }}">
                                                        @endif
                                                    </div>
                                                </label>
                                                <input id="file-input4" type="file" name="banner_image" />

                                            </div>

                                        </div>
                                    </div>
                                    <!-- div row -->
                                </div>


                            </div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>

                </div>
            </form>


        </div>


    </div>
@endsection

@push('scripts')
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

    <script type="text/javascript">
        $(".s_meun").removeClass("active");
        $(".city_cityadmin").addClass("active");
        $(".city_menu").addClass("active");
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();

            $("#restaurant-form").validate({
                rules: {
                    restaurant_name: {
                        required: true,
                        maxlength: 80,
                    },
                    email: {
                        required: true,
                        maxlength: 60,
                        email: true
                    },
                    address: {
                        required: true,
                        minlength: 5,
                        maxlength: 120
                    },
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
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
                    vendor_commission: {
                        required: true,
                        number: true
                    },
                    tax: {
                        required: true,
                    }
                },
                messages: {
                    restourant_name: {
                        required: "Name is required",
                        maxlength: "First name cannot be more than 20 characters"
                    },
                    email: {
                        required: "Please Enter Email",
                        maxlength: "Email cannot be more than 30 characters",
                        email: "Email must be a valid email address",
                        remote: "This Email is Already has been Taken"
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
                    phone: {
                        remote: "Mobile Number Already use in Onther Account"
                    },
                    tax: {
                        remote: "Tax is required"
                    }
                }
            });

            $('#file-input').change(function (event) {
                $("img.icon").attr('src', URL.createObjectURL(event.target.files[0]));
                $("img.icon").parents('.upload-icon').addClass('has-img');
            });
            $('#file-input2').change(function (event) {
                $("img.icon2").attr('src', URL.createObjectURL(event.target.files[0]));
                $("img.icon2").parents('.upload-icon2').addClass('has-img2');
            });
            $('#file-input3').change(function (event) {
                $("img.icon3").attr('src', URL.createObjectURL(event.target.files[0]));
                $("img.icon3").parents('.upload-icon3').addClass('has-img3');
            });
            $('#file-input4').change(function (event) {
                $("img.icon4").attr('src', URL.createObjectURL(event.target.files[0]));
                $("img.icon4").parents('.upload-icon4').addClass('has-img4');
            });
        });
    </script>
@endpush
