@extends('vendor.restaurants-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class = "ms-content-wrapper">
        <div class = "row">
            <div class = "col-xl-2"></div>
            <div class = "col-xl-8 col-md-8">
                <div class = "ms-panel ms-panel-fh">
                    <div class = "ms-panel-header">
                        <h6>Restaurant Essential Setting</h6>
                    </div>
                    <div class = "ms-panel-body">
                        <div class = "row">

                            <div class = "col-md-12">
                                <nav aria-label = "breadcrumb">
                                    <ol class = "breadcrumb breadcrumb-arrow has-gap has-bg">
                                        <li class = "breadcrumb-item"><a href = "{{route('restaurant.require.ordertime')}}">Restaurant Timing</a></li>
                                        <li class = "breadcrumb-item"><a href = "{{route('restaurant.globleseting.frist_vendor_location')}}">Location</a></li>
                                        <li class = "breadcrumb-item"><a href = "{{route('restaurant.globleseting.first_vendor_logo')}}">Logo And Banner</a></li>
                                        <li class = "breadcrumb-item active"><a href = "{{route('restaurant.globleseting.first_bank_details')}}">Bank Details</a></li>
                                    </ol>
                                </nav>
                                {!! Form::model($bankDetail, ['route' => ['restaurant.globleseting.first_save_bank_details'],'method' => 'post','enctype'=>"multipart/form-data",
'class'=>"validation-fill clearfix ", 'id'=>"menu-form"]) !!}
                                @csrf

                                @include('vendor.restaurant.globleseting.bank_details_fields')
                                <div class="form-row">
                                    <div class="col-mdma-6 mb-6">
                                        <a class="btn btn-light " href="{{route('restaurant.require.ordertime')}}">Back</a>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <button class="btn btn-primary" type="submit" style="float: right">Submit</button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>





            </div>
            <div class = "col-xl-2"></div>
        </div>
@endsection

