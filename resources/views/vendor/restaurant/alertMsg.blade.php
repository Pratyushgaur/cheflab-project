@push('scripts')
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
            })(jQuery);
        </script>
    @endif

    <script>
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

            @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}', 'Danger');
            @endif

            @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}', 'Success');
            @endif
            @if (Session::has('message'))
            toastr.info('{{ Session::get('message') }}', 'Info');
            @endif
            @if ($errors->any())
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
