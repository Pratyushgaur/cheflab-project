<?php
$breadcrumb[] = ["name"  => " Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Globle Setting",
                 'route' => route('restaurant.globleseting.ordertime')];
$breadcrumb[] = ["name"  => "Dining",
                 'route' => ""];
?>
@extends('vendor.restaurants-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])

            </div>

            @include('vendor.restaurant.globleseting.setting_menu')

            <div class="col-md-9">
                
                    @csrf
                    <div class="ms-panel">
                        <div class="ms-panel-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Product availability Setting
                                        
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <button name="checking[]" class="btn btn-primary btn-xs change-avail" style="float: right">
                                            Click to Change Availability 
                                        </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
            
               
                <div class="ms-panel">

              
                <div class="ms-panel-body">
                    @include('vendor.restaurant.alertMsg')
                    <div class="form-row">
                        

                        <div class="col-md-12 mb-12">

                            <?php
                            // $days[0] = "sunday";
                            // $days[1] = "monday";
                            // $days[2] = "tuesday";
                            // $days[3] = "wednesday";
                            // $days[4] = "thursday";
                            // $days[5] = "friday";
                            // $days[6] = "saturday";
                            ?>

                            <table class="table table-hover thead-primary">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th >Status</th>
                                </tr> 
                                </thead>
                                <tbody>
                                    @foreach($products as $Key =>$value)
                                        <tr>
                                            <td><input type="checkbox" name="action_product_check" value="{{$value->id}}" @if($value->vendor_product_unavailablities_id !=null) disabled @endif></td>
                                            <td>{{$value->product_name}}</td>
                                            <td>{{$value->product_price}}</td>
                                            <td>
                                                    @if($value->vendor_product_unavailablities_id !=null)
                                                    <span class="text-danger">Unavailable At <br>{{\Carbon\Carbon::parse($value->next_available)->format('d M h:i A')}}</span> 
                                                    <br><a href="{{route('restaurant.globleseting.products.display_setting.delete.entry',$value->id)}}" class="badge badge-danger" onclick="return confirm('Are You Sure To Want available this product')" style="color:#fff;">Remove</a>
                                                    @else
                                                    <span class="text-success">Available</span> 

                                                    @endif

                                            </td>
                                            
                                            
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{-- Location form end --}}

                    
                    
                </div>
            </div>
        </div>


    </div>

    </div>

    <!-- model -->
    <div class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-labelledby="modal-8" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="productOfflineForm" action="{{route('restaurant.globleseting.products.display_setting.store')}}">
                    <div class="hidden-input-container"></div>
                    @csrf
                    <div class="modal-header bg-primary">
                        <h3 class="modal-title has-icon text-white">Change Availablity</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group"  >
                                <label for="">Select When You Want to Available this products</label>
                                <select name="availabe_selector" id="" class="form-control availabe_selector">
                                    <option value="0">Restaurant Next Working Day time</option>
                                    <option value="1">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-12 custom_block form-group" style="display:none;">
                                <label for="">Choose Custom Date Time</label>
                                <div class="row">
                                    <div class="col-md-6"><input type="date" name="next_available_date" class="form-control next-available-date"><div class="text-danger next-available-date-error"></div></div>
                                    <div class="col-md-6"><input type="time" name="next_available_time" class="form-control next-available-time"><div class="text-danger next-available-time-error" ></div></div>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-12 time_block form-group" style="">
                            <input type="hidden" name="date_of_available" value="{{$date}}">
                                <label for="">Choose Next Available Day Wroking Time</label>
                                <div class="row">
                                    @foreach($next_available_day as $key =>$value)
                                    
                                    <div class="col-md-12" style="padding:6px; text-align:center;" >
                                        <div style="width:100%;  border:1px solid gray; padding:6px; box-shadow: 2px 1px 7px gray;"><input type="radio" id="check_{{$key}}" name="slot" value="{{$value->start_time}}"  @if($key == 0) checked @endif> <label for="check_{{$key}}" > {{\Carbon\Carbon::parse($value->start_time)->format('h:i A')}}</label></div>
                                    </div>
                                    @endforeach
                                    
                                    
                                </div>
                                
                                
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary shadow-none submit-offilne-form" {{--data-dismiss="modal"--}} id="">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function submit_vendor() {

            $.ajax({
                url: '{{ route('restaurant.dineout.vendor_table_setting') }}',
                type: 'post',
                cache: false,
                data:{'_token' : '<?php echo csrf_token() ?>',
                    'vendor_table_service' : $("#vendor_table_service").prop('checked')
                },
               // data: $('#restaurent_status_form').serialize(),
                success: function (data) {
                    if (data.msg != '') {
                        $("#vendor_table_service").val(data.rest_status);

                        // toastr.success(data.msg, 'Success');
                        Swal.fire({
                            // position: 'top-end',
                            type: 'success',
                            title: data.msg,
                            showConfirmButton: true,
                            timer: 15000
                        });

                        @if (!isset($table_service->id))
                        $("#dine_out_full_form").submit();
                        @endif

                    } else
                        toastr.error('Some thing went wrong', 'Error');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.error('Some thing went wrong', 'Error');
                }
            });
        }

        $("#vendor_table_service").on("change", submit_vendor);

        function submit_dien_out() {
            $.ajax({
                url: '{{ route('restaurant.dineout.dine_out_setting') }}',
                type: 'post',
                cache: false,
                data: $('#dine_out_form').serialize(),
                success: function (data) {
                    if (data.msg != '') {
                        toastr.success(data.msg, 'Success');
                    } else
                        toastr.error('Some thing went wrong', 'Error');
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.error('Some thing went wrong', 'Error');
                }
            });
        }

        $("#restaurent_status_id").on("change", submit_dien_out);
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

    <script>
        (function ($) {


            $("#dine_out_full_form").validate({
                rules: {
                    no_guest: {
                        required: true
                    },
                    slot_time: {
                        required: true
                    },
                    slot_discount: {
                        required: true
                    }
                },
                messages: {
                    no_guest: {
                        required: "Number of guest is required"
                    },
                    slot_time: {
                        required: "slot time is Required",
                    },
                    slot_discount: {
                        required: "Discount is required",
                    }
                }
            });
            $(".change-avail").click(function(){
                var ids = [];
                var inputs = '';
                $("input:checkbox[name=action_product_check]:checked").each(function(){
                    
                    ids.push($(this).val());
                    inputs+='<input type="hidden" name="productIds[]" value="'+$(this).val()+'">'
                });

                if(ids.length > 0){
                    $(".hidden-input-container").html(inputs);
                    $("#modal-8").modal('show');
                }else{
                    alert("Please Select Product first");
                }
            }) 
            $('.availabe_selector').change(function(){
                if($(this).val() == "1"){
                    $(".custom_block").show();
                    $(".time_block").hide();
                    
                }else{

                    $(".custom_block").hide();
                    $(".time_block").show();
                    
                }
                
            }) 
            $("#productOfflineForm").submit(function(){
                var value = $(".availabe_selector").val();
                
                if(value == '1'){
                    if($(".next-available-date").val() == ''){
                        $(".next-available-date-error").text("Date is required");
                        return false;
                    }else{
                        $(".next-available-date-error").text("");
                        var UserDate = $(".next-available-date").val();
                        var ToDate = new Date();
                        if (new Date(UserDate).getTime() <= ToDate.getTime()) {
                            $(".next-available-date-error").text("The Date must be Greater Then Today");
                            return false;
                        }

                        

                    }
                    if($(".next-available-time").val() == ''){
                        $(".next-available-time-error").text("Time is required");
                        return false;
                    }else{
                        $(".next-available-time-error").text("");

                    }
                }
                
                
            })
        })(jQuery);
    </script>
@endpush

@section('page-css')
    <style>
        .error {
            width: 100%;
            color: red;
        }

        ;
    </style>
@endsection
