@extends('vendor.chefs-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>
                        <li class="breadcrumb-item"><a href="#">Order Time</a></li>
                    </ol>
                </nav>
            </div>

            @include('vendor.chef.globleseting.setting_menu')

            <div class="col-md-9">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6>Order Time Setting</h6>
                    </div>
                    <div class="ms-panel-body">

                            @include('vendor.chef.alertMsg')
                            {{-- Order time form start --}}
                        {!! Form::model($bankDetail, ['route' => ['chef.globleseting.save_bank_details'],'method' => 'post','enctype'=>"multipart/form-data",
'class'=>"validation-fill clearfix ", 'id'=>"menu-form"]) !!}
                        @csrf

                        @include('vendor.chef.globleseting.bank_details_fields')

                            <div class="form-row">
                                <div class="col-md-6 mb-6"></div>
                                <div class="col-md-6 mb-6">
                                    <button class="btn btn-primary" type="submit" style="float: right">Submit </button>
                                </div>
                            </div>

                            {{-- Order time form end --}}

                        </form>
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection
