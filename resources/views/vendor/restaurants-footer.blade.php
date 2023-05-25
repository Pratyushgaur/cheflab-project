<!-- 
<audio class="alert-audio" style="display:none" controls >
    <source src="{{asset('fcm_notification_sound.mp3')}}"  type="audio/mpeg">
</audio> -->
<!-- <audio  src="{{asset('fcm_notification_sound.mp3')}}" muted autoplay >></audio> -->


<!-- MODALS -->
<!-- Quick bar -->
<iframe src="assets/img/emos/silence.mp3" type="audio/mp3" allow="autoplay" id="audio" style="display:none"></iframe>
<audio id="beep__hover"    autoplay>
  <source src="{{asset('fcm_notification_sound.mp3')}}" type="audio/mp3">
</audio>
<!-- <audio id="beep__hover" controls  style="display:none;">
  <source src="{{asset('fcm_notification_sound.mp3')}}" type="audio/ogg">
  <source src="{{asset('fcm_notification_sound.mp3')}}" type="audio/mpeg">
  Your browser does not support the audio element.
</audio> -->
<aside id="ms-quick-bar" class="ms-quick-bar fixed ms-d-block-lg">
    <ul class="nav nav-tabs ms-quick-bar-list" role="tablist"></ul>
    <div class="ms-configure-qa" data-toggle="tooltip" data-placement="left" title="Configure Quick Access"></div>
    
</aside>
<!-- Reminder Modal -->
<div class="modal fade" id="reminder-modal" tabindex="-1" role="dialog" aria-labelledby="reminder-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title has-icon text-white"> New Reminder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="ms-form-group">
                        <label>Remind me about</label> <textarea class="form-control" name="reminder"></textarea>
                    </div>
                    <div class="ms-form-group"><span class="ms-option-name fs-14">Repeat Daily</span>
                        <label class="ms-switch float-right"> <input type="checkbox">
                            <span class="ms-switch-slider round"></span> </label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ms-form-group">
                                <input type="text" class="form-control datepicker" name="reminder-date" value=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ms-form-group">
                                <select class="form-control" name="reminder-time">
                                    <option value="">12:00 pm</option>
                                    <option value="">1:00 pm</option>
                                    <option value="">2:00 pm</option>
                                    <option value="">3:00 pm</option>
                                    <option value="">4:00 pm</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Add Reminder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Notes Modal -->
<div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="notes-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title has-icon text-white" id="NoteModal">New Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="ms-form-group">
                        <label>Note Title</label> <input type="text" class="form-control" name="note-title" value="">
                    </div>
                    <div class="ms-form-group">
                        <label>Note Description</label>
                        <textarea class="form-control" name="note-description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<!-- SCRIPTS -->
<!-- Global Required Scripts Start -->
<script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
<script src="{{asset('frontend')}}/assets/js/jquery-3.5.0.min.js"></script>
<script src="{{asset('frontend')}}/assets/js/popper.min.js"></script>
<script src="{{asset('frontend')}}/assets/js/bootstrap.min.js"></script>
<script src="{{asset('frontend')}}/assets/js/perfect-scrollbar.js">
</script>
<script src="{{asset('frontend')}}/assets/js/jquery-ui.min.js"></script>
<!-- Global Required Scripts End -->
<!-- Page Specific Scripts Start -->

<script src="{{asset('frontend')}}/assets/js/Chart.bundle.min.js"></script>
<!-- <script src="{{asset('frontend')}}/assets/js/widgets.js"></script> -->
<script src="{{asset('frontend')}}/assets/js/clients.js"></script>
<script src="{{asset('frontend')}}/assets/js/Chart.Financial.js"></script>
<script src="{{asset('frontend')}}/assets/js/d3.v3.min.js">
</script>
<script src="{{asset('frontend')}}/assets/js/topojson.v1.min.js">
</script>
<script src="{{asset('frontend')}}/assets/js/datatables.min.js">
</script>

<script src="{{asset('frontend')}}/assets/js/sweetalert2.min.js">
</script>
<script src="{{asset('frontend')}}/assets/js/sweet-alerts.js">
</script>

<!-- <script src="{{asset('frontend')}}/assets/js/data-tables.js">
      </script> -->
<!-- Page Specific Scripts Finish -->
<!-- Costic core JavaScript -->
<script src="{{asset('frontend')}}/assets/js/framework.js"></script>
<!-- Settings -->
<script src="{{asset('frontend')}}/assets/js/settings.js"></script>
<!-- <script src="{{asset('frontend')}}/assets/js/jquery.prettyPhoto.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    #toast-container > div {
        opacity: 3 !important;
    }
</style>


<link href="{{ asset('frontend') }}/assets/css/sweetalert2.min.css" rel="stylesheet">
<!-- Page Specific Scripts Start -->
<script src="{{ asset('frontend') }}/assets/js/promise.min.js">
</script>
<script src="{{ asset('frontend') }}/assets/js/sweetalert2.min.js"></script>

<!-- Page Specific Scripts Start -->
<script src="{{ asset('frontend') }}/assets/js/toastr.min.js"></script>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>

{{--
Firebase msg example

https://medium.com/geekculture/laravel-tutorial-push-notification-with-firebase-laravel-9-3095058c2155#:~:text=Push%20Notification%20with%20Laravel%20firebase%20is%20very%20important,are%20using%20or%20the%20browser%20they%20are%20using.--}}
<!-- The core Firebase JS SDK is always required and must be listed first -->
{{--<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>--}}
<!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
@stack('scripts')
@yield('page-js');

@stack('model')

<script>

    $(document).ready(function () {
        //document.getElementById('mybtn').click();
        setInterval(function () {
            //$("#beep__hover").attr('muted',false);
            var audio = document.getElementById("beep__hover");

            audio.play();
        }, 10000);

       
        
        toastr.options =
            {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-left",
                "preventDuplicates": false,
                // "onclick": null,
                "showDuration": "3000",
                "hideDuration": "10000",
                "timeOut": 0,
                "extendedTimeOut": 0,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        if ('serviceWorker' in navigator) {
            window.addEventListener("load", function () {
                // navigator.serviceWorker.register("firebase-messaging-sw.js");
                {{--alert("{{URL::to('/').'/firebase-messaging-sw.js'}}");--}}
                {{--                navigator.serviceWorker.register("{{URL::to('/firebase-messaging-sw.js')}}");--}}
                navigator.serviceWorker.register("{{URL::to('/').'/firebase-messaging-sw.js'}}");
            });

            window.addEventListener('flutter-first-frame', function () {
                navigator.serviceWorker.register('flutter_service_worker.js');
                {{--                navigator.serviceWorker.register('{{URL::to("/")}}flutter_service_worker.js');--}}
            });
        }
        // Your web app's Firebase configuration
        var firebaseConfig = {

            // apiKey: "AIzaSyB_ym9qT9oWdc25CMIjXJVX-Ku6XhrwhnA",
            // authDomain: "chef-leb.firebaseapp.com",
            // databaseURL: "https://chef-leb-default-rtdb.firebaseio.com",
            // projectId: "chef-leb",
            // storageBucket: "chef-leb.appspot.com",
            // messagingSenderId: "307095509147",
            // appId: "1:307095509147:web:c382e5e84230f9a27f8e3e",
            // measurementId: "G-8Y9V6YWCWD"
            // //
            apiKey: "AIzaSyC0XTAcHDhk-YzguedH8yjg4hkRRNoi94k",
            authDomain: "cheflab-user.firebaseapp.com",
            databaseURL: "https://chef-leb-default-rtdb.firebaseio.com",
            projectId: "cheflab-user",
            storageBucket: "cheflab-user.appspot.com",
            messagingSenderId: "180746879110",
            appId: "1:180746879110:web:8440a4aab32734182e5107",
            measurementId: "G-CGNPVL7FKZ"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function () {
                return messaging.getToken()
            }).then(function (token) {

                axios.post("{{ route('fcmToken_vendor') }}", {
                    _method: "PATCH",
                    token
                }).then(({data}) => {
                    console.log(data);
                }).catch(({response: {data}}) => {
                    console.error(data)
                })

            }).catch(function (err) {

                console.log(`Token Error :: ${err}`);
            });
        }

        initFirebaseMessagingRegistration();

        messaging.onMessage((payload) => {
            console.log(payload);
            new Notification(payload.notification.title, {body: payload.notification.body});
            if (payload.data.link === void 0) {
                toastr.info(payload.notification.title, payload.notification.body);

            } else {
                toastr.options.onclick = function () {
                    var win = window.open(payload.data.link);
                    console.log('clicked');
                }

                toastr.info(payload.notification.body + ' <br/><a class="btn-dark btn-sm" style="float: right;padding: 14px !important;" href="#">View</a>', payload.notification.title,);

            }
            var audio = document.getElementById("beep__hover");
            audio.play();
        });
    });
</script>

</body>
</html>
