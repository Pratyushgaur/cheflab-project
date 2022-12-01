<main class="body-content">
    <!-- Navigation Bar -->

    <nav class="navbar ms-navbar">

        <div class="ms-aside-toggler ms-toggler pl-0" data-target="#ms-side-nav" data-toggle="slideLeft">
            @if (!isset($hideSidebar))
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
            @endif
        </div>


        <div class="logo-sn logo-sm ms-d-block-sm">
            <a class="pl-0 ml-0 text-center navbar-brand mr-0" href="{{route("restaurant.dashboard")}}"><img src="{{ asset('commonarea') }}/logo.png" style="height: 70px;" alt="logo"> </a>
        </div>


        @if (!isset($hideSidebar))
            <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
                <li class="ms-nav-item ms-search-form pb-0 py-0">
                    {{-- <form id="restaurent-status-form" action="" method="POST">
                        @csrf

                        <div class="ms-form-group my-0 mb-0 has-icon fs-14">
                            <label> Rastaurant Status </label>
                            <label class="ms-switch right"> <input name="restaurent_status" id="restaurent_status"
                                    onchange='change_rest_ststus()' type="checkbox"
                                    @if (Auth::guard('vendor')->user()->is_online == 1) checked @endif>
                                <span class="ms-switch-slider round"></span> </label>

                        </div>

                    </form> --}}

                </li>


                <!-- <li class="ms-nav-item ms-search-form pb-0 py-0">
                    <form class="ms-form" method="post">
                        <div class="ms-form-group my-0 mb-0 has-icon fs-14">
                            <input type="search" class="ms-form-input" name="search" placeholder="Search here..."
                                   value=""> <i class="flaticon-search text-disabled"></i>
                        </div>
                    </form>
                </li> -->
            <!-- <li class="ms-nav-item ms-search-form pb-0 py-0 pc-offline-block">
                    <label class="ms-switch right" style="float: right">
                        <input name="restaurent_status" id="restaurent_status" type="checkbox"
                                value="1" onchange='change_rest_ststus()'
                                @if (Auth::guard('vendor')->user()->is_online == 1) checked @endif>
                        <span class="ms-switch-slider"></span>
                    </label>
                </li> -->


{{--                <li class="ms-nav-item dropdown"><a href="#" class="text-disabled ms-has-notification"--}}
{{--                                                    id="mailDropdown" data-toggle="dropdown" aria-haspopup="true"--}}
{{--                                                    aria-expanded="false"><i--}}
{{--                            class="flaticon-mail"></i></a>--}}
{{--                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="mailDropdown">--}}
{{--                        <li class="dropdown-menu-header">--}}
{{--                            <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Mail</span></h6><span--}}
{{--                                class="badge badge-pill badge-success">3 New</span>--}}
{{--                        </li>--}}
{{--                        <li class="dropdown-divider"></li>--}}
{{--                        <li class="ms-scrollable ms-dropdown-list">--}}
{{--                            <a class="media p-2" href="#">--}}
{{--                                <div class="ms-chat-status ms-status-offline ms-chat-img mr-2 align-self-center">--}}
{{--                                    <img src="{{ asset('frontend') }}/assets/img/costic/customer-3.jpg"--}}
{{--                                         class="ms-img-round" alt="people">--}}
{{--                                </div>--}}
{{--                                <div class="media-body"><span>Hey man, looking forward to your new project.</span>--}}
{{--                                    <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 30--}}
{{--                                        seconds--}}
{{--                                        ago</p>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a class="media p-2" href="#">--}}
{{--                                <div class="ms-chat-status ms-status-online ms-chat-img mr-2 align-self-center">--}}
{{--                                    <img src="{{ asset('frontend') }}/assets/img/costic/customer-2.jpg"--}}
{{--                                         class="ms-img-round" alt="people">--}}
{{--                                </div>--}}
{{--                                <div class="media-body"> <span>Dear John, I was told you bought Costic! Send me your--}}
{{--                                        feedback</span>--}}
{{--                                    <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 28--}}
{{--                                        minutes--}}
{{--                                        ago</p>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <a class="media p-2" href="#">--}}
{{--                                <div class="ms-chat-status ms-status-offline ms-chat-img mr-2 align-self-center">--}}
{{--                                    <img src="{{ asset('frontend') }}/assets/img/costic/customer-1.jpg"--}}
{{--                                         class="ms-img-round" alt="people">--}}
{{--                                </div>--}}
{{--                                <div class="media-body"><span>How many people are we inviting to the dashboard?</span>--}}
{{--                                    <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 6--}}
{{--                                        hours--}}
{{--                                        ago</p>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="dropdown-divider"></li>--}}
{{--                        <li class="dropdown-menu-footer text-center"><a href="pages/apps/email.html">Go to Inbox</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <?php
                $user = Auth::guard('vendor')->user();
                $count = count($user->unreadNotifications);
                ?>
                <li class="ms-nav-item dropdown">
                    <a href="#" class="text-disabled {{($count>0) ? "ms-has-notification" : '' }}" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="flaticon-bell"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">

                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Notifications</span>
                            </h6><span class="badge badge-pill badge-info">{{ $count }} New</span>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="ms-scrollable ms-dropdown-list">

                            <?php

                            foreach ($user->unreadNotifications as $notification) {
                            ?>
                            <a class="media p-2" href="#">
                                <div class="media-body"><span> <?php echo @$notification->data['msg']; ?></span>
                                    <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i>
                                        {{get_time_ago(strtotime($notification->created_at))}}</p>
                                </div>
                            </a>

                            <?php } ?>

                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-menu-footer text-center"><a href="{{route('notification.view')}}">View all Notifications</a>
                        </li>
                    </ul>
                </li>

                <li class="ms-nav-item ms-nav-user dropdown">
                    <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <img class="ms-user-img ms-img-round float-right"
                             src="{{ (file_exists(public_path('vendors').DIRECTORY_SEPARATOR.\Auth::guard('vendor')->user()->image)) ? URL::to('vendors/') . '/' .\Auth::guard('vendor')->user()->image :  asset('frontend')."/assets/img/costic/customer-3.jpg" }}" alt="people">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown">
                        <li class="dropdown-menu-header">
                            <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">Welcome,
                                    {{ ucfirst(Auth::guard('vendor')->user()->name) }}</span></h6>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="ms-dropdown-list">
                            <a class="media fs-14 p-2">
                                <span><i class="flaticon-gear mr-2"></i> Status</span>
                                <label class="ms-switch right mobile-offline-block" style="float: right">
                                    <input name="restaurent_status" id="restaurent_status" type="checkbox"
                                           value="1" onchange='change_rest_ststus()'
                                           @if (Auth::guard('vendor')->user()->is_online == 1) checked @endif>
                                    <span class="ms-switch-slider"></span>
                                </label>


                            </a>


                            <a class="media fs-14 p-2" href="{{route('restaurant.profile')}}"> <span><i
                                        class="flaticon-user mr-2"></i> Profile</span>
                            </a>


                            {{--                            <a class="media fs-14 p-2" href="pages/apps/email.html"> <span><i--}}
                            {{--                                        class="flaticon-mail mr-2"></i> Inbox</span> <span--}}
                            {{--                                    class="badge badge-pill badge-info">3</span>--}}
                            {{--                            </a>--}}
                            {{--                            <a class="media fs-14 p-2" href="pages/prebuilt-pages/user-profile.html"> <span><i--}}
                            {{--                                        class="flaticon-gear mr-2"></i> Account Settings</span>--}}
                            {{--                            </a>--}}
                        </li>
                        <li class="dropdown-divider"></li>

                        <li class="dropdown-menu-footer">
                            <a class="media fs-14 p-2" href="{{ route('vendor.logout') }}"> <span><i
                                        class="flaticon-shut-down mr-2"></i> Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown"
                 data-target="#ms-nav-options"><span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
                <span class="ms-toggler-bar bg-primary"></span>
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
