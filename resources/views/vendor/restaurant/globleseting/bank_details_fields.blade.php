
<div class="form-row">

    <div class="col-md-12 mb-12">
        <label>Bank name <code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::text('bank_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Bank name', 'min' => 3]) }}
            @if ($errors->has('bank_name'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('bank_name') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label>Account holder name <code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::text('holder_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Account Holder name', 'min' => 3]) }}
            @if ($errors->has('holder_name'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('holder_name') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label>Account number<code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::number('account_no', null, ['class' => 'form-control', 'required', 'placeholder' => 'Account Number','pattern'=>"[1-9]{10}"]) }}
            @if ($errors->has('account_no'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('account_no') }}</strong></span>
            @endif
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label>IFSC Code <code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::text('ifsc', null, ['class' => 'form-control', 'required', 'placeholder' => 'IFSC', 'min' => 3]) }}
            @if ($errors->has('ifsc'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('ifsc') }}</strong></span>
            @endif
        </div>
    </div>


{{--    <div class="col-md-6 mb-3">--}}
{{--        <label>Cancel check scan image <code class="ms-text-danger">*</code></label>--}}
{{--        <div class="input-group">--}}
{{--            {{ Form::file('cancel_check', null, ['class' => 'form-control', 'required', 'placeholder' => 'cancel_check', 'min' => 3]) }}--}}
{{--            @if ($errors->has('cancel_check'))--}}
{{--                <span class="ms-text-danger"> <strong>{{ $errors->first('cancel_check') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="col-md-6 mb-3">
        <label>Aadhar Number <code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::text('aadhar_number', \Auth::guard('vendor')->user()->aadhar_number, ['class' => 'form-control', 'required', 'placeholder' => 'Aadhar number', 'min' => 3]) }}
            @if ($errors->has('aadhar_number'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('aadhar_number') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label>Pan Number <code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::text('pancard_number', \Auth::guard('vendor')->user()->pancard_number, ['class' => 'form-control', 'required', 'placeholder' => 'Pan number', 'min' => 3]) }}
            @if ($errors->has('pancard_number'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('pancard_number') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label>Fassi Number <code class="ms-text-danger">*</code></label>
        <div class="input-group">
            {{ Form::text('fssai_lic_no', \Auth::guard('vendor')->user()->fssai_lic_no, ['class' => 'form-control', 'required', 'placeholder' => 'fassi number', 'min' => 3]) }}
            @if ($errors->has('fssai_lic_no'))
                <span class="ms-text-danger"> <strong>{{ $errors->first('fssai_lic_no') }}</strong></span>
            @endif
        </div>
    </div>


</div>
<div class="form-row">
{{--    <div class="col-sm-12"><h5>Aadhar scan image</h5><br></div>--}}
    <div class="col-sm-3 imgUp">
        <input type="hidden" class="imaage-data" name="aadhar_card_image">
        <div class="imagePreview"></div>
        <label class="btn btn-primary button-lable"><?php echo (auth()->guard('vendor')->user()->aadhar_card_image!='') ? "Aadhar Already uploaded" : 'Upload Aadhar Card'?><input accept="image/*" type="file" data-from="aadhar_card_image" class="uploadFile img" value="Upload Aadhar Card" style="width: 0px;height: 0px;overflow: hidden;"></label>
    </div><!-- col-2 -->


    <div class="col-sm-3 imgUp">
        <input type="hidden" class="imaage-data" name="pancard_image">
        <div class="imagePreview"></div>
        <label class="btn btn-primary button-lable"><?php echo (auth()->guard('vendor')->user()->pancard_image!='') ? "Pan card Already uploaded" : 'Pan card image'?><input accept="image/*" type="file" data-from="pancard_image" class="uploadFile img" value="Upload Pan Card" style="width: 0px;height: 0px;overflow: hidden;"></label>
    </div><!-- col-2 -->


    <div class="col-sm-3 imgUp">
        <input type="hidden" class="imaage-data" name="fassi_image">
        <div class="imagePreview"></div>
        <label class="btn btn-primary button-lable"><?php echo (auth()->guard('vendor')->user()->licence_image!='') ? "fassi Already uploaded" : 'fassi image'?><input accept="image/*" type="file" data-from="fassi_image" class="uploadFile img" value="Upload fassi" style="width: 0px;height: 0px;overflow: hidden;"></label>
    </div><!-- col-2 -->

    <div class="col-sm-3 imgUp">
        <input type="hidden" class="imaage-data" name="cancel_check">
        <div class="imagePreview"></div>
        <label class="btn btn-primary button-lable"><?php echo (@$bankDetail->cancel_check!='') ? "Cancel Check Already uploaded" : 'Cancel Check'?><input accept="image/*" type="file" data-from="cancel_check" class="uploadFile img" value="Upload Cancel check " style="width: 0px;height: 0px;overflow: hidden;"></label>
    </div><!-- col-2 -->
</div>


{{--<div class="form-row">--}}
{{--    <div class="col-mdma-6 mb-6">--}}
{{--        <a class="btn btn-light " href="{{route('restaurant.require.ordertime')}}">Back</a>--}}
{{--    </div>--}}
{{--    <div class="col-md-6 mb-6">--}}
{{--        <button class="btn btn-primary" type="submit" style="float: right">Submit</button>--}}
{{--    </div>--}}
{{--</div>--}}


@push('scripts')

    <script>

        $(document).ready(function () {
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
                                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + data + ")");
                                uploadFile.closest(".imgUp").find('.imaage-data').val(data);
                                uploadFile.closest(".imgUp").find('.button-lable').html('Change Image<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">');

                            };
                        }
                    } else {
                        toastr.error('Please Select Image file type Only', 'Alert');
                    }

                });
            });

            $("#product-form").validate({
                rules: {
                    product_name: {
                        required: true,
                        maxlength: 40,
                    },
                    cuisines: {
                        required: true
                    },
                    category: {
                        required: true
                    },
                    menu_id: {
                        required: true
                    },
                    dis: {
                        required: true,
                    },
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
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("name");

                    error.appendTo($("." + name + "_error"));
                },
            });

            $('#menu-form').submit(function () {
                var error = false;
                var pancard_image = $('input[name="pancard_image"]').val();
                if (pancard_image == '') {
                    error = true;
                    toastr.error('Please Select Pan card scan copy  ', 'Alert');
                }
                var fassi_image = $('input[name="fassi_image"]').val();
                if (fassi_image == '') {
                    error = true;
                    toastr.error('Please Select fassi scan copy  ', 'Alert');
                }
                var aadhar_card_image = $('input[name="aadhar_card_image"]').val();
                if (aadhar_card_image == '') {
                    error = true;
                    toastr.error('Please Select aadhar card scan copy  ', 'Alert');
                }

                if(error){
                    return false;
                }



            });
        });
    </script>


@endpush
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
