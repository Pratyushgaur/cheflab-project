<?php
$breadcrumb[] = ["name"  => "Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Product Review",
                 'route' => ""];

?>
@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])
            </div>

            <div class="col-xl-12 col-md-12">
                <div class="ms-panel ms-panel-fh">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Recent Vendor Review</h6>
                            </div>
{{--                            <a href="#" class="btn btn-primary"> View All</a>--}}
                        </div>
                    </div>
                    <div class="ms-panel-body p-0">
                        <ul class="ms-list ms-feed ms-twitter-feed ms-recent-support-tickets">
                            @foreach($VendorReview as $k=>$review)
                            <li class="ms-list-item">
                                <a href="#" class="media clearfix">
                                    <img src="{{asset('products').'/'.$review->product_image}}" class="ms-img-round ms-img-small" alt="This is another feature">
                                    <div class="media-body">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="ms-feed-user mb-0"><code>{{$review->product_name}}</code></h6>

                                            <span class="badge "> 
                                                <ul class="ms-star-rating rating-fill rating-circle ratings-new">
                                                    <?php
                                                        $black_star=5-$review->product_rating;
                                                        for ($i=1;$i<=$black_star;$i++){
                                                            echo '<li class="ms-rating-item"><i class="material-icons">star</i></li>';
                                                        }
                                                        for ($i=1;$i<=$review->product_rating;$i++){
                                                            echo '<li class="ms-rating-item rated"><i class="material-icons">star</i></li>';
                                                        }
                                                    ?>

                                                </ul> 
                                            </span>
                                        </div> 
                                        

                                        <div class="d-flex justify-content-between align-items-end">
                                            <div class="ms-feed-controls"> <span>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

{{--            <div class="">{{ $VendorReview->links('vendor.pagination.bootstrap-4') }}</div>--}}


        </div>
    </div>

@endsection
