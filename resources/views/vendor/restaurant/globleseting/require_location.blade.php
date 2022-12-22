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
                                        <li class = "breadcrumb-item active"><a href = "{{route('restaurant.globleseting.first_vendor_logo')}}">Logo And Banner</a></li>
                                        <li class = "breadcrumb-item active"><a href = "{{route('restaurant.globleseting.first_bank_details')}}">Bank Details</a></li>
                                    </ol>
                                </nav>

                                <form class="validation-fill clearfix " id="menu-form"
                                    action="{{ route('restaurant.globleseting.frist_save_vendor_location') }}" method="post">
                                    @csrf

                                    {{-- Location form start --}}
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label>Location</label>
                                            <div class="input-group">
                                                <input type="text" id="address-input" name="location" class="form-control map-input" value="" >
                                            </div>

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div id="address-map-container" style="width:100%;height:400px; ">
                                                <div style="width: 100%; height: 100%" id="address-map"></div>
                                                <input type="hidden" name="address_latitude" id="" value="{{ old('address_latitude') ?? '0' }}" />
                                                <input type="hidden" name="address_longitude" id="" value="{{ old('address_longitude') ?? '0' }}" />
                                            </div>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Restaurent Latitude</label>
                                            <div class="input-group">
                                                <input id="address-latitude" type="text" class="form-control" placeholder="Latitude"
                                                    step="" name="lat"
                                                    value="" readonly required><br>
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
                                                <input id="address-longitude" type="text" class="form-control" placeholder="Latitude"
                                                    step="" name="long"
                                                    value="" readonly required><br>
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
            <div class="col-xl-2"></div>
        </div>
    @endsection
    @section('page-js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>
    <script>

        function initialize(){
            var map = new google.maps.Map(document.getElementById('address-map'),{
                center:{
                    lat:24.462200,
                    lng:74.850403
                },
                zoom:15

            });
            var marker = new google.maps.Marker({
                position:{
                    lat:24.462200,
                    lng:74.850403
                },
                map:map,
                draggable:true
            });
            var searchBox = new google.maps.places.SearchBox(document.getElementById("address-input"));
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('address-input'));

            google.maps.event.addListener(searchBox, 'places_changed', function(event) {
                searchBox.set('map', null);



                var places = searchBox.getPlaces();

                setLocationCoordinates(places[0].geometry.location.lat(),places[0].geometry.location.lng());
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0; place = places[i]; i++) {
                (function(place) {
                    var marker = new google.maps.Marker({

                        position: place.geometry.location,
                        draggable:true


                    });
                    marker.bindTo('map', searchBox, 'map');
                    google.maps.event.addListener(marker,'dragend',function(event) {
                        setLocationCoordinates(event.latLng.lat(),event.latLng.lng());
                    });
                    google.maps.event.addListener(marker, 'map_changed', function() {
                    if (!this.getMap()) {
                        this.unbindAll();
                    }
                    });

                    bounds.extend(place.geometry.location);


                }(place));




                }
                map.fitBounds(bounds);
                searchBox.set('map', map);
                map.setZoom(Math.min(map.getZoom(),15));

            });
            google.maps.event.addListener(marker,'dragend',function(event) {
                setLocationCoordinates(event.latLng.lat(),event.latLng.lng());
            });
            function setLocationCoordinates( lat, lng) {
                const latitudeField = document.getElementById("address-latitude");
                const longitudeField = document.getElementById("address-longitude");
                latitudeField.value = lat;
                longitudeField.value = lng;
            }
        }

    </script>
@endsection
