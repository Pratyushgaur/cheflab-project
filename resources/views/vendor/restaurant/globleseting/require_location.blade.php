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
                                                    value="" readonly><br>
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
                                                    value="" readonly><br>
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
    @section('page-js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=en&region=GB" async defer></script>
    <script>
        // function initialize() {

        //     $('form').on('keyup keypress', function(e) {
        //         var keyCode = e.keyCode || e.which;
        //         if (keyCode === 13) {
        //             e.preventDefault();
        //             return false;
        //         }
        //     });
        //     const locationInputs = document.getElementsByClassName("map-input");

        //     const autocompletes = [];
        //     const geocoder = new google.maps.Geocoder;
        //     for (let i = 0; i < locationInputs.length; i++) {

        //         const input = locationInputs[i];
        //         const fieldKey = input.id.replace("-input", "");
        //         const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

        //         const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || 51.5073509;
        //         const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || -0.12775829999998223;

        //         const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
        //             center: {
        //                 lat: latitude,
        //                 lng: longitude
        //             },
        //             zoom: 13
        //         });
        //         const marker = new google.maps.Marker({
        //             map: map,
        //             position: {
        //                 lat: latitude,
        //                 lng: longitude
        //             },
        //         });

        //         marker.setVisible(isEdit);

        //         const autocomplete = new google.maps.places.Autocomplete(input);
        //         autocomplete.key = fieldKey;
        //         autocompletes.push({
        //             input: input,
        //             map: map,
        //             marker: marker,
        //             autocomplete: autocomplete
        //         });
        //     }

        //     for (let i = 0; i < autocompletes.length; i++) {
        //         const input = autocompletes[i].input;
        //         const autocomplete = autocompletes[i].autocomplete;
        //         const map = autocompletes[i].map;
        //         const marker = autocompletes[i].marker;

        //         google.maps.event.addListener(autocomplete, 'place_changed', function() {
        //             marker.setVisible(false);
        //             const place = autocomplete.getPlace();

        //             geocoder.geocode({
        //                 'placeId': place.place_id
        //             }, function(results, status) {
        //                 if (status === google.maps.GeocoderStatus.OK) {
        //                     const lat = results[0].geometry.location.lat();
        //                     const lng = results[0].geometry.location.lng();
        //                     setLocationCoordinates(autocomplete.key, lat, lng);
        //                 }
        //             });

        //             if (!place.geometry) {
        //                 window.alert("No details available for input: '" + place.name + "'");
        //                 input.value = "";
        //                 return;
        //             }

        //             if (place.geometry.viewport) {
        //                 map.fitBounds(place.geometry.viewport);
        //             } else {
        //                 map.setCenter(place.geometry.location);
        //                 map.setZoom(17);
        //             }
        //             marker.setPosition(place.geometry.location);
        //             marker.setVisible(true);

        //         });
                

        //     }
        // }
        // function setLocationCoordinates(key, lat, lng) {
        //     const latitudeField = document.getElementById(key + "-" + "latitude");
        //     const longitudeField = document.getElementById(key + "-" + "longitude");
        //     latitudeField.value = lat;
        //     longitudeField.value = lng;
        // }

        function initialize(){
            var map = new google.maps.Map(document.getElementById('address-map'),{
                center:{
                    lat:51.5073509,
                    lng:-0.12775829999998223
                },
                zoom:15
                
            });
            var marker = new google.maps.Marker({
                position:{
                    lat:51.5073509,
                    lng:-0.12775829999998223
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
