<aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">
    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
      <a class="pl-0 ml-0 text-center" href="index.html" style="padding:0px !important;">
        <!-- <img src="{{asset('frontend')}}/assets/img/costic/costic-logo-216x62.png" alt="logo"> -->
        <img src="{{asset('commonarea')}}/logo.png" alt="logo" style="height: 70px;">
      </a>
    </div>
    <!-- Navigation -->
    <ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
      <!-- Dashboard -->
      <li class="menu-item ">
        <a href="{{route('restaurant.dashboard')}}" class="{{ Request::routeIs('restaurant.dashboard') ? 'active' : '' }}"> <span><i class="material-icons fs-16 ">home</i>Home</span>
        </a>
      </li>
      
      <li class="menu-item">
        <a href="#" class="has-chevron {{ request()->is('vendor/restaurant/menus*') ? 'active' : '' }}" data-toggle="collapse" data-target="#menus" aria-expanded="false" aria-controls="menus"> <span><i class="fa fa-archive fs-16"></i>Menus </span>
        </a>
        <ul id="menus" class="collapse {{ request()->is('vendor/restaurant/menus*') ? 'show' : '' }}" aria-labelledby="product" data-parent="#side-nav-accordion">
          <li> <a href="{{route('restaurant.menu.list')}}" class="{{ Request::routeIs('restaurant.menu.list') ? 'active' : '' }}">Menu Catalogue</a>
          </li>
          <li> <a href="{{route('restaurant.menu.create')}}" class="{{ Request::routeIs('restaurant.menu.create') ? 'active' : '' }}">Add Catalogue</a>
          </li>
          
        </ul>
      </li>

      <li class="menu-item">
        <a href="#" class="has-chevron {{ request()->is('vendor/restaurant/product*') ? 'active' : '' }}" data-toggle="collapse" data-target="#product" aria-expanded="false" aria-controls="product"> <span><i class="nav-icon fa fa-fire fs-16"></i>Products </span>
        </a>
        <ul id="product" class="collapse {{ request()->is('vendor/restaurant/product*') ? 'show' : '' }}" aria-labelledby="product" data-parent="#side-nav-accordion">
          <li> <a href="{{route('restaurant.product.list')}}" class="{{ Request::routeIs('restaurant.product.list') ? 'active' : '' }}">Items</a></li>
          <li> <a href="{{route('restaurant.product.addon')}}" class="{{ Request::routeIs('restaurant.product.addon') ? 'active' : '' }}">Addons</a></li>
          
        </ul>
      </li>

      <li class="menu-item">
        <a href="#" class="has-chevron" data-toggle="collapse" data-target="#orders" aria-expanded="false" aria-controls="orders"> <span><i class="nav-icon fa fa-shopping-basket fs-16"></i>Orders</span>
        </a>
        <ul id="orders" class="collapse " aria-labelledby="product" data-parent="#side-nav-accordion">
          <li>
             <a href="{{route('restaurant.order.list')}}" class="">Order List</a>
          </li>
        </ul>
      </li>

      <li class="menu-item">
        <a href="{{route('restaurant.coupon.list')}}"> <span><i class="nav-icon fa fa-gift fs-16"></i>Coupons</span>
        </a>
      </li>
      <hr>
      <li class="menu-item ">
        <a href="" class=""> <span><i class="nav-icon fa fa-bell fs-16 "></i>Notification</span>
        </a>
      </li>
      <li class="menu-item ">
        <a href="" class=""> <span><i class="fas fa-rupee-sign fs-16 "></i>Payment</span>
        </a>
      </li>
      <li class="menu-item ">
        <a href="{{route('restaurant.globleseting')}}" class=""> <span><i class="nav-icon fa fa-cogs fs-16"></i>Setting</span>
        </a>
        <ul id="setting" class="collapse " aria-labelledby="setting" data-parent="#side-nav-accordion">
          <li> <a href="{{route('restaurant.globleseting.ordertime')}}" class="">Globel Setting</a>
          </li>
          <li> <a href="" class="">Add Catalogue</a>
          </li>
        </ul>
      </li>
      

      <!-- /Dashboard -->
      <!-- product -->
    
      <!-- /Apps -->
    </ul>
  </aside>
  <!-- Sidebar Right -->
  <aside id="ms-recent-activity" class="side-nav fixed ms-aside-right ms-scrollable">
    <div class="ms-aside-header">
      <ul class="nav nav-tabs tabs-bordered d-flex nav-justified mb-3" role="tablist">
        <li role="presentation" class="fs-12"><a href="#activityLog" aria-controls="activityLog" class="active" role="tab" data-toggle="tab"> Activity Log</a>
        </li>
        <li>
          <button type="button" class="close ms-toggler text-center" data-target="#ms-recent-activity" data-toggle="slideRight"><span aria-hidden="true">&times;</span>
          </button>
        </li>
      </ul>
    </div>
    <div class="ms-aside-body">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade show" id="activityLog">
          <ul class="ms-activity-log">
            <li>
              <div class="ms-btn-icon btn-pill icon btn-light"> <i class="flaticon-gear"></i>
              </div>
              <h6>Update 1.0.0 Pushed</h6>
              <span> <i class="material-icons">event</i>1 January, 2020</span>
              <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
            </li>
            <li>
              <div class="ms-btn-icon btn-pill icon btn-success"> <i class="flaticon-tick-inside-circle"></i>
              </div>
              <h6>Profile Updated</h6>
              <span> <i class="material-icons">event</i>4 March, 2018</span>
              <p class="fs-14">Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
            </li>
            <li>
              <div class="ms-btn-icon btn-pill icon btn-warning"> <i class="flaticon-alert-1"></i>
              </div>
              <h6>Your payment is due</h6>
              <span> <i class="material-icons">event</i>1 January, 2020</span>
              <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
            </li>
            <li>
              <div class="ms-btn-icon btn-pill icon btn-danger"> <i class="flaticon-alert"></i>
              </div>
              <h6>Database Error</h6>
              <span> <i class="material-icons">event</i>4 March, 2018</span>
              <p class="fs-14">Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
            </li>
            <li>
              <div class="ms-btn-icon btn-pill icon btn-info"> <i class="flaticon-information"></i>
              </div>
              <h6>Checkout what's Trending</h6>
              <span> <i class="material-icons">event</i>1 January, 2020</span>
              <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, ula in sodales vehicula....</p>
            </li>
            <li>
              <div class="ms-btn-icon btn-pill icon btn-secondary"> <i class="flaticon-diamond"></i>
              </div>
              <h6>Your Dashboard is ready</h6>
              <span> <i class="material-icons">event</i>4 March, 2018</span>
              <p class="fs-14">Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
            </li>
          </ul> <a href="#" class="btn btn-primary d-block"> View All </a>
        </div>
      </div>
    </div>
  </aside>