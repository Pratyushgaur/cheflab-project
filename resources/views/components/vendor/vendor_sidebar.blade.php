    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar scrollbar" id="style-7">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <!-- Dashboard start-->
                <li class="s_meun dashboard_active active">
                    <a href="{{ url('vendor-dashbord') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <!-- Dashboard end-->


                <li class="s_meun on_screen_notification">
                    <a href="{{ url('on-screen-notification-list') }}">
                        <i class="fa fa-dashboard"></i> <span>On Screen Notification</span>
                    </a>
                </li>

                <li class="s_meun promotional_banner_active">
                    <a href="{{ url('vendor-promotional-banner') }}">
                        <i class="fa fa-dashboard"></i> <span>Promotional Banner</span>
                    </a>
                </li>
                <li class="s_meun category_active">
                    <a href="{{ url('vendor-promotional-listing') }}">
                        <i class="fa fa-dashboard"></i> <span>Promotional Listing</span>
                    </a>
                </li>

                 <li class="s_meun my_banner_active">
                    <a href="{{ url('vendor-my-banner') }}">
                        <i class="fa fa-dashboard"></i> <span>My Banner</span>
                    </a>
                </li>

                <li class="s_meun category_active">
                    <a href="{{ url('vendor-category') }}">
                        <i class="fa fa-dashboard"></i> <span>Category</span>
                    </a>
                </li>

                <li class="s_meun sub_category_active">
                    <a href="{{ url('vendor-sub-category') }}">
                        <i class="fa fa-dashboard"></i> <span>Sub Category</span>
                    </a>
                </li>
                
                @if ((!empty(Auth::guard('vendor')->user())) && (Auth::guard('vendor')->user()->can('isVendorGrocery')))
                

                <li class="s_meun products_active">
                    <a href="{{ url('vendor-product') }}">
                        <i class="fa fa-dashboard"></i> <span>Products</span>
                    </a>
                </li>
                @endif

                 @if ((!empty(Auth::guard('vendor')->user())) && (Auth::guard('vendor')->user()->can('isVendorRestaurant')))
               
                <li class="s_meun products_active">
                    <a href="{{ url('vendor-restaurant-product') }}">
                        <i class="fa fa-dashboard"></i> <span>Products</span>
                    </a>
                </li>
                @endif


                @if ((!empty(Auth::guard('vendor')->user())) && (Auth::guard('vendor')->user()->can('isVendorPharmacy')))
               
                <li class="s_meun products_active">
                    <a href="{{ url('vendor-pharmacy-product') }}">
                        <i class="fa fa-dashboard"></i> <span>Pharmacy Products</span>
                    </a>
                </li>
                @endif




                
            


                <!--Settings end-->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>