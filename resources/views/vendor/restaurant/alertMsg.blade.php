@push('scripts')
    <script>
        (function(w) {

            {{--'use strict';--}}

            {{--var toasty = new Toasty({--}}
            {{--    transition: "fade",--}}
            {{--    duration: 0, // calculated automatically.--}}
            {{--    enableSounds: true,--}}
            {{--    sounds: {--}}
            {{--        // path to sound for informational message:--}}
            {{--        info: "{{ asset('frontend/assets/toasty/sounds/info/1.mp3') }}",--}}
            {{--        // path to sound for successfull message:--}}
            {{--        success: "{{ asset('frontend/assets/toasty/sounds/info/1.mp3') }}",--}}
            {{--        // path to sound for warn message:--}}
            {{--        warning: "{{ asset('frontend/assets/toasty/sounds/info/1.mp3') }}",--}}
            {{--        // path to sound for error message:--}}
            {{--        error: "{{ asset('frontend/assets/toasty/sounds/info/1.mp3') }}",--}}
            {{--    },--}}

            {{--    progressBar: true,--}}
            {{--    autoClose: true--}}

            {{--});--}}

            {{--// var tran = document.getElementById('select-transition');--}}
            {{--// var btns = document.querySelectorAll('.btn-example');--}}
            {{--// var down = document.getElementById('action-download');--}}
            {{--// var auto_refresh = setInterval(--}}
            {{--//     function () {--}}
            {{--//         toasty.info("sdfsdfdfsd", 10000000);--}}
            {{--//     }, 3000); // refresh every 10000 milliseconds--}}
            const playSound = (url) => {
                const audio = new Audio(url);
                audio.play();
            }
            {{--playSound('{{url("/notification-sound.mp3")}}');--}}
            {{--setTimeout(() => {--}}
            {{--    playSound('{{url("/notification-sound.mp3")}}');--}}
            {{--}, 1000);--}}

            {{--var auto_refresh = setInterval(--}}
            {{--    function () {--}}
            {{--        playSound('{{url("/notification-sound.mp3")}}');--}}
            {{--    }, 3000); // refresh every 10000 milliseconds--}}

        })(window);

    </script>
    @if (Session::has('notice'))
        <script>
            (function ($) {
                Swal.fire({
                        // position: 'top-end',
                        type: 'warning',
                        title: "{{ Session::get('notice') }}",
                        showConfirmButton: true,
                        timer: 5000
                    }
                );
                playSound('{{url("/notification-sound.mp3")}}');

            })(jQuery);
        </script>
    @endif

    @if (Session::has('poup_success'))
        <script>
            (function ($) {
                Swal.fire({
                        // position: 'top-end',
                        type: 'success',
                        title: "{{ Session::get('poup_success') }}",
                        showConfirmButton: true,
                        timer: 5000
                    }
                );
                playSound('{{url("/notification-sound.mp3")}}');

            })(jQuery);
        </script>
    @endif

    <script>
        // appending HTML5 Audio Tag in HTML Body
        {{--$('<audio id="chatAudio" controls autoplay><source  id="chatAudio1" src="{{url('/notification-sound.mp3')}}" type="audio/mpeg"></audio>').appendTo('body');--}}

        {{--// play sound--}}
        {{--$('#chatAudio')[0].play();--}}

        (function ($) {
            'use strict';

            toastr.options =
                {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-left",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "5000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
            // toastr.info('fdgdfg', 'Info');
            // document.getElementById('chatAudio1').play();
{{--            $.playSound('{{url('/public/notification-sound.mp3')}}');--}}
            @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}', 'Danger');
            playSound('{{url("/notification-sound.mp3")}}');

            @endif

            @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}', 'Success');
            playSound('{{url("/notification-sound.mp3")}}');

            @endif
            @if (Session::has('message'))
            toastr.info('{{ Session::get('message') }}', 'Info');
            playSound('{{url("/notification-sound.mp3")}}');

            @endif
            @if ($errors->any())
            playSound('{{url("/notification-sound.mp3")}}');

            @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}', 'Danger');
            @endforeach
            @endif
            $("#clearToast").on('click', function () {
                    toastr.remove();
                }
            );

        })(jQuery);
    </script>
@endpush
{{-- @endonce --}}
