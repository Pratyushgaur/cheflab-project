@extends('vendor.vendor_app.restaurants-layout')
@section('main-content')
    <?php
    $status_class['pending'] = 'primary';
    $status_class['confirmed'] = 'warning';
    $status_class['preparing'] = 'secondary';
    $status_class['ready_to_dispatch'] = 'info';
    $status_class['dispatched'] = 'success';
    $status_class['completed'] = 'success';
    $status_class['payment_pending'] = 'warning';
    $status_class['cancelled_by_vendor'] = 'danger';
    $status_class['cancelled_by_customer'] = 'danger'; 
    $status_class['cancelled_by_customer_after_confirmed'] = 'danger';

    ?>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <h1 class="db-header-title">Welcome, {{ucfirst(Auth::guard('vendor')->user()->name)}}</h1>
            </div>

            
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12 load"  >
                
            </div>
            
            
            
        
    </div>
    <!-- model for order -->
    <div class="modal fade" id="modal-7" tabindex="-1" role="dialog" aria-labelledby="modal-7" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="preparation_form">
                    <input type="hidden" class="form_order_id" name="order_id">
                   
                    <div class="modal-header bg-primary">
                        <h3 class="modal-title has-icon text-white">Order preparation </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <input type="hidden" name="orignel_preparation_time" value="" id="orignel_preparation_time">
                    <div class="modal-body">
                        <div class="ms-form-group has-icon">
                            <label>Order preparation time</label>
                            <input type="number" readonly placeholder="preparation time in minutes" class="form-control" name="preparation_time" value="" step="1" id="preparation_time">
                                    <i class="material-icons">timer</i>
                            
                            
                            <!-- <code>Sum of All Preparation Time of Products for particular Order will be order preparation
                                
                                time </code> -->
                                <code>Default Prepration Minutes Define by admin . You can Increase time by click need more time Button</code>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="button"  class="btn btn-primary shadow-none prepration-submit-button" {{--data-dismiss="modal"--}} id="submit_model">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-labelledby="modal-7" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content product_viewer">
                
            </div>
            
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $("#dashboard_input").change(function() {
            this.form.submit();
        });
        $('.click-box').click(function(){
            window.location.href = $(this).attr('data-link');
        })
        $('.load').load('{{route('app.restaurant.order.refresh_list')}}').fadeIn("slow");
        setInterval(function () {$('.load').load('{{route('app.restaurant.order.refresh_list')}}').fadeIn("slow");}, 10000); 
        function preparation_form(url, id) {
            $('.form_order_id').val(id);

            $.ajax({
                url: '{{route('restaurant.order.get_preparation_time')}}',
                type: 'post',
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "order_id": id
                },
                success: function (data) {

                    if (data.total_preparation_time != '') {
                        $("#orignel_preparation_time").val(data.total_preparation_time);
                        $("#preparation_time").val(data.total_preparation_time);
                    }

                    $("#extend_time_div").hide();
                    if (data.is_extend_time) {
                        $("#extend_time_div").show();
                        $("#extend_preparation_time").prop('max', data.max_preparation_time);
                        $("#extend_preparation_time").attr('placeholder', "maximum value " + data.max_preparation_time);
                    }
                },
                error: function (xhr, textStatus, thrownError) {
                    // toastr.info('Something went wrong', 'Info');
                }
            });
            $('#myModal').modal('show');
        }
        $('.prepration-submit-button').click(function(){
            //$(this).prop('disabled', true);
            var orderid = $('.form_order_id').val();
            
            $.ajax({
                url: '{{route('app.restaurant.acceptOrder')}}',
                type: 'post',
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "form_data": $('#preparation_form').serialize()
                },
                success: function (data) {
                    console.log(data.status);
                    if(data.status == true){
                        $('#modal-7').hide();
                        Swal.fire('Great job!',data.message,'success');
                        $(".status_container_"+orderid+"").html("<div class='col-xs-12 col-md-12'><button class='btn btn-block btn-success' onclick='ready_to_dispatch_form("+orderid+")' style='border-radius:10px;'>Preparing</button></div>");
                        $(this).prop('disabled', false);
                    }else{
                        Swal.fire({icon: 'error',title: 'Oops...',text: data.error,})
                        $(this).prop('disabled', false)

                    }
                    
                },
                error: function (xhr, textStatus, thrownError) {
                    // toastr.info('Something went wrong', 'Info');
                }
            });
            //$('#preparation_form').submit();
            
        })
        function ready_to_dispatch_form(orderid){
            Swal.fire({
                title: 'Do you want to change Status for ready to disptch',
                
                showCancelButton: true,
                confirmButtonText: 'Save',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route('app.restaurant.ready_to_dispatch')}}',
                        type: 'post',
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "order_id": orderid
                        },
                        success: function (data) {
                            console.log(data.status);
                            if(data.status == true){
                                Swal.fire('Great job!',data.message,'success');
                                $(".status_container_"+orderid+"").html("<div class='col-xs-12 col-md-12'><button class='btn btn-block btn-info'>Ready to Dispatch</button></div>");
                                $(".otp_block_"+orderid+"").show();
                            }else{
                                Swal.fire({icon: 'error',title: 'Oops...',text: data.error,})
                            }
                            
                        },
                        error: function (xhr, textStatus, thrownError) {
                            // toastr.info('Something went wrong', 'Info');
                        }
                    });
                } 
            })
            
        }
        function reject_order(orderid){
            Swal.fire({
                title: 'Do you want to Reject This Order',
                
                showCancelButton: true,
                confirmButtonText: 'Save',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route('app.restaurant.order.reject')}}',
                        type: 'post',
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "order_id": orderid
                        },
                        success: function (data) {
                            console.log(data.status);
                            if(data.status == true){
                                Swal.fire('Great job!',data.message,'success');
                                $(".order_container_"+orderid+"").remove();

                            }else{
                                Swal.fire({icon: 'error',title: 'Oops...',text: data.error,})
                            }
                            
                        },
                        error: function (xhr, textStatus, thrownError) {
                            // toastr.info('Something went wrong', 'Info');
                        }
                    });
                } 
            })
            
        }
        function viewProduct(orderid){
            
            var html = $('.product_container_'+orderid+'').html();
            console.log(html);
            $(".product_viewer").html(html);
            
        }
    </script>
@endpush

