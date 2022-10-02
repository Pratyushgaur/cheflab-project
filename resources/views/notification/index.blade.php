@extends('vendor.restaurants-layout')
@section('main-content')
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Notification</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="ms-content-wrapper">
            <div class="row">
                <!-- Recent Support Tickets -->
                <div class="col-xl-12 col-md-12">
                    <div class="ms-panel ms-panel-fh">
                        <div class="ms-panel-body p-0">
                            <ul class="ms-list ms-feed ms-twitter-feed ms-recent-support-tickets">
                                @foreach($notifications as $k=>$notification)
                                    <?php $user = \App\Models\User::find($notification->data['user_id']);?>
                                    <li class="ms-list-item">
                                        <a title="Click to view" href="{{$notification->data['link']}}"
                                           class="media clearfix">
                                            {{--                                            <img src="../../assets/img/costic/customer-4.jpg"--}}
                                            {{--                                                 class="ms-img-round ms-img-small" alt="This is another feature">--}}
                                            <div class="media-body">
                                                <div class="customer-meta">
                                                    <div class="new">
                                                        <h5 class="ms-feed-user mb-0">{{$user->name}}</h5>
                                                        {{--                                                        <h6 class="ml-4 mb-0 text-red">Spicy Grilled Burger</h6>--}}
                                                    </div>
                                                </div>
                                                <span class="my-2 d-block"> <i class="material-icons">date_range</i> {{ front_end_date_time($notification->created_at) }}</span>
                                                <p class="d-block">

                                                    {{ $notification->data['msg'] }}
                                                    {{--                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.--}}
                                                    {{--                                                    Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien--}}
                                                    ...</p>
                                                <div class="d-flex justify-content-between align-items-end">
                                                    <div class="ms-feed-controls"> <span>
                            <i class="material-icons">chat</i> 16
                          </span>
                                                        <span>
                            <i class="material-icons">attachment</i> 3
                          </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="">
                        </div>
                    </div>
                    <div class="right">
                        @if(empty($notifications))
                            {{ $notifications->links('vendor.pagination.bootstrap-4') }}
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
