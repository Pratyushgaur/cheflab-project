@extends('admin.layouts.layoute')

@section('page-style')
    <style type="text/css">
        
        #map { height: 500px; }
    </style>
    
    
@endsection
@section('js_section')
    <script src="https://www.gstatic.com/firebasejs/3.2.0/firebase.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
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
            
            const database = firebase.database();
            let c_markers = {};
            //c_markers = {"1002":{driver_id:1,lat:2}};
            let driverid;
        
            let map;
            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    center: { lat: 22.715021193131072, lng: 75.85764960023467 },
                    zoom: 13,
                });

                database.ref('locations').on('value', (snapshot) => {
                    snapshot.forEach(element => {
                        if(element.val().driver_id){
                            var uniqueId =element.val().driver_id;
                            if (!c_markers[uniqueId] || !c_markers[uniqueId].setPosition) {
                                if(element.val().driver_have_order == "1"){
                                    url = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                                }else{
                                    url = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
                                }
                                var planeIcon = new google.maps.Marker({
                                    position: {lat:element.val().lat,lng:element.val().long},
                                    map: map,
                                    title: "Testing-"+element.val().driver_id,
                                    uniqueId: uniqueId,
                                    displayCnt: 0,
                                    icon:{
                                        url: url,
                                        //scaledSize: new google.maps.Size(40, 40),
                                    }
                                });
                                var infowindow = new google.maps.InfoWindow();
                                infowindow.setContent(element.val().driver_id);
                                infowindow.open(map, planeIcon);
                                c_markers[uniqueId] = planeIcon;
                            }else{
                                c_markers[uniqueId].setPosition({lat:element.val().lat,lng:element.val().long});
                                //planesArray[uniqueId].displayCnt++;
                                
                            }
                        }
                        
                        
                        
                    });
                    
                });
            }
            window.initMap = initMap;
        })
        
        
    </script>
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
                                        <div id="map"></div>
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
