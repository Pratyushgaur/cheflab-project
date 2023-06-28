<main class="body-content">
    <!-- Navigation Bar -->

    <nav class="navbar ms-navbar">

        <div class="ms-aside-toggler ms-toggler pl-0" >
            
        </div>


        <div class="logo-sn logo-sm ms-d-block-sm">
            <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="{{route("app.restaurant.dashboard")}}"><img src="{{ asset('commonarea') }}/logo.png" style="height: 70px;" alt="logo"> </a>
        </div>


        @if (!isset($hideSidebar))
            

            <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" >
                 <!-- <a href="#" ><b class="flaticon-shut-down mr-2" ></b></a> -->
                 <a class="media fs-14 p-2" href="http://127.0.0.1:8000/vendor-logout"> <span><i class="flaticon-shut-down mr-2"></i> Logout</span>
                            </a>
            </div>
            
        @endif
    </nav>

    @include('vendor.restaurant.alertMsg')
    @yield('main-content')


</main>


{{-- Restaurant online off line Model form start --}}

<div class="modal fade" id="modal-10" tabindex="-1" role="dialog" aria-labelledby="modal-10">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title has-icon ms-icon-round "><i class="flaticon-share bg-primary text-white"></i>
                    Restaurant Status</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <form id="restaurent-offline-form" method="POST" {{-- action="{{ route('restaurant.set_offline') }}" --}}>
                @csrf

                <div class="modal-body">
                    <p><code>Restaurant Offline : </code> Rastaurant will not show in mobile app and you will not able
                        to
                        get orders during offline. </p>

                    <label>
                        <input type="radio" name="offline_till" value="1" checked>
                        The next working day , automatically restaurant goes online. </label>
                    <br>
                    <label><input type="radio" name="offline_till" value="2">
                        Manually, i will set it online. </label>

                    <input type="hidden" name="ma" value="1">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary shadow-none" onclick="submit_offline()">Go
                        Offline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Restaurant online off line Model form End --}}



@push('scripts')
    <script>
        // function rest_status() {
        //     alert('xcxgfd');
        //     $.ajax({
        //         url: '{{ route('restaurant.restaurent_status') }}',
        //         type: 'post',
        //         cache: false,
        //         data: $('#restaurent-status-form').serialize(),
        //         success: function(data) {


        //             if (data.msg != ''){
        //                 $("#restaurent_status").val(data.rest_status);
        //                 // alert(data.msg);
        //                 toastr.success(data.msg, 'Success');
        //             }
        //             else
        //                 alert('Somethin went wrong');
        //         },
        //         error: function(xhr, textStatus, thrownError) {
        //             alert('Somethin went wrong');
        //         }
        //     });
        // }

        function change_rest_ststus() {
            // alert($("#restaurent_status").prop("checked"));
            if (!$("#restaurent_status").prop("checked")) {
                $('#modal-10').modal('show');
            } else {
                $.ajax({
                    url: '{{ route('restaurant.restaurent_status') }}',
                    type: 'post',
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        restaurent_status: 'on'
                    },
                    success: function (data) {

                        if (data.msg != '') {
                            $("#restaurent_status").val(data.rest_status);
                            // toastr.success(data.msg, 'Success');
                            Swal.fire({
                                // position: 'top-end',
                                type: 'success',
                                title: data.msg,
                                showConfirmButton: true,
                                timer: 15000
                            });
                            $('#message-box').removeClass('show').dequeue();
                        } else
                            toastr.info('Somethin went wrong', 'Info');

                    },
                    error: function (xhr, textStatus, thrownError) {
                        toastr.info('Somethin went wrong', 'Info');
                    }
                });
            }
        }

        function submit_offline() {

            $.ajax({
                url: '{{ route('restaurant.set_offline') }}',
                type: 'post',
                cache: false,
                data: $('#restaurent-offline-form').serialize(),
                success: function (data) {

                    if (data.msg != '') {
                        $("#restaurent_status").val(data.rest_status);

                        // toastr.success(data.msg, 'Success');
                        Swal.fire({
                            // position: 'top-end',
                            type: 'success',
                            title: data.msg,
                            showConfirmButton: true,
                            timer: 15000
                        });
                        $('#modal-10').modal('hide');
                    } else
                        alert('Somethin went wrong');
                },
                error: function (xhr, textStatus, thrownError) {
                    alert('Somethin went wrong');
                }
            });
        }

        //on modal close
        $('#modal-10').on('hidden.bs.modal', function () {
            // do something…
            $.ajax({
                url: '{{ route('restaurant.restaurent_get_status') }}',
                type: 'get',
                cache: false,
                success: function (data) {
                    if (data.rest_status == 1) {
                        $("#restaurent_status").prop("checked", 'cheked');
                    } else
                        $("#restaurent_status").prop("checked", false);
                },
                error: function (xhr, textStatus, thrownError) {
                    toastr.info('Somethin went wrong', 'Info');
                }
            });
        });
    </script>



    {{-- restaurant offline msg on top bar  --}}
    <script>
        $('#message-box').addClass('show').delay(15000000).queue(function () {
            $(this).removeClass('show').dequeue();
        });
        $("#close_msg_bar").click(function () {
            $('#message-box').removeClass('show').dequeue();

        });
    </script>
@endpush
