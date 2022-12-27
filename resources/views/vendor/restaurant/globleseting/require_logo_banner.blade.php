@extends('vendor.restaurants-layout')
@section('page-css')
<style>
.imagePreview {
    width: 100%;
    min-height: 180px;
    background-position: center center;

    background-color:#fff;
    background-size: cover;
    background-repeat:no-repeat;
    display: inline-block;
    box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);

}
.btn-primary
{
  display:block;
  border-radius:0px;
  box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
  margin-top:-5px;
}
.imgUp
{
  margin-bottom:15px;
}
.del
{
  position:absolute;
  top:0px;
  right:15px;
  width:30px;
  height:30px;
  text-align:center;
  line-height:30px;
  background-color:rgba(255,255,255,0.6);
  cursor:pointer;
}
.imgAdd
{
  width:30px;
  height:30px;
  border-radius:50%;
  background-color:#4bd7ef;
  color:#fff;
  box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
  text-align:center;
  line-height:30px;
  margin-top:0px;
  cursor:pointer;
  font-size:15px;
}
</style>
@endsection
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            {{-- <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>
                        <li class="breadcrumb-item"><a href="#">Restaurant Location</a></li>
                    </ol>
                </nav>
            </div> --}}
            <div class="col-xl-2"></div>
            <div class="col-xl-8 col-md-8">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Restaurant Essential Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <nav aria-label = "breadcrumb">
                                    <ol class = "breadcrumb breadcrumb-arrow has-gap has-bg">
                                        <li class = "breadcrumb-item"><a href = "{{route('restaurant.require.ordertime')}}">Restaurant Timing</a></li>
                                        <li class = "breadcrumb-item"><a href = "{{route('restaurant.globleseting.frist_vendor_location')}}">Location</a></li>
                                        <li class = "breadcrumb-item"><a href = "{{route('restaurant.globleseting.first_vendor_logo')}}">Logo And Banner</a></li>
                                        <li class = "breadcrumb-item active"><a href = "{{route('restaurant.globleseting.first_bank_details')}}">Bank Details</a></li>
                                    </ol>
                                </nav>
                                <form class="validation-fill clearfix " id="menu-form" action="{{ route('restaurant.globleseting.save_vendor_logo') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Location form start --}}
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <h5>Logo</h5><br>
                                        </div>
                                        <div class="col-sm-3 imgUp">
                                            <input type="hidden" class="imaage-data" name="logo">
                                            <div class="imagePreview" ></div>
                                            <label class="btn btn-primary button-lable">Select Logo<input type="file" data-from="logo" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"></label>
                                        </div><!-- col-2 -->

                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-sm-12">
                                            <h5>Banner (Make sure Image Should be 600*400)</h5><br>
                                        </div>
                                        <div class="col-sm-10 imgUp">
                                            <input type="hidden" class="imaage-data" name="banner[]">
                                            <div class="imagePreview"></div>
                                            <label class="btn btn-primary button-lable">Select banner<input type="file" data-from="banner" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;"></label>
                                        </div><!-- col-2 -->
                                        <i class="fa fa-plus imgAdd"></i>
                                    </div>
                                    {{-- Location form end --}}

                                    <div class="form-row">
                                        <div class="col-md-6 mb-6">
                                        <a class="btn btn-light " href="{{route('restaurant.globleseting.frist_vendor_location')}}" >Back</a>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                        <button class="btn btn-primary" type="submit"  style="float: right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>





            </div>
            <div class="col-xl-2"></div>
        </div>
    @endsection
    @section('page-js')

        <script>
            var bannerCount = 1;
            $(document).ready(function(){
                $(".imgAdd").click(function(){

                    if($(this).closest('div').children('.imgUp').last().children('.imaage-data').val() ==''){
                        toastr.error('Please Select Banner', 'Alert');
                        return false;
                    }

                    bannerCount++;
                    $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-10 imgUp"><input type="hidden" class="imaage-data" name="banner[]"><div class="imagePreview"></div><label class="btn btn-primary button-lable">Select Image<input type="file" data-from="banner" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
                    if(bannerCount > 2){
                        $(this).hide();
                    }
                });
                $(document).on("click", "i.del" , function() {
                    $(this).parent().remove();
                    bannerCount--;
                    if(bannerCount < 3){
                        $('.imgAdd').show();
                    }

                });
                $(function() {
                    var _URL = window.URL || window.webkitURL;
                        $(document).on("change",".uploadFile", function(){

                            var from = $(this).attr('data-from');


                            var uploadFile = $(this);
                            var files = !!this.files ? this.files : [];

                            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

                            if (/^image/.test( files[0].type)){ // only image file

                                var reader = new FileReader(); // instance of the FileReader
                                reader.readAsDataURL(files[0]); // read the local file
                                reader.onloadend = function(theFile){ // set image data as background of div
                                    var data = this.result;
                                    var image = new Image();
                                    image.src = reader.result;
                                    image.onload = function() {
                                        if(from == 'banner'){
                                            width = this.width;
                                            height = this.height;
                                            uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+data+")");
                                            uploadFile.closest(".imgUp").find('.imaage-data').val(data);
                                            uploadFile.closest(".imgUp").find('.button-lable').html('Change Image<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">');
                                            // if(this.width == 600 &&  this.height == 400){
                                            //     uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+data+")");
                                            //     uploadFile.closest(".imgUp").find('.imaage-data').val(data);
                                            //     uploadFile.closest(".imgUp").find('.button-lable').html('Change Image<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">');
                                            // }else{
                                            //     toastr.error('Image Dimension Should be 600 by 400 ', 'Alert');
                                            // }
                                        }else{
                                            uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+data+")");
                                            uploadFile.closest(".imgUp").find('.imaage-data').val(data);
                                            uploadFile.closest(".imgUp").find('.button-lable').html('Change Image<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">');
                                        }



                                    };




                                }
                            }else{
                                toastr.error('Please Select Image file type Only', 'Alert');
                            }

                        });
                });

                $('#menu-form').submit(function(){
                    var error = false;
                    var logo = $('input[name="logo"]').val();
                    if (logo == ''){
                        error =true;
                        toastr.error('Please Select Logo  ', 'Alert');
                    }
                    var arr = $('input[name="banner[]"]').map(function () {
                            if(this.value == ''){
                                toastr.error('You Have To select Banner Image ', 'Alert');
                                error = true;
                            }
                    }).get();
                    if(error){
                        return false;
                    }


                    if(error){
                        return false;
                    }


                })
            })
        </script>


    @endsection
