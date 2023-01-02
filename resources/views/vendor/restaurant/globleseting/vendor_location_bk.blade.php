@extends('vendor.restaurants-layout')
@section('main-content')
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Global Setting</a></li>
                        <li class="breadcrumb-item"><a href="#">Order Time</a></li>
                    </ol>
                </nav>
            </div>

            @include('vendor.restaurant.globleseting.setting_menu')

            <div class="col-md-9">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6>Order Time Setting</h6>
                    </div>
                    <div class="ms-panel-body">
                        @include('vendor.restaurant.alertMsg')

                        <form class="validation-fill clearfix " id="menu-form" action="{{ route('restaurant.globleseting.vendor_location')}}" method="post">
                            @csrf

                             {{-- Location form start --}}
                             <div class="form-row">
                                <div class="col-md-12 mb-3">
                                  <label>Restaurent Latitude</label>
                                  <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Restaurent Latitude" step="0.000001" name="lat" value="{{number_format(@$Vendor->lat,6)}}">
                                    @if ($errors->has('lat'))
                                            <span class="ms-text-danger">
                                                <strong>{{ $errors->first('lat') }}</strong>
                                            </span>
                                        @endif
                                  </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                  <label>Restaurent Longitude</label>
                                  <div class="input-group">
                                    <input type="number" class="form-control" placeholder="Restaurent Latitude" step="0.000001" name="long"  value="{{number_format(@$Vendor->long,6)}}">
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
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection
