@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="{{route('restaurant.dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item" aria-current="page">Update Password</li>
                    </ol>
                </nav>
            </div>
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <h6>Update Password</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form class=" clearfix " id="menu-form" action="{{route('restaurant.vendor.update_password')}}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="col-xl-12 col-md-12 mb-12">
                                    <label for="validationCustom10">Old Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="old_password" value="" id="validationCustom03" placeholder="Enter Old Password">
                                    </div>
                                    @error('old_password')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-12">
                                    <label for="validationCustom10">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="new_password" value="" id="validationCustom03" placeholder="Enter New Password">
                                    </div>
                                    @error('new_password')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-md-6 mb-12">
                                    <label for="validationCustom10">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="confirm_password" value="" id="validationCustom03" placeholder="Enter Confirm Password">
                                    </div>
                                    @error('confirm_password')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>


                            </div>
                            <button class="btn btn-primary float-right" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
