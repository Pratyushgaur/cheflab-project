{{-- @once --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success" role="alert">
    {{ Session::get('success') }}.
</div>
@endif
@if (Session::has('message'))
<div class="alert alert-info" role="alert">
    {{ Session::get('message') }}.
</div>
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
@endforeach
@endif --}}




@push('scripts')

    @if (Session::has('notice'))
        <script>
            (function ($) {
                Swal.fire({
                        // position: 'top-end',
                        type: 'warning',
                        title: "{{ Session::get('notice') }}",
                        showConfirmButton: true,
                        // timer: 15000
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
                    // timer: 15000
                }
            );
        })(jQuery);
    </script>
@endif

    <script>
        (function ($) {
            'use strict';

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "50000",
                "extendedTimeOut": "10000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }


            @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}', 'Success');
            @endif
            @if (Session::has('message'))
            toastr.info('{{ Session::get('message') }}', 'Info');
            @endif
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            toastr.info('{{ $error }}', 'Danger');
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
