@extends('vendor.restaurants-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            {{-- <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>
                        <li class="breadcrumb-item"><a href="#">Chef Location</a></li>
                    </ol>
                </nav>
            </div> --}}
            <div class="col-xl-3"></div>
            <div class="col-xl-6 col-md-6 ">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Chef Essential Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row ">

                            <div class="col-md-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-arrow has-gap has-bg">
                                        
                                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i>
                                        Chef Timing</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Location</li>
                                        <li class="breadcrumb-item active">Profile Picture</li>
                                    </ol>
                                </nav>


                                <form class="validation-fill clearfix ms-form-wizard style1-wizard " id="order_time_form" action="{{ route('chef.ordertime.first_store') }}" method="post">
                                    @csrf


                                    {{-- Order time form start --}}
                                    @include('vendor.restaurant.globleseting.order_time_fields')

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

            <div class="col-xl-3"></div>



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
