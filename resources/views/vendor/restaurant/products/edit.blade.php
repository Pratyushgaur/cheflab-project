@extends('vendor.restaurants-layout')
@section('main-content')

    <style>
        .select2-selection__choice {
            background: #ff0018;
        }

        .select2-selection__choice__display {
            color: #fff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ff0018;
        }

        .image-upload {
            display: inline-block;
            margin-right: 15px;
            position: relative;
        }

        .image-upload > input {
            display: none;
        }

        .upload-icon {
            width: 150px;
            height: 150px;
            border: 2px solid #000;
            border-style: dotted;
            border-radius: 18px;
        }


        .upload-icon img {
            width: 100px;
            height: 100px;
            margin: 19px;
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
            margin: 0px;
        }
    </style>
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('restaurant.product.list')}}">Items</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Item</li>


                    </ol>
                </nav>
            </div>

            <div class="col-xl-12 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Update Item</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form class=" clearfix" id="product-form" action="{{route('restaurant.product.update')}}"
                              method="post" enctype="multipart/form-data">
                            @csrf

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            @endif
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom18">Item Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="product_name" value="{{$product->product_name}}" class="form-control" id="validationCustom18" placeholder="Product Name" value="">
                                        <input type="hidden" name="id" value="{{$product->id}}" class="form-control"
                                               id="validationCustom18" placeholder="Product Name" value="">
                                        <input type="hidden" name="status" value="{{$product->status}}" class="form-control" id="validationCustom18" placeholder="Product Name" value="">
                                        <input type="hidden" name="txtpkey" id="txtpkey" value="{{$product->id}}">
                                    </div>
                                    <span class="product_name_error text-danger"></span>
                                </div>

                                <!-- <div class="col-md-4 mb-3">
                                    <label for="validationCustom22">Select Cuisines Category <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        {{ Form::select('cuisines', $cuisines,$product->cuisines, ['class' => 'form-control select2', 'placeholder' => 'Select cuisine ','required','id'=>'validationCustom22']) }}
                                        @if ($errors->has('cuisines'))
                                            <span class="ms-text-danger"><strong>{{ $errors->first('cuisines') }}</strong></span>
                                        @endif



                                        {{--                                        <select class="form-control select2" name="cuisines" id="validationCustom22">--}}
                                        {{--                                            <option value="{{$product->cuisinesName}}">{{$product->cuisinesName}}</option>--}}
                                        {{--                                            @foreach($cuisines as $k =>$value)--}}
                                        {{--                                                <option value="{{$value->id}}">{{$value->name}}</option>--}}
                                        {{--                                            @endforeach--}}
                                        {{--                                        </select>--}}
                                    </div>
                                    <span class="cuisines_error text-danger"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom">Select Product Category <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        {{ Form::select('category', $categories,$product->category, ['class' => 'form-control select2', 'placeholder' => 'Select Category ','required','id'=>'validationCustom']) }}
                                        @if ($errors->has('category'))
                                            <span class="ms-text-danger"><strong>{{ $errors->first('category') }}</strong></span>
                                        @endif

                                        {{--                                        <select class="form-control select2" name="category" id="validationCustom">--}}
                                        {{--                                            <option value="{{$product->categoryName}}">{{$product->categoryName}}</option>--}}
                                        {{--                                            @foreach($categories as $k =>$value)--}}
                                        {{--                                                <option value="{{$value->id}}">{{$value->name}}</option>--}}
                                        {{--                                            @endforeach--}}

                                        {{--                                        </select>--}}

                                    </div>
                                    <span class="category_error text-danger"></span>
                                </div> -->

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom24">Select Menu <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        {{ Form::select('menu_id',$menus,$product->menu_id, ['class' => 'form-control select2', 'placeholder' => 'Select menu ','required','id'=>'validationCustom24']) }}

                                        @if ($errors->has('menu_id'))
                                            <span class="ms-text-danger"><strong>{{ $errors->first('menu_id') }}</strong></span>
                                        @endif

                                    </div>
                                    <span class="menu_id_error text-danger"></span>
                                </div>


                                <div class="col-md-12 mb-3">
                                    <label for="validationCustom12">Description </label>
                                    <div class="input-group">
                                        <textarea rows="5" id="validationCustom12" name="dis" value="{{$product->dis}}" class="form-control" placeholder="Message">{{$product->dis}}</textarea>

                                    </div>
                                    <span class="dis_error text-danger"></span>

                                </div>
                                <div class="col-md-12 mb-3"
                                     @if(Auth::guard('vendor')->user()->vendor_food_type == '1') style="display:none;" @endif>
                                    <label for="validationCustom12">Item Type</label>
                                    <div class="col-md-6">
                                        <ul class="ms-list ms-list-display">


                                            <li>
                                                <label class="ms-checkbox-wrap ms-checkbox-success">
                                                    <input type="radio" value="veg" name="product_type" <?php if($product->type == 'veg'){echo 'checked';} ?>> <i
                                                        class="ms-checkbox-check"></i>
                                                </label> <span> Veg </span>
                                            </li>
                                            <li>
                                                <label class="ms-checkbox-wrap ms-checkbox-danger">
                                                    <input type="radio" value="non_veg" name="product_type" <?php if($product->type == 'non_veg'){echo 'checked';} ?>> <i
                                                        class="ms-checkbox-check"></i>
                                                </label> <span> Veg + Non Veg </span>
                                            </li>
{{--                                            <li>--}}
{{--                                                <label class="ms-checkbox-wrap ms-checkbox-warning">--}}
{{--                                                    <input type="radio" value="eggs" name="product_type"> <i--}}
{{--                                                        class="ms-checkbox-check"></i>--}}
{{--                                                </label> <span> Eggitarian </span>--}}
{{--                                            </li>--}}
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Item Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{$product->product_price}}" name="item_price" id="" placeholder="Enter Price" value="">

                                    </div>

                                    <span class="item_price_error text-danger"></span>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label for="">Primary Variant Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="primary_variant_name" id=""
                                               placeholder="Primary Variant Name " value="{{$product->primary_variant_name}}">

                                    </div>

                                    <span class="primary_variant_name_error text-danger"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Primary Item Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="product_price" id="price" placeholder="Enter Price" value="{{$product->product_price}}">

                                    </div>

                                    <span class="item_price_error text-danger"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom23">Custmization Availablity</label>
                                    <div class="input-group">
                                        <select class="form-control custimization" name="custimization" id="validationCustom23 ">
                                            <option value="false">No</option>
                                            <option value="true" {{($product->customizable=='true') ? "selected" : ''}}>
                                                Yes
                                            </option>
                                        </select>
                                    </div>
                                    <span id="custimization_error" class="custimization_error text-danger"></span>
                                </div>
                                <div class="col-md-12 mb-3 custmization-block" style="">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Product Variant</h5>
                                        </div>
                                    </div>
                                    {{--                                    {{dd($product->product_variants)}}--}}

                                    <div class="variant-input-container">
                                        @if($product->customizable=='true')
                                            @foreach($product->product_variants as $k=>$vri)

                                                <input type="hidden" name="variant_id[]" value="{{$vri->id}}">
                                                <div class="row input-container" style="padding-bottom:15px;">
                                                    <div class="col-md-4">
                                                        <input type="text" name="variant_name[]" class="form-control variant_name" placeholder="Enter Variant Name" value="{{$vri->variant_name}}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" name="price[]" class="form-control price" placeholder="Enter Price" value="{{$vri->variant_price}}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a class="" href="javascript:void(0)"><i class="fa fa-trash delete-variant" style="margin-top:10px;"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @else
                                            <div class="row input-container" style="padding-bottom:15px;">
                                                <div class="col-md-4">
                                                    <input type="text" name="variant_name[]" class="form-control variant_name" placeholder="Enter Variant Name">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="price[]" class="form-control price" placeholder="Enter Price">
                                                </div>
                                            </div>
                                    @endif
                                    <!-- <div class="row input-container" style="padding-bottom:15px;">
                                            <div class="col-md-4">
                                                <input type="text" name="variant_name[]" class="form-control variant_name"  placeholder="Enter Variant Name">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="price[]" class="form-control price" placeholder="Enter Price">
                                            </div>
                                            <div class="col-md-2">
                                                <a class="" href="javascript:void(0)" ><i class="fa fa-trash delete-variant" style="margin-top:10px;"></i></a>
                                            </div>
                                        </div> -->
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4"><a href="javascript:void(0)" class="add">+ Add More
                                                Variant</a></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 mb-12">
                                            <label for="validationCustom23">Select Product Addons (Optional)</label>
                                            <div class="input-group">
                                                {{ Form::select('addons[]',$addons,@explode(',',@$product->addons), ['class' => 'form-control select2 addons-select','id'=>'validationCustom23','multiple'=>"true"]) }}


                                                {{--                                                <select class="form-control select2 addons-select" name="addons[]" multiple="true" id="validationCustom23">--}}
                                                {{--                                                    @foreach($addons as $k =>$value)--}}
                                                {{--                                                        <option value="{{$value->id}}">{{$value->addon}} -Rs {{$value->price}}</option>--}}
                                                {{--                                                    @endforeach--}}
                                                {{--                                                </select>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Preparation Time</label>
                                    <div class="input-group">
                                        {{--                                        {{dd($product)}}--}}
                                        {{ Form::select('preparation_time', config('custom_app_setting.product_preparation_time'),$product->preparation_time,['class' => 'form-control', 'placeholder' => 'Select Preparation Time ','required']) }}

                                        @if ($errors->has('preparation_time'))
                                            <span
                                                class="ms-text-danger"><strong>{{ $errors->first('preparation_time') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Chili Level</label>
                                    <div class="input-group">
                                        {{ Form::select('chili_level', config('custom_app_setting.product_chili_level'),$product->chili_level,['class' => 'form-control', 'required']) }}

                                        @if ($errors->has('chili_level'))
                                            <span
                                                class="ms-text-danger"><strong>{{ $errors->first('chili_level') }}</strong></span>
                                        @endif
                                        <span class="chili_level_error text-danger"></span>
                                    </div>
                                </div>
{{--                                <div class="col-md-4 mb-3">--}}
{{--                                    <label>Type</label>--}}
{{--                                    <div class="input-group">--}}

{{--                                        <label>{!! Form ::radio('type','veg',($product->type=='veg') ? true : false) !!}  Veg</label>--}}

{{--                                        <label>{!! Form ::radio('type','non_veg',($product->type=='non_veg') ? true : false,['style'=>"margin-left: 10px;"]) !!} Non-veg</label>--}}

{{--                                        @if ($errors->has('type'))--}}
{{--                                            <span--}}
{{--                                                class="ms-text-danger"><strong>{{ $errors->first('type') }}</strong></span>--}}
{{--                                        @endif--}}
{{--                                        <span class="type_error text-danger"></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <div class="col-md-6 mb-3">
                                    <div>
                                        <label for="">Product Images</label>
                                    </div>
                                    <div class="image-upload">
                                        <label for="file-input">
                                            <div class="upload-icon">
                                                <img class="icon"
                                                     src="{{ asset('products'.'/'.$product->product_image) }}">
                                            </div>
                                        </label>
                                        <input id="file-input" type="file" name="product_image" required/>
                                    </div>
                                </div>
                                <span class="product_image_error text-danger"></span>
                                <!--  -->


                            </div>

                            <div class="form-row">
                                <button class="btn btn-primary" type="submit">Publish Item</button>
                            </div>


                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('page-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

    <script>
        (function ($) {
            $('.select2').select2();

            <?php if($product->customizable == 'false'){?>
            $('.custmization-block').hide();
            <?php }?>

            $(document).on('click', '.delete-variant', function () {
                $(this).parent().parent().parent().remove();

            })
            $(document).on('click', '.add', function () {
                var html = '<div class="row input-container" style="padding-bottom:15px;"><div class="col-md-4">' +
                    '<input type="text" name="variant_name[]" class="form-control variant_name"  placeholder="Enter Variant Name">' +
                    '</div><div class="col-md-2"><input type="text" name="price[]" class="form-control price" placeholder="Enter Price"></div>' +
                    '<div class="col-md-2"><a class="" href="javascript:void(0)" ><i class="fa fa-trash delete-variant" style="margin-top:10px;"></i></a>' +
                    '</div></div>';
                $('.variant-input-container').append(html);
            })
            $('.custimization').change(function () {
                if ($(this).val() == 'true') {
                    $('.custmization-block').show();
                } else {
                    $('.custmization-block').hide();
                }
            })
            $('#price').on("input", function () {
                var price = document.getElementById('price').value;
                $("#myInput").val(price);
            })

            $('#file-input').change(function (event) {
                $("img.icon").attr('src', URL.createObjectURL(event.target.files[0]));
                $("img.icon").parents('.upload-icon').addClass('has-img');
            });


            $.validator.addMethod('checkVariants',
                function (value, element) {
                    if (value == 'true') {
                        var at_least_one_vaariant = false;
                        var check = true;
                        $('.input-container').each(function (index, value) {
                            if ($(this).find('.variant_name').val() == '') {
                                check = false;
                            }
                            if ($(this).find('.price').val() == '') {
                                check = false;
                            }
                            if ($(this).find('.variant_name').val() != '' && $(this).find('.price').val() != '')
                                at_least_one_vaariant = true;
                        });
                        if (at_least_one_vaariant == false) {
                            if ($("#validationCustom23").val() == '') {

                                return false;
                            }else
                                return true;
                        }else{
                            if (check) {
                                return true;
                            } else {

                                return false;
                            }
                        }

                    } else {
                        return true;
                    }
                }, 'Veriant or addon, at least one of the field must be required.');
            $("#product-form").validate({
                rules: {
                    product_name: {
                        required: true,
                        maxlength: 120,
                    },
                    // cuisines: {
                    //     required: true
                    // },
                    // category: {
                    //     required: true
                    // },
                    menu_id: {
                        required: true
                    },
                    // dis: {
                    //     required: true,
                    // },
                    item_price: {
                        required: true,
                        number: true,
                        maxlength: 10,
                    },
                    custimization: {
                        checkVariants: true,
                        required: true
                    },

                    primary_variant_name: {
                        required: true
                    }
                },
                messages: {
                    product_name: {
                        required: "Item Name is required",
                        maxlength: "Item  name cannot be more than 40 characters"
                    },
                    cuisines: {
                        required: "Cuisines is Required",
                    },
                    category: {
                        required: "Category is required",
                    },
                    menu_id: {
                        required: "Product Should be in Catalogue",
                    },
                    dis: {
                        required: "Item Description is Required For Detail of Product",
                    },
                    item_price: {
                        required: "Please Give The Price of Product",
                        number: "Price Should be in Number"
                    },
                    primary_variant_name: {
                        required: "Please Enter Primary Variant Name"
                    }
                }
            });
        })(jQuery);
    </script>
@endsection
