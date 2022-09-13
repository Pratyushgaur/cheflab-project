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
                        <li class="breadcrumb-item"><a href="#">Restaurant Location</a></li>
                    </ol>
                </nav>
            </div> --}}

            <div class="col-xl-6 col-md-6">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Restaurant Essential Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row">

                            <div class="col-md-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-arrow has-gap has-bg">
                                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i>
                                                Restaurant Timing</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Location</li>
                                    </ol>
                                </nav>

                                <form class="validation-fill clearfix " id="menu-form"
                                    action="{{ route('restaurant.globleseting.frist_save_vendor_location') }}" method="post">
                                    @csrf

                                    {{-- Location form start --}}
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label>Restaurent Latitude</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="Restaurent Latitude"
                                                    step="0.000001" name="lat"
                                                    value="{{ number_format(@$Vendor->lat, 6) }}">
                                                @if ($errors->has('lat'))
                                                    <span class="ms-text-danger">
                                                        <strong>{{ $errors->first('lat') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label>Restaurent Longitude</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="Restaurent Latitude"
                                                    step="0.000001" name="long"
                                                    value="{{ number_format(@$Vendor->long, 6) }}">
                                                @if ($errors->has('long'))
                                                    <span class="ms-text-danger">
                                                        <strong>{{ $errors->first('long') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Location form end --}}

                                    <div class="form-row">
                                        <div class="col-md-6 mb-6">
                                        <a class="btn btn-light " href="{{route('restaurant.require.ordertime')}}" >Back</a>
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
        </div>
    @endsection
