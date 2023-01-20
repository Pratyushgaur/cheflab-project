@extends('vendor.restaurants-layout')
@section('main-content')
    <style>
        .razorpay-payment-button {
            background-color: #bc2634;
            border-color: #bc2634;
            color: #fff;
        }
    </style>
    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">


                            <div class="align-self-center align-left">
                                <h6>Promotion Requeste</h6>
                            </div>


                        </div>
                    </div>
                    <div class="ms-panel-body pb-0">
                        <div class="row">
                            <?php

                            $blog = \App\Models\RootImage::find($slot->cheflab_banner_image_id);
//                            $app_promotion_blog_setting = \App\Models\AppPromotionBlogSetting::find($appPromotionBlogBooking->app_promotion_blog_setting_id);
                            ?>
                            <div class="col-md-12 ">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{$blog->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Time During:</td>
                                            <td>{{front_end_time($slot->from_time).' - '.front_end_time($blog->to_time)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date:</td>
                                            <td>{{front_end_date($slot->from_date).' - '.front_end_date($slot->to_date)}}</td>
                                        </tr>

                                        <tr>
                                            <td>Position:</td>
                                            <td>{{$blog->position}}</td>
                                        </tr>
                                    </table>
                                    <div class="col-md-12 " style="margin-bottom: 30px;">
                                        <form action="{!!route('banner_payment')!!}" method="POST" id="pay" name="pay">
                                            <script id="rzp-button1" src="https://checkout.razorpay.com/v1/checkout.js"
                                                    data-key="{{ env('RAZOR_KEY') }}"
                                                    data-amount="{{($blog->price*100)}}"
                                                    data-buttontext="Pay {{($blog->price)}} INR"
                                                    data-name="{{ env('APP_NAME') }}"
                                                    data-description="Payment for Promotion :{{"'".$blog->name."' for position ".$blog->position}}"
                                                    data-prefill.name="{{$blog->name}}"
                                                    data-prefill.email="{{\Auth::guard('vendor')->user()->email}}"
                                                    data-prefill.contact="{{\Auth::guard('vendor')->user()->mobile}}"
                                                    data-theme.color="#ff7529">
                                            </script>
                                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                            <input type="hidden" name="id" value="{{$slot->id}}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

