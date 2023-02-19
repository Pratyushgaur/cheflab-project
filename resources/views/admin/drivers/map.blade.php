@extends('admin.layouts.layoute')

@section('page-style')
    <style type="text/css">
        #mapContainer {
            height: 100vh;
        }

        #mapCanvas {
            width: 100%;
            height: 100%;
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/3.2.0/firebase.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyC0XTAcHDhk-YzguedH8yjg4hkRRNoi94k",
            authDomain: "cheflab-user.firebaseapp.com",
            databaseURL: "https://cheflab-user-default-rtdb.firebaseio.com",
            projectId: "cheflab-user",
            storageBucket: "cheflab-user.appspot.com",
            messagingSenderId: "180746879110",
            appId: "1:180746879110:web:8440a4aab32734182e5107",
            measurementId: "G-CGNPVL7FKZ"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const database = firebase.database()

        // Initialize and add the map
        function initMap() {
            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                mapTypeId: 'roadmap',
                "styles": [{
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "poi.business",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "labels",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [{
                            "visibility": "off"
                        }]
                    }
                ]
            };

            // Display a map on the web page
            map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
            map.setTilt(50);

            // Add multiple markers to map
            var infoWindow = new google.maps.InfoWindow(),
                marker, i;

            let markers = []
            // // Place each marker on the map
            map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
            const markerArray = [];

            database.ref('locations').on('value', (snapshot) => {
                const data = snapshot.val();
                console.log('hhihiu');

                markerArray.map(marker => marker.setMap(null));

                Object.values(data).map((mkr) => {
                    var position = new google.maps.LatLng(mkr.lat, mkr.long);
                    bounds.extend(position);

                    const svgMarker = {
                        path: "M280 32c-13.3 0-24 10.7-24 24s10.7 24 24 24h57.7l16.4 30.3L256 192l-45.3-45.3c-12-12-28.3-18.7-45.3-18.7H64c-17.7 0-32 14.3-32 32v32h96c88.4 0 160 71.6 160 160c0 11-1.1 21.7-3.2 32h70.4c-2.1-10.3-3.2-21-3.2-32c0-52.2 25-98.6 63.7-127.8l15.4 28.6C402.4 276.3 384 312 384 352c0 70.7 57.3 128 128 128s128-57.3 128-128s-57.3-128-128-128c-13.5 0-26.5 2.1-38.7 6L418.2 128H480c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32H459.6c-7.5 0-14.7 2.6-20.5 7.4L391.7 78.9l-14-26c-7-12.9-20.5-21-35.2-21H280zM462.7 311.2l28.2 52.2c6.3 11.7 20.9 16 32.5 9.7s16-20.9 9.7-32.5l-28.2-52.2c2.3-.3 4.7-.4 7.1-.4c35.3 0 64 28.7 64 64s-28.7 64-64 64s-64-28.7-64-64c0-15.5 5.5-29.7 14.7-40.8zM187.3 376c-9.5 23.5-32.5 40-59.3 40c-35.3 0-64-28.7-64-64s28.7-64 64-64c26.9 0 49.9 16.5 59.3 40h66.4C242.5 268.8 190.5 224 128 224C57.3 224 0 281.3 0 352s57.3 128 128 128c62.5 0 114.5-44.8 125.8-104H187.3zM128 384c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32z",
                        fillColor: mkr.is_online === 0 ? "gray" : mkr.busy ? "red" : "green",
                        fillOpacity: 1,
                        strokeWeight: 0,
                        rotation: 0,
                        scale: 0.08,
                        anchor: new google.maps.Point(0, 20),
                    };

                    marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        icon: svgMarker,
                        title: "Driver",
                    });
                    markerArray.push(marker)
                    // marker.setMap(null);

                    // Add info window to marker
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infoWindow.setContent(
                                `fetching...`);
                            infoWindow.open(map, marker);

                            fetch(`/admin/drivers/${mkr.driver_id}/info`)
                                .then(res => res.json())
                                .then((data) => {
                                    infoWindow.setContent(`
                                <p><b>(${data.id}) ${data.name}</b></p>
                                <p>Mobile: <b style='cursor:pointer' id='${data.id}'>${data.mobile}</b></p>
                                `);
                                    infoWindow.open(map, marker);
                                    const el = document.getElementById(mkr.driver_id)
                                    el.addEventListener('click', () => {
                                        navigator.clipboard.writeText(data
                                            .mobile)
                                    })
                                })

                        }
                    })(marker, i));

                    // Center the map to fit all markers on the screen
                })
                map.fitBounds(bounds);
            })

        }

        window.initMap = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyDZTUlYkGTFzOHrzqU3Am_bXUNSQIxoURw"
        defer></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid mt-3">
                <section class="home_blogArea">
                    <div class="containerDM-fluid">
                        <div class="demo_pnlouter">
                            <div class="rowDM">
                                <div class="col-lg-12-DM">
                                    <div id="mapContainer">
                                        <div id="mapCanvas"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div><!-- /.container-fluid -->
        </section>



    </div>


    <!-- /.content-wrapper -->
@endsection
