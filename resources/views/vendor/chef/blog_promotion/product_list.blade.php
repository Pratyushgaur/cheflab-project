@extends('vendor.chef-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Promotion management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Promotion</li>


                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Promotion</h6>
                            </div>
                            <a href="{{route('chef.product.promotion.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <div class="">
                            <table id="menu-catalogue-table" class="table thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Blog Type</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">From Date</th>
                                    <th scope="col">To Date</th>
                                    <th scope="col">Time Slot</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Payment</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $blog_type = config('custom_app_setting.blog_type')?>
                                @foreach($appPromotionBlogBookings as $k=>$appPromotionBlogBooking)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{$appPromotionBlogBooking->product->product_name}}</td>
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

