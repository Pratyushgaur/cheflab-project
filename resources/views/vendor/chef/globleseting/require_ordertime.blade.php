@extends('vendor.chefs-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            {{-- <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>
                        <li class="breadcrumb-item"><a href="#">chef Location</a></li>
                    </ol>
                </nav>
            </div> --}}
            <div class="col-xl-2"></div>
            <div class="col-xl-8 col-md-8 ">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>chef Essential Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row ">

                            <div class="col-md-12">
                                <nav aria-label = "breadcrumb">
                                    <ol class = "breadcrumb breadcrumb-arrow has-gap has-bg">
                                        <li class = "breadcrumb-item"><a href = "{{route('chef.require.ordertime')}}">chef Timing</a></li>
                                        <li class = "breadcrumb-item active"><a href = "{{route('chef.globleseting.frist_vendor_location')}}">Location</a></li>
                                        <li class = "breadcrumb-item active"><a href = "{{route('chef.globleseting.first_vendor_logo')}}">Logo And Banner</a></li>
                                        <li class = "breadcrumb-item active"><a href = "{{route('chef.globleseting.first_bank_details')}}">Bank Details</a></li>
                                    </ol>
                                </nav>

                                <form class="validation-fill clearfix ms-form-wizard style1-wizard " id="order_time_form"
                                    action="{{ route('chef.ordertime.first_store') }}" method="post">
                                    @csrf


                                    {{-- Order time form start --}}
                                    @include('vendor.chef.globleseting.order_time_fields')

                                    <div class="form-row">
                                        <div class="col-md-6 mb-6"></div>
                                        <div class="col-md-6 mb-6">
                                            <button class="btn btn-primary" type="submit" style="float: right">Submit &
                                                Next</button>
                                        </div>
                                    </div>

                                    {{-- Order time form end --}}

                                </form>

                            </div>


                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-2"></div>



        </div>
    </div>
@endsection

@push('scripts')

<script>

function run_first(){
            $(".start_time").each(function() {
                    if ($(this).val() == '' ) {
                        $("#available_" + $(this).attr('data-item-id')).val(0);
                    }

                });

        }
    (function($) {

        {{-- run_first(); --}}

    })(jQuery);
</script>
@endpush
