    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar scrollbar" id="style-7">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <!-- Dashboard start-->
                <li class="s_meun dashboard_active active">
                    <a href="{{ url('city-admin-dashbord') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <!-- Dashboard end-->

                <li class="treeview s_meun ca_withdrwal_request_active ">
                    <a href="#">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Withdrwal Request</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        
                        <li class="s_meun ca_vendor_withdrwal_active"><a href="{{ url('/cityadmin/vendor-withdrwal') }}"><i class="fa fa-picture-o"></i> <span>Vendor Withdrawal Request</span></a></li>
                        <li class="s_meun ca_delivery_withdrwal_active"><a href="{{ url('/cityadmin/delivery-boy-withdrwal') }}"><i class="fa fa-picture-o"></i> <span>Delivery Boy Withdrawal Request</span></a></li>
                        
                    </ul>
                </li>




                <li class="treeview s_meun ca_account_settlement_active ">
                    <a href="#">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Account Settlement</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                       
                        <li class="s_meun ca_vendor_account_settlement_active"><a href="{{route('cityadmin.vendor.account.settlement') }}"><i class="fa fa-picture-o"></i> <span>Vendor Account Settlement</span></a></li>
                        <li class="s_meun ca_delivery_account_settlement_active"><a href="{{ route('cityadmin.delivery.boy.account.settlement') }}"><i class="fa fa-picture-o"></i> <span>Delivery Boy Account Settlement</span></a></li>
                        
                    </ul>
                </li>



                <!-- <li class="treeview s_meun orders_management_active ">
                    <a href="#">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Orders</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="s_meun ongoing_order_menu"><a href="{{ url('/cityadmin/ongoing-orders') }}"><i class="fa fa-picture-o"></i> <span>Ongoing Orders</span></a></li>
                        <li class="s_meun completed_order_menu"><a href="{{ url('/cityadmin/completed-orders') }}"><i class="fa fa-picture-o"></i> <span>Completed Orders</span></a></li>
                        <li class="s_meun cancelled_order_menu"><a href="{{ url('/cityadmin/cancelled-orders') }}"><i class="fa fa-picture-o"></i> <span>Cancelled Orders</span></a></li>
                        <li class="s_meun returned_order_menu"><a href="{{ url('cityadmin/returned-orders') }}"><i class="fa fa-picture-o"></i> <span>Returned Orders</span></a></li>
                        
                    </ul>
                </li>-->

                <li class="s_meun orders_management_active">
                    <a href="{{ url('/cityadmin/ongoing-orders') }}">
                        <i class="fa fa-dashboard"></i> <span>Orders</span>
                    </a>
                </li>


                <li class="treeview ct_meun ct_user_management_active ">
                    <a href="#">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>User Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        
                        <li class="s_meun ct_vendor_list_active"><a href="{{ route('cityadmin.view.vendor.list') }}"><i class="fa fa-picture-o"></i> <span>Vendors</span></a></li>
                        <li class="s_meun ct_delivery_boy_list_active"><a href="{{ route('cityadmin.view.delivery.boy.list') }}"><i class="fa fa-picture-o"></i> <span>Delivery Boy</span></a></li>
                        
                    </ul>
                </li>
                

                 <li class="treeview ct_meun ct_management_active ">
                    <a href="#">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>Management</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        
                        <li class="s_meun ct_delivery_management_active"><a href="{{ route('cityadmin.view.delivery.management') }}"><i class="fa fa-picture-o"></i> <span>Delivery Management</span></a></li>
                        <li class="s_meun ct_profile_management_active"><a href="{{ route('cityadmin.view.profile.management') }}"><i class="fa fa-picture-o"></i> <span>Profile Management</span></a></li>
                        <li class="s_meun ct_withdrawal_management_active"><a href="{{ route('cityadmin.view.Withdrawal.management') }}"><i class="fa fa-picture-o"></i> <span>Wallet/ Withdrawal</span></a></li>
                        <li class="s_meun ct_mis_management_active"><a href=""><i class="fa fa-picture-o"></i> <span>MIS</span></a></li>
                        
                    </ul>
                </li>


                <!--Settings end-->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>