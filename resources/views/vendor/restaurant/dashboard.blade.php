@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">
            <div class="col-md-8">
                <h1 class="db-header-title">Welcome, {{ucfirst(Auth::guard('vendor')->user()->name)}}</h1>
            </div>

            <div class="col-md-4">
                <form   action="{{route('restaurant.dashboard')}}">
                {{ Form::select('filter',[1=>'Today',2=>'This Week',3=>'This Month'],request()->filter,['class' => 'select2 form-control','placeholder' => 'Filter','id'=>'dashboard_input']) }}
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="ms-card card-gradient-success ms-widget ms-infographics-widget">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Total Orders</h6>
                            <p class="ms-card-change"><i class="material-icons">arrow_upward</i> {{$total_confirmed}}
                            </p>
                            <p class="fs-12">{{$text}}</p>
                        </div>
                    </div>
                    <i class="flaticon-statistics"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="ms-card card-gradient-success ms-widget ms-infographics-widget">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Preparing</h6>
                            <p class="ms-card-change"><i class="material-icons">arrow_upward</i> {{$total_prepairing}}
                            </p>
                            <p class="fs-12">{{$text}}</p>
                        </div>
                    </div>
                    <i class="flaticon-statistics"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="ms-card card-gradient-success ms-widget ms-infographics-widget">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Ready for Delivery</h6>
                            <p class="ms-card-change"><i class="material-icons">arrow_upward</i> {{$total_completed}}
                            </p>
                            <p class="fs-12">{{$text}}</p>
                        </div>
                    </div>
                    <i class="flaticon-statistics"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="ms-card card-gradient-success ms-widget ms-infographics-widget">
                    <div class="ms-card-body media">
                        <div class="media-body">
                            <h6>Out For Delivery</h6>
                            <p class="ms-card-change"><i class="material-icons">arrow_upward</i> {{$total_dispatched}}
                            </p>
                            <p class="fs-12">{{$text}}</p>
                        </div>
                    </div>
                    <i class="flaticon-statistics"></i>
                </div>
            </div>

            <!-- <div class="col-xl-3 col-md-6">
                <a href="#">
                    <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                        <div class="ms-panel-body media">
                            <i class="fa fa-truck fa-6" aria-hidden="true"></i>
                            <div class="media-body">
                                <h6>{{$total_completed}}</h6>
                                <span>Total Delivered</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div> -->
            <div class="col-xl-3 col-md-6">
                <a href="#">
                    <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                        <div class="ms-panel-body media">
                            <i class="fa fa-truck fa-6" aria-hidden="true"></i>
                            <div class="media-body">
                                <h6>{{$total_completed}}</h6>
                                <span>Total <br> Revenue</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-6">
                <a href="#">
                    <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                        <div class="ms-panel-body media">
                            <i class="material-icons">cached</i>
                            <div class="media-body">
                                <h6>{{$total_refund}}</h6>
                                <span>Total <br> Refunds </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- <div class="col-xl-3 col-md-6">
                <a href="#">
                    <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                        <div class="ms-panel-body media">
                            <i class="material-icons">timer</i>
                            <div class="media-body">
                                <h6>{{$total_ready_to_dispatch}}</h6>
                                <span>Ready to dispatch</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div> -->
            <div class="col-xl-3 col-md-6">
                <a href="#">
                    <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                        <div class="ms-panel-body media">
                            <i class="material-icons">timer</i>
                            <div class="media-body">
                                <h6>{{$total_ready_to_dispatch}}</h6>
                                <span>Cancelled Orders</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


            <!-- <div class="col-xl-3 col-md-6">
                <a href="#">
                    <div class="ms-panel ms-panel-hoverable has-border ms-widget ms-has-new-msg ms-notification-widget">
                        <div class="ms-panel-body media">
                            <i class="material-icons">functions</i>
                            <div class="media-body">
                                <h6>{{$total_order}}</h6>
                                <span>Total order</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div> -->

            @if(count($graph_data) > 1)
            <div class="col-xl-12 col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6>Sale Chart</h6>
                    </div>
                    <div class="ms-panel-body">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Orders Requested -->
        <!-- <div class="col-xl-6 col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Recent Orders Requested</h6>
                </div>
                <button type="button" class="btn btn-primary">View All</button>
              </div>
            </div>
            <div class="ms-panel-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Food Item</th>
                      <th scope="col">Price</th>
                      <th scope="col">Product ID</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="ms-table-f-w"> <img src="{{asset('frontend')}}/assets/img/costic/pizza.jpg" alt="people"> Pizza </td>
                      <td>$19.99</td>
                      <td>67384917</td>
                    </tr>
                    <tr>
                      <td class="ms-table-f-w"> <img src="{{asset('frontend')}}/assets/img/costic/french-fries.jpg" alt="people"> French Fries </td>
                      <td>$14.59</td>
                      <td>789393819</td>
                    </tr>



                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header new">
              <h6>Monthly Revenue</h6>
              <select class="form-control new" id="exampleSelect">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March </option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="1">June</option>
                <option value="2">July</option>
                <option value="3">August</option>
                <option value="4">September</option>
                <option value="5">October</option>
                <option value="4">November</option>
                <option value="5">December</option>
              </select>
            </div>
            <div class="ms-panel-body">
              <span class="progress-label"> <strong>Week 1</strong> </span>
              <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
              </div>
              <span class="progress-label"> <strong>Week 2</strong> </span>
              <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
              </div>
              <span class="progress-label"> <strong>Week 3</strong> </span>
              <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
              </div>
              <span class="progress-label"> <strong>Week 4</strong> </span>
              <div class="progress">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
              </div>
            </div>
          </div>
        </div> -->
            <!-- Food Orders -->
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6>Top Selling Dishes</h6>
                    </div>
                    <div class="ms-panel-body">
                        <div class="row">
                            @forelse($product as $key =>$value)
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="ms-card no-margin">
                                        <div class="ms-card-img">
                                            <img src="{{asset('products').'/'.$value->product_image}}" alt="card_img" style="width: 530px; height: 240px;">
                                        </div>
                                        <div class="ms-card-body">
                                            <div class="ms-card-heading-title">
                                                <h6>{{$value->product_name}} </h6>
                                                <span class="green-text"><strong><i class="fas fa-rupee-sign"></i> {{$value->product_price}}</strong></span>
                                            </div>

                                            <div class="ms-card-heading-title">
                                                <p>Orders <span class="red-text">{{$value->orderTotal}}</span></p>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @empty
                                  <div class="col-lg-3 col-md-6 col-sm-6">
                                      <h5>No Product Found </h5>
                                  </div>
                              @endforelse
                        

                        </div>
                    </div>
                </div>
            </div>
            <!-- END/Food Orders -->

            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <h6>Top Rated/Reviews Dishes</h6>

                    </div>
                    <div class="ms-panel-body">
                        <div class="row">
                            @forelse($top_rated_products as $k=>$product)
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="ms-card no-margin">
                                    <div class="ms-card-body">
                                        <div class="media fs-14">
                                            <div class="media-body">
                                                <h6>{{$product->product_name}} </h6>
                                            </div>

                                        </div>
                                        <ul class="ms-star-rating rating-fill rating-circle ratings-new">
                                            <?php
                                            $black_star=5-$product->product_rating;
                                            for ($i=1;$i<=$black_star;$i++){
                                                echo '<li class="ms-rating-item"><i class="material-icons">star</i></li>';
                                            }
                                            for ($i=1;$i<=$product->product_rating;$i++){
                                                echo '<li class="ms-rating-item rated"><i class="material-icons">star</i></li>';
                                            }
                                            ?>

                                        </ul>

                                    </div>
                                    <div class="ms-card-img">
                                        <img src="{{asset('products').'/'.$product->product_image}}" alt="card_img">
                                    </div>
                                    <!-- <div class="ms-card-footer text-disabled d-flex">
                                      <div class="ms-card-options">
                                        <i class="material-icons">favorite</i> 982
                                      </div>
                                      <div class="ms-card-options">
                                        <i class="material-icons">comment</i> 785
                                      </div>
                                    </div> -->
                                </div>
                            </div>
                            @empty
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <h5>No Product Found </h5>
                            </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>

            <!-- Favourite Products -->
            <div class="col-xl-5 col-md-12">
                <!-- <div class="ms-panel ms-widget ms-crypto-widget">
                  <div class="ms-panel-header">
                    <h6>Favourite charts</h6>
                  </div>
                  <div class="ms-panel-body p-0">
                    <ul class="nav nav-tabs nav-justified has-gap px-4 pt-4" role="tablist">
                      <li role="presentation" class="fs-12"><a href="#btc" aria-controls="btc" class="active show" role="tab" data-toggle="tab"> Mon </a></li>
                      <li role="presentation" class="fs-12"><a href="#xrp" aria-controls="xrp" role="tab" data-toggle="tab"> Tue </a></li>
                      <li role="presentation" class="fs-12"><a href="#ltc" aria-controls="ltc" role="tab" data-toggle="tab"> Wed </a></li>
                      <li role="presentation" class="fs-12"><a href="#eth" aria-controls="eth" role="tab" data-toggle="tab"> Thu </a></li>
                      <li role="presentation" class="fs-12"><a href="#zec" aria-controls="zec" role="tab" data-toggle="tab"> Fri </a></li>
                    </ul>
                    <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active show fade in" id="btc">
                        <div class="table-responsive">
                          <table class="table table-hover thead-light">
                            <thead>
                              <tr>
                                <th scope="col">Restaurant Names</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Orders</th>
                                <th scope="col">Profit</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Hunger House</td>
                                <td>8528</td>
                                <td class="ms-text-success">+17.24%</td>
                                <td>7.65%</td>
                              </tr>
                              <tr>
                                <td>Food Lounge</td>
                                <td>4867</td>
                                <td class="ms-text-danger">-12.24%</td>
                                <td>9.12%</td>
                              </tr>
                              <tr>
                                <td>Delizious</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                              <tr>
                                <td>Netherfood</td>
                                <td>1614</td>
                                <td class="ms-text-danger">-20.75%</td>
                                <td>12.25%</td>
                              </tr>
                              <tr>
                                <td>Rusmiz</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="xrp">
                        <div class="table-responsive">
                          <table class="table table-hover thead-light">
                            <thead>
                              <tr>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Orders</th>
                                <th scope="col">Profit</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Hunger House</td>
                                <td>8528</td>
                                <td class="ms-text-success">+17.24%</td>
                                <td>7.65%</td>
                              </tr>
                              <tr>
                                <td>Food Lounge</td>
                                <td>4867</td>
                                <td class="ms-text-danger">-12.24%</td>
                                <td>9.12%</td>
                              </tr>
                              <tr>
                                <td>Delizious</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                              <tr>
                                <td>Netherfood</td>
                                <td>1614</td>
                                <td class="ms-text-danger">-20.75%</td>
                                <td>12.25%</td>
                              </tr>
                              <tr>
                                <td>Rusmiz</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="ltc">
                        <div class="table-responsive">
                          <table class="table table-hover thead-light">
                            <thead>
                              <tr>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Orders</th>
                                <th scope="col">Profit</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Hunger House</td>
                                <td>8528</td>
                                <td class="ms-text-success">+17.24%</td>
                                <td>7.65%</td>
                              </tr>
                              <tr>
                                <td>Food Lounge</td>
                                <td>4867</td>
                                <td class="ms-text-danger">-12.24%</td>
                                <td>9.12%</td>
                              </tr>
                              <tr>
                                <td>Delizious</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                              <tr>
                                <td>Netherfood</td>
                                <td>1614</td>
                                <td class="ms-text-danger">-20.75%</td>
                                <td>12.25%</td>
                              </tr>
                              <tr>
                                <td>Rusmiz</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="eth">
                        <div class="table-responsive">
                          <table class="table table-hover thead-light">
                            <thead>
                              <tr>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Orders</th>
                                <th scope="col">Profit</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Hunger House</td>
                                <td>8528</td>
                                <td class="ms-text-success">+17.24%</td>
                                <td>7.65%</td>
                              </tr>
                              <tr>
                                <td>Food Lounge</td>
                                <td>4867</td>
                                <td class="ms-text-danger">-12.24%</td>
                                <td>9.12%</td>
                              </tr>
                              <tr>
                                <td>Delizious</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                              <tr>
                                <td>Netherfood</td>
                                <td>1614</td>
                                <td class="ms-text-danger">-20.75%</td>
                                <td>12.25%</td>
                              </tr>
                              <tr>
                                <td>Rusmiz</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="zec">
                        <div class="table-responsive">
                          <table class="table table-hover thead-light">
                            <thead>
                              <tr>
                                <th scope="col">Restaurant Name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Orders</th>
                                <th scope="col">Profit</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Hunger House</td>
                                <td>8528</td>
                                <td class="ms-text-success">+17.24%</td>
                                <td>7.65%</td>
                              </tr>
                              <tr>
                                <td>Food Lounge</td>
                                <td>4867</td>
                                <td class="ms-text-danger">-12.24%</td>
                                <td>9.12%</td>
                              </tr>
                              <tr>
                                <td>Delizious</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                              <tr>
                                <td>Netherfood</td>
                                <td>1614</td>
                                <td class="ms-text-danger">-20.75%</td>
                                <td>12.25%</td>
                              </tr>
                              <tr>
                                <td>Rusmiz</td>
                                <td>7538</td>
                                <td class="ms-text-success">+32.04%</td>
                                <td>14.29%</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div> -->
                <!-- Favourite Products -->
                <!-- Total Earnings -->

            </div>
            <!-- Total Earnings -->


            <!-- Recent Support Tickets -->
        <!-- <div class="col-xl-6 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Recent Support Tickets</h6>
                </div>
                <a href="#" class="btn btn-primary"> View All</a>
              </div>
            </div>
            <div class="ms-panel-body p-0">
              <ul class="ms-list ms-feed ms-twitter-feed ms-recent-support-tickets">
                <li class="ms-list-item">
                  <a href="#" class="media clearfix">
                    <img src="{{asset('frontend')}}/assets/img/costic/customer-4.jpg" class="ms-img-round ms-img-small" alt="This is another feature">
                    <div class="media-body">
                      <div class="d-flex justify-content-between">
                        <h6 class="ms-feed-user mb-0">Lorem ipsum dolor</h6>
                        <span class="badge badge-success"> Open </span>
                      </div> <span class="my-2 d-block"> <i class="material-icons">date_range</i> December 24, 2020</span>
                      <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p>
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
                <li class="ms-list-item">
                  <a href="#" class="media clearfix">
                    <img src="{{asset('frontend')}}/assets/img/costic/customer-1.jpg" class="ms-img-round ms-img-small" alt="This is another feature">
                    <div class="media-body">
                      <div class="d-flex justify-content-between">
                        <h6 class="ms-feed-user mb-0">Lorem ipsum dolor</h6>
                        <span class="badge badge-success"> Open </span>
                      </div> <span class="my-2 d-block"> <i class="material-icons">date_range</i> December 24, 2020</span>
                      <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p>
                      <div class="d-flex justify-content-between align-items-end">
                        <div class="ms-feed-controls"> <span>
                            <i class="material-icons">chat</i> 11
                          </span>
                          <span>
                            <i class="material-icons">attachment</i> 1
                          </span>
                        </div>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="ms-list-item">
                  <a href="#" class="media clearfix">
                    <img src="{{asset('frontend')}}/assets/img/costic/customer-7.jpg" class="ms-img-round ms-img-small" alt="This is another feature">
                    <div class="media-body">
                      <div class="d-flex justify-content-between">
                        <h6 class="ms-feed-user mb-0">Lorem ipsum dolor</h6>
                        <span class="badge badge-danger"> Closed </span>
                      </div> <span class="my-2 d-block"> <i class="material-icons">date_range</i> December 24, 2020</span>
                      <p class="d-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla luctus lectus a facilisis bibendum. Duis quis convallis sapien ...</p>
                      <div class="d-flex justify-content-between align-items-end">
                        <div class="ms-feed-controls"> <span>
                            <i class="material-icons">chat</i> 21
                          </span>
                          <span>
                            <i class="material-icons">attachment</i> 5
                          </span>
                        </div>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div> -->
            <!-- Recent Support Tickets -->
            <!-- client chat -->
        <!-- <div class="col-xl-6 col-md-12">
          <div class="ms-panel ms-panel-fh ms-widget ms-chat-conversations">
            <div class="ms-panel-header">
              <div class="ms-chat-header justify-content-between">
                <div class="ms-chat-user-container media clearfix">
                  <div class="ms-chat-status ms-status-online ms-chat-img mr-3 align-self-center">
                    <img src="{{asset('frontend')}}/assets/img/costic/customer-1.jpg" class="ms-img-round" alt="people">
                  </div>
                  <div class="media-body ms-chat-user-info mt-1">
                    <h6>Heather Brown</h6>
                    <span class="text-disabled fs-12">
                      Active Now
                    </span>
                  </div>
                </div>
                <ul class="ms-list ms-list-flex ms-chat-controls">
                  <li data-toggle="tooltip" data-placement="top" title="Call"> <i class="material-icons">local_phone</i>
                  </li>
                  <li data-toggle="tooltip" data-placement="top" title="Video Call"> <i class="material-icons">videocam</i>
                  </li>
                  <li data-toggle="tooltip" data-placement="top" title="Add to Chat"> <i class="material-icons">person_add</i>
                  </li>
                </ul>
              </div>
            </div>
            <div class="ms-panel-body ms-scrollable">
              <div class="ms-chat-bubble ms-chat-message ms-chat-outgoing media clearfix">
                <div class="ms-chat-status ms-status-online ms-chat-img">
                  <img src="{{asset('frontend')}}/assets/img/costic/customer-1.jpg" class="ms-img-round" alt="people">
                </div>
                <div class="media-body">
                  <div class="ms-chat-text">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                  </div>
                  <p class="ms-chat-time">10:33 pm</p>
                </div>
              </div>
              <div class="ms-chat-bubble ms-chat-message ms-chat-incoming media clearfix">
                <div class="ms-chat-status ms-status-online ms-chat-img">
                  <img src="{{asset('frontend')}}/assets/img/costic/customer-2.jpg" class="ms-img-round" alt="people">
                </div>
                <div class="media-body">
                  <div class="ms-chat-text">
                    <p>I'm doing great, thanks for asking</p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard</p>
                  </div>
                  <p class="ms-chat-time">11:01 pm</p>
                </div>
              </div>
              <div class="ms-chat-bubble ms-chat-message ms-chat-outgoing media clearfix">
                <div class="ms-chat-status ms-status-online ms-chat-img">
                  <img src="{{asset('frontend')}}/assets/img/costic/customer-1.jpg" class="ms-img-round" alt="people">
                </div>
                <div class="media-body">
                  <div class="ms-chat-text">
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page</p>
                    <p>There are many variations of passages of Lorem Ipsum available</p>
                  </div>
                  <p class="ms-chat-time">11:03 pm</p>
                </div>
              </div>
              <div class="ms-panel-footer">
                <div class="ms-chat-textbox">
                  <ul class="ms-list-flex mb-0">
                    <li class="ms-chat-vn"><i class="material-icons">mic</i>
                    </li>
                    <li class="ms-chat-input">
                      <input type="text" name="msg" placeholder="Enter Message" value="">
                    </li>
                    <li class="ms-chat-text-controls ms-list-flex"> <span> <i class="material-icons">tag_faces</i> </span>
                      <span> <i class="material-icons">attach_file</i> </span>
                      <span> <i class="material-icons">camera_alt</i> </span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div> -->
            <!-- client chat -->
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        //Line Chart
        // var ctx = document.getElementById('line-chart').getContext("2d");
        // var gradientStroke = ctx.createLinearGradient(0, 0, 0, 450);
        // gradientStroke.addColorStop(0, '#ff0018');

        // var gradientFill = ctx.createLinearGradient(0, 0, 0, 450);
        // gradientFill.addColorStop(0, "rgba(53,127,250,0.4)");
        // gradientFill.addColorStop(1, "rgba(255,255,255,0)");

        
        // var data_1 = [
        //     @foreach($graph_data as $k=>$v)
        //     {{$v['total_net_amount']}},
        //     @endforeach];

        // var data_2 = [
        //     @foreach($graph_data as $k=>$v)
        //     {{$v['order_count']}},
        //     @endforeach];


        // var labels =[
        //     @foreach($graph_data as $k=>$v)
        //     "{{ date('F-Y', strtotime($v['created_at']))}}" ,
        //     @endforeach];



        // var lineChart = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: labels,
        //         datasets: [{
        //             label: "Total earning Rs.",
        //             borderColor: gradientStroke,
        //             pointBorderColor: gradientStroke,
        //             pointBackgroundColor: gradientStroke,
        //             pointHoverBackgroundColor: gradientStroke,
        //             pointHoverBorderColor: gradientStroke,
        //             pointBorderWidth: 1,
        //             pointHoverRadius: 4,
        //             pointHoverBorderWidth: 1,
        //             pointRadius: 2,
        //             fill: true,
        //             backgroundColor: gradientFill,
        //             borderWidth: 1,
        //             data: data_1
        //         },
        //             {
        //                 label: "No. of orders completed",
        //                 borderColor: gradientStroke,
        //                 pointBorderColor: gradientStroke,
        //                 pointBackgroundColor: gradientStroke,
        //                 pointHoverBackgroundColor: gradientStroke,
        //                 pointHoverBorderColor: gradientStroke,
        //                 pointBorderWidth: 1,
        //                 pointHoverRadius: 4,
        //                 pointHoverBorderWidth: 1,
        //                 pointRadius: 2,
        //                 fill: true,
        //                 backgroundColor: gradientFill,
        //                 borderWidth: 1,
        //                 data: data_2
        //             }]
        //     },
        //     options: {
        //         legend: {
        //             display: false,
        //             position: "bottom"
        //         },
        //         scales: {
        //             yAxes: [{
        //                 ticks: {
        //                     fontColor: "rgba(0,0,0,0.5)",
        //                     fontStyle: "bold",
        //                     beginAtZero: true,
        //                     maxTicksLimit: 200,
        //                     padding: 20
        //                 },
        //                 gridLines: {
        //                     drawTicks: false,
        //                     display: false
        //                 }

        //             }],
        //             xAxes: [{
        //                 gridLines: {
        //                     zeroLineColor: "transparent"
        //                 },
        //                 ticks: {
        //                     padding: 20,
        //                     fontColor: "rgba(0,0,0,0.5)",
        //                     fontStyle: "bold"
        //                 }
        //             }]
        //         }
        //     }
        // });
        @if(count($graph_data) > 1)
        var ctx = document.getElementById('line-chart').getContext("2d");
        var gradientStroke = ctx.createLinearGradient(0, 0, 0, 450);
        gradientStroke.addColorStop(0, '#ff0018');

        var gradientFill = ctx.createLinearGradient(0, 0, 0, 450);
        gradientFill.addColorStop(0, "rgba(53,127,250,0.4)");
        gradientFill.addColorStop(1, "rgba(255,255,255,0)");

        // all data
        var data_1 = [
          @foreach($graph_data as $k=>$v)
            {{$v['total_net_amount']}},
            @endforeach
        ];
        //var data_2 = [4100, 3800, 3200, 3400, 2700, 2600, 3300, 3000, 2900];
        var labels = [
          @foreach($graph_data as $k=>$v)
            "{{$v['Month_Group']}}",
            @endforeach
        ];

        var lineChart = new Chart(ctx, {
          type: 'line',
          data: {
              labels: labels,
              datasets: [{
                  label: "Order Amount",
                  borderColor: gradientStroke,
                  pointBorderColor: gradientStroke,
                  pointBackgroundColor: gradientStroke,
                  pointHoverBackgroundColor: gradientStroke,
                  pointHoverBorderColor: gradientStroke,
                  pointBorderWidth: 1,
                  pointHoverRadius: 4,
                  pointHoverBorderWidth: 1,
                  pointRadius: 2,
                  fill: true,
                  backgroundColor: gradientFill,
                  borderWidth: 1,
                  data: data_1
              }]
          },
          options: {
              legend: {
              display: false,
              position: "bottom"
              },
              scales: {
                yAxes: [{
                  ticks: {
                    fontColor: "rgba(0,0,0,0.5)",
                    fontStyle: "bold",
                    beginAtZero: true,
                    maxTicksLimit: 200,
                    padding: 20
                  },
                  gridLines: {
                    drawTicks: false,
                    display: false
                  }

              }],
              xAxes: [{
                  gridLines: {
                    zeroLineColor: "transparent"
                  },
                  ticks: {
                    padding: 20,
                    fontColor: "rgba(0,0,0,0.5)",
                    fontStyle: "bold"
                  }
              }]
            }
          }
        });
        @endif
        $("#dashboard_input").change(function() {
            this.form.submit();
        });
    </script>
@endpush

