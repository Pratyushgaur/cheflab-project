<?php
$urlbanners = '';
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
@section('page-css')
    <style>
        .imagePreview {
            width: 100%;
            min-height: 180px;
            background-position: center center;

            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);

        }

        .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
        }

        .imgUp {
            margin-bottom: 15px;
        }

        .del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        .imgAdd {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #4bd7ef;
            color: #fff;
            box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.2);
            text-align: center;
            line-height: 30px;
            margin-top: 0px;
            cursor: pointer;
            font-size: 15px;
        }
    </style>
@endsection

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
            {{--            <ul class="ms-profile-navigation nav nav-tabs tabs-bordered" role="tablist">--}}
            {{--                <li role="presentation">--}}
            {{--                    <a href="#tab1" aria-controls="tab1" class="active show" role="tab" data-toggle="tab"> Overview </a>--}}
            {{--                </li>--}}
            {{--                <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"> Professional--}}
            {{--                        Skills </a></li>--}}
            {{--                <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">--}}
            {{--                        Portfolio </a></li>--}}
            {{--            </ul>--}}
            {{--            <div class="tab-content">--}}
            {{--                <div class="tab-pane" id="tab1">--}}

            {{--                </div>--}}
            {{--                <div class="tab-pane" id="tab2">--}}

            {{--                </div>--}}
            {{--                <div class="tab-pane" id="tab3">--}}

            {{--                </div>--}}
            {{--            </div>--}}
        </div>

        <div class="row">

            <div class="col-xl-7 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-body">
                        <h2 class="section-title">Description</h2>
                        <p>{{$resturant->bio}} </p>

                        <div class="ms-profile-skills">
                            <h2 class="section-title">Deals with categories
                                &nbsp;<a href="javascript:void(0)" data-toggle="modal" data-target="#edit-category-model" data-title="Edit"><i class="fa fa-edit"></i></a>
                            </h2>
                            <ul class="ms-skill-list">
                                <?php
                                $categories_id = explode(',', $resturant->deal_categories);

                                $deals = \App\Models\Catogory_master::whereIn('id', $categories_id)->get();
                                $dealsIds = [];
                                ?>
                                @foreach($deals as $k=>$category)
                                    <?php $dealsIds[] = $category->id; ?>
                                    <li class="ms-skill">{{$category->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="ms-profile-skills">
                            <h2 class="section-title">Deals with Cuisines
                                &nbsp;<a href="javascript:void(0)" data-toggle="modal" data-target="#edit-cuisines-model" data-title="Edit"><i class="fa fa-edit"></i></a>
                            </h2>
                            <ul class="ms-skill-list">
                                <?php
                                $cusines_id = explode(',', $resturant->deal_cuisines);

                                $deals = \App\Models\Cuisines::whereIn('id', $cusines_id)->where('is_active', '1')->orderBy('position', 'asc')->get();
                                $cuisIds = [];
                                ?>
                                @foreach($deals as $k=>$cusine)
                                    <?php $cuisIds[] = $cusine->id; ?>
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
                                <span>Favorite </span>
                            </li>
                            <!-- <li>
                                <h3 class="ms-count"><?php //echo front_end_currency($resturant->wallet)?></h3>
                                <span>Wallet</span>
                            </li> -->

                            <li>
                                <h3 class="ms-count"><?php echo $resturant->vendor_ratings;?></h3>
                                <span>Ratings</span>
                            </li>
                        </ul>
                        <h2 class="section-title">Basic Information</h2>
                        <table class="table ms-profile-information">
                            <tbody>
                            <tr>
                                <th scope="row">Full Name</th>
                                <td>{{$resturant->name}}</td>
                            </tr>
                            @if($resturant->vendor_type == 'chef')
                            
                            <tr>
                                <th scope="row">Birthday</th>
                                <td>{{front_end_date($resturant->dob)}}</td>
                            </tr>
                            @endif
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{$resturant->email}}</td>
                            </tr>
                            @if($resturant->experience!='')
                                <tr>
                                    <th scope="row">Experience</th>
                                    <td>{{$resturant->experience}}</td>
                                </tr>
                            @endif
                            <tr>
                                <th scope="row">Mobile</th>
                                <td>{{$resturant->mobile}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Pincode</th>
                                <td>{{$resturant->pincode}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Address</th>
                                <td>{{$resturant->address}}</td>
                            </tr>

                            <tr>
                                <th scope="row">FSSAI Licence No.</th>
                                <td>{{$resturant->fssai_lic_no}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Commission</th>
                                <td>{{$resturant->commission}} %</td>
                            </tr>


                            <tr>
                                <th scope="row">Food Type</th>
                                <td>{{isset($vendor_food_type[$resturant->vendor_food_type]) ? $vendor_food_type[$resturant->vendor_food_type] : ''}}</td>
                            </tr>

                            <tr>
                                <th scope="row">Table Service</th>
                                <td><?php echo ($resturant->table_service) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-dark">Not Active</span>'; ?></td>
                            </tr>

                            <tr>
                                <th scope="row">GST NO.</th>
                                <td><?php echo ($resturant->gst_no != '') ? $resturant->gst_no : ''; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Tax</th>
                                <td><?php echo $resturant->tax; ?></td>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email <span class="text-danger">*</span></label>
                                        <input type="email" readonly="true" name="email" value="{{$vendor->email}}" class="form-control" id="" placeholder="Enter Restaurant Email">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pincode
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="pincode" value="{{$vendor->pincode}}" class="form-control" id="" placeholder="Enter Pincode">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Manage Name </label>
                                        <input type="text" name="manager_name" value="{{$resturant->manager_name}}" class="form-control" id="" placeholder="Enter Manager Name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{$vendor->mobile}}" class="form-control" id="" placeholder="Enter Mobile Number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Alternate Mobile
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="alt_mobile" value="{{$resturant->alt_mobile}}" class="form-control" id="" placeholder="Enter alternate mobile Number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">FSSAI Lic. No.
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="fssai_lic_no" value="{{$vendor->fssai_lic_no}}" class="form-control" id="" placeholder="Enter FSSAI licence Number" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="address" value="{{$vendor->address}}" class="form-control" id="" placeholder="Enter Restaurant Address">
                                    </div>
                                </div>
                                
                                

                            
                                
                            </div>
                           


                            {{-- Location form start --}}
                            <div class="form-row">
                                <div class="col-sm-3">
                                    <h5>Logo</h5><br>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-3 imgUp">
                                    <input type="hidden" class="imaage-data" name="logo">
                                    <div class="imagePreview">
                                        @if(($vendor->image!=''))
                                            <img src="{{ url('/').'/vendors' . '/' . $vendor->image}}">
                                        @endif</div>
                                    <label class="btn btn-primary button-lable">Select
                                        Logo<input type="file" data-from="logo" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"></label>
                                </div><!-- col-2 -->

                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-sm-12">
                                    <h5>Banner (Make sure Image Should be 600*400)</h5><br>
                                </div>
                                <?php $bs = json_decode($vendor->banner_image);?>
                                @foreach($bs as $k=>$b)

                                    <div class="col-sm-10 imgUp">
                                        <input type="hidden" class="imaage-data" name="keep_banner[]" value="{{$b}}">
                                        <div class="imagePreview"><img class="icon4" src="{{ asset('vendor-banner'.'/'.$b) }}"></div>
                                        <i class="fa fa-times del"></i></div><!-- col-2 -->
                                @endforeach

                                <div class="col-sm-10 imgUp">
                                    <input type="hidden" class="imaage-data" name="banner[]">
                                    <div class="imagePreview"></div>
                                    <label class="btn btn-primary button-lable">Select
                                        banner<input type="file" data-from="banner" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"></label>
                                </div><!-- col-2 -->
                                <i class="fa fa-plus imgAdd"></i>

                                {{--                                <div class="col-sm-10 imgUp">--}}
                                {{--                                    <input type="hidden" class="imaage-data" name="banner[]">--}}
                                {{--                                    <div class="imagePreview"></div>--}}
                                {{--                                    <label class="btn btn-primary button-lable">Select--}}
                                {{--                                        banner<input type="file" data-from="banner" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"></label>--}}
                                {{--                                </div><!-- col-2 -->--}}
                                {{--                                <i class="fa fa-plus imgAdd"></i>--}}
                            </div>
                            {{-- Location form end --}}

                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>

                </div>
            </form>


        </div>
        <!-- model -->
        <div class="modal fade" id="edit-category-model" tabindex="-1" role="dialog" aria-labelledby="modal-10">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title has-icon ms-icon-round ">Edit Restaurant Categories</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="" method="POST" action="{{route('restaurant.profile.update.category')}}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Categories</label>
                                <select class="form-control select2" multiple="true" name="categoriesArray[]" style="width: 100%;" required>
                                    @foreach($categories as $k =>$value)
                                        <?php

                                        if(in_array($k, $dealsIds)){
                                        ?>
                                        <option value="{{$k}}" selected>{{$value}}</option>
                                        <?php
                                        }else{
                                        ?>
                                        <option value="{{$k}}">{{$value}}</option>
                                        <?php
                                        }
                                        ?>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary shadow-none">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="modal fade" id="edit-cuisines-model" tabindex="-1" role="dialog" aria-labelledby="modal-10">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h3 class="modal-title has-icon ms-icon-round ">Edit Cuisines</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="" method="POST" action="{{route('restaurant.profile.update.cuisines')}}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cuisines</label>
                                <select class="form-control select2" multiple="true" name="categoriesArray[]" style="width: 100%;" required>
                                    @foreach($cuisines as $k =>$value)
                                        <?php

                                        if(in_array($k, $cuisIds)){
                                        ?>
                                        <option value="{{$k}}" selected>{{$value}}</option>
                                        <?php
                                        }else{
                                        ?>
                                        <option value="{{$k}}">{{$value}}</option>
                                        <?php
                                        }
                                        ?>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary shadow-none">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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



@section('page-js')

    <script>
        var bannerCount = 1;
        $(document).ready(function () {
            $(".imgAdd").click(function () {

                if ($(this).closest('div').children('.imgUp').last().children('.imaage-data').val() == '') {
                    toastr.error('Please Select Banner', 'Alert');
                    return false;
                }

                bannerCount++;
                $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-10 imgUp"><input type="hidden" class="imaage-data" name="banner[]"><div class="imagePreview"></div><label class="btn btn-primary button-lable">Select Image<input type="file" data-from="banner" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
                if (bannerCount > 2) {
                    $(this).hide();
                }
            });
            $(document).on("click", "i.del", function () {
                $(this).parent().remove();
                bannerCount--;
                if (bannerCount < 3) {
                    $('.imgAdd').show();
                }

            });
            $(function () {
                var _URL = window.URL || window.webkitURL;
                $(document).on("change", ".uploadFile", function () {

                    var from = $(this).attr('data-from');


                    var uploadFile = $(this);
                    var files = !!this.files ? this.files : [];

                    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                    if (/^image/.test(files[0].type)) { // only image file

                        var reader = new FileReader(); // instance of the FileReader
                        reader.readAsDataURL(files[0]); // read the local file
                        reader.onloadend = function (theFile) { // set image data as background of div
                            var data = this.result;
                            var image = new Image();
                            image.src = reader.result;
                            image.onload = function () {
                                if (from == 'banner') {
                                    width = this.width;
                                    height = this.height;
                                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + data + ")");
                                    uploadFile.closest(".imgUp").find('.imaage-data').val(data);
                                    uploadFile.closest(".imgUp").find('.button-lable').html('Change Image<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">');
                                    // if (this.width == 600 && this.height == 400) {
                                        
                                    // } else {
                                    //     toastr.error('Image Dimension Should be 600 by 400 ', 'Alert');
                                    // }
                                } else {
                                    uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + data + ")");
                                    uploadFile.closest(".imgUp").find('.imaage-data').val(data);
                                    uploadFile.closest(".imgUp").find('.button-lable').html('Change Image<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">');
                                }


                            };


                        }
                    } else {
                        toastr.error('Please Select Image file type Only', 'Alert');
                    }

                });
            });

            $('#menu-form').submit(function () {
                var error = false;
                var logo = $('input[name="logo"]').val();
                if (logo == '') {
                    error = true;
                    toastr.error('Please Select Logo  ', 'Alert');
                }
                var arr = $('input[name="banner[]"]').map(function () {
                    if (this.value == '') {
                        toastr.error('You Have To select Banner Image ', 'Alert');
                        error = true;
                    }
                }).get();
                if (error) {
                    return false;
                }


                if (error) {
                    return false;
                }


            })
        })
    </script>


@endsection
