<?php
$breadcrumb[] = ["name"  => "Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Shop Promotion management",
                 'route' => route("restaurant.shop.promotion")];
$breadcrumb[] = ["name"  => "List",
                 'route' => ""];

?>
@extends('vendor.restaurants-layout')
@section('main-content')
    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])
            </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Promotion</h6>
                            </div>
                            <a href="{{route('restaurant.shop.promotion.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <div class="">
                            <table id="menu-catalogue-table" class="table thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Blog Type</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">From Date</th>
                                    <th scope="col">To Date</th>
                                    <th scope="col">Time Slot</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Payment</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($appPromotionBlogBookings)<=0)
                                    <tr><td class="5">No Record Found</td></tr>
                                    @endif
                                <?php $blog_type = config('custom_app_setting.blog_type')?>
                                @foreach($appPromotionBlogBookings as $k=>$appPromotionBlogBooking)

                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td><img
                                                src="{{asset('slot-vendor-image').'/' .$appPromotionBlogBooking->image}}">
                                        </td>
                                        <td>{{$appPromotionBlogBooking->app_promotion_blog->name}}</td>
                                        <td>{{$blog_type[$appPromotionBlogBooking->app_promotion_blog->blog_type]}}</td>
                                        <td>{{$appPromotionBlogBooking->app_promotion_setting->blog_position}}</td>
                                        <td>{{$appPromotionBlogBooking->app_promotion_setting->blog_price}}</td>
                                        <td>{{front_end_date($appPromotionBlogBooking->from_date)}}</td>
                                        <td>{{front_end_date($appPromotionBlogBooking->to_date)}}</td>
                                        <td>{{front_end_time($appPromotionBlogBooking->from_date)}}
                                            - {{front_end_time($appPromotionBlogBooking->to_date)}}</td>
                                        <td>@if($appPromotionBlogBooking->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Suspended</span>
                                            @endif
                                        </td>
                                        <td>@if($appPromotionBlogBooking->payment_status)
                                                <span class="badge badge-success">Paid</span>
                                            @else
                                                <span class="badge badge-danger">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                        @if(!$appPromotionBlogBooking->payment_status)
                                            <!-- <div class="panel-body text-center"> -->
                                                <form action="{!!route('payment')!!}" method="POST">
                                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                                            data-key="{{ env('RAZOR_KEY') }}"
                                                            data-amount="{{($appPromotionBlogBooking->app_promotion_setting->blog_price*100)}}"
                                                            data-buttontext="Pay {{($appPromotionBlogBooking->app_promotion_setting->blog_price)}} INR"
                                                            data-name="{{ env('APP_NAME') }}"
                                                            data-description="Payment for Promotion :{{"'".$appPromotionBlogBooking->app_promotion_blog->name."' for position ".$appPromotionBlogBooking->app_promotion_setting->blog_position}}"
                                                            data-prefill.name="{{$appPromotionBlogBooking->app_promotion_blog->name}}"
                                                            data-prefill.email="{{\Auth::guard('vendor')->user()->email}}"
                                                            data-prefill.contact="{{\Auth::guard('vendor')->user()->mobile}}"
                                                            data-theme.color="#ff7529">
                                                    </script>
                                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                                    <input type="hidden" name="id" value="{{$appPromotionBlogBooking->id}}">

                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="">{{ $appPromotionBlogBookings->links('vendor.pagination.bootstrap-4') }}</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

