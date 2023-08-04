
	<?php 
		$role_id = Auth::guard('admin')->user()->role_id;
		
	?>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="index3.html" class="brand-link">
      <img src="{{asset('commonarea/logo-white.png')}}" alt="cheflab Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CHEFLAB ADMIN</span>
    </a> -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('commonarea/logo-white.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">CHEFLAB ADMIN</a>
        </div>
      </div>

      <nav class="mt-2">
	  <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
	  		<li class="nav-item">
				<a href="{{route('admin.dashboard')}}" class="nav-link">
				  <i class="nav-icon fas fa-tachometer-alt"></i>
				  <p>Dashboard</p>
				</a>
			</li>
			@if(checkAccess('order_management',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">

				  <i class="far fa-circle nav-icon "></i>
				  <p>
					 Order Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('vendor_order',$role_id))
				    <li class="nav-item">
						<a href="{{route('admin.order.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Vendor Orders</p>
						</a>
					</li>
					@endif
					@if(checkAccess('vendor_dashboard',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.order.dashboard')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Order Dashbord</p>
						</a>
					</li>
					@endif
					<!-- <li class="nav-item">
						<a href="{{route('admin.dineout.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Dineout Orders</p>
						</a>
					</li> -->
				</ul>
			</li>
			@endif
			@if(checkAccess('system_master',$role_id))
	  		<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  <i class="nav-icon fas fa-edit"></i>
				  <p>
					System Master
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('city',$role_id))
					<li class="nav-item">
						<a href="{{ route('city') }}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>City</p>
						</a>
					</li>
					@endif
					@if(checkAccess('food_category',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.category.create')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Food Categories</p>
						</a>
					</li>
					@endif
					@if(checkAccess('food_cuisines',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.cuisines.create')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Cuisines Categories</p>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@if(checkAccess('user_management',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  <i class="nav-icon fas fa-users"></i>
				  <p>
					 User Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('all_vendor',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.vendors.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>All Vendors</p>
						</a>
					</li>
					@endif
					@if(checkAccess('app_user',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.user.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>App Users</p>
						</a>
					</li>
					@endif
					@if(checkAccess('system_user',$role_id))

					<li class="nav-item">
						<a href="{{route('admin.system.user.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>System Users</p>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@if(checkAccess('role_management',$role_id))
			<li class="nav-item">
				<a href="{{route('admin.role.list')}}" class="nav-link">
				  <i class="nav-icon fa fa-cog"></i>
				  <p>Role Management</p>
				</a>
			</li>
			@endif
			@if(checkAccess('delivery_management',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  <i class="nav-icon fas fa-users"></i>
				  <p>
					 Deliveryboy Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('all_delivery_boy',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.deliverboy.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>All Delivery Boy</p>
						</a>
					</li>
					@endif
					@if(checkAccess('rider_live_map',$role_id))
					<li class="nav-item">
						<a href="{{route('driver_map')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Rider Live Map</p>
						</a>
					</li>
					@endif
					<!-- <li class="nav-item">
						<a href="{{route('admin.deliverboy.review')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Delivery Boy Review</p>
						</a>
					</li> -->
					@if(checkAccess('setting',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.deliverboy.setting')}}" class="nav-link">
						<i class="nav-icon fa fa-cog"></i>
						  <p>Setting</p>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			<!-- <li class="nav-item">
				<a href="{{route('admin.product.cheflabProduct')}}" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Product Management</p>
				</a>
			</li> -->
			@if(checkAccess('vendor_request',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				<i class="nav-icon fa fa-star"></i>
				  <p>
					 Vendor Request
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('product_request',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.vendor.pendigProduct')}}" class="nav-link">
						<i class="fa fa-arrow-right nav-icon"></i>
						<p>Product Request</p>
						</a>
					</li>
					@endif
					@if(checkAccess('banner_request',$role_id))
					<li class="nav-item">
                      	<a href="{{route('admin.slotebook.list')}}" class="nav-link">
					  		<i class="fa fa-arrow-right nav-icon"></i>
                        	<p>Banner Request</p>
						</a>
                  	</li>
					  @endif
				</ul>
			</li>
			@endif
			@if(checkAccess('coupon_management',$role_id))
			<li class="nav-item">
				<a href="{{route('admin.coupon.list')}}" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Coupon Management</p>
				</a>
			</li>
			@endif

			@if(checkAccess('promotion_management',$role_id))
			
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">

				  <i class="fa fa-bullhorn  nav-icon"></i>
				  <p>
				  	Promotion Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('admin_banner',$role_id))

					<li class="nav-item">
						<a href="{{route('admin.root.banner')}}" class="nav-link">
							<i class="fa fa-arrow-right nav-icon"></i>
							<p>Admin Banners</p>
						</a>
					</li>
					@endif
					@if(checkAccess('banner_promotion',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.banner.createbanner')}}" class="nav-link">
						<i class="fa fa-arrow-right nav-icon"></i>
						<p>Banner Promotion</p>
						</a>
					</li>
					@endif
					@if(checkAccess('application_blog',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.application.blog')}}" class="nav-link">
						<i class="fa fa-arrow-right nav-icon"></i>
						<p>Application Blog</p>
						</a>
					</li>
					@endif




				</ul>
			</li>
			@endif
			@if(checkAccess('push_notification',$role_id))
			<li class="nav-item">
				<a href="{{route('admin.notification.view')}}" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Push Notification</p>
				</a>
			</li>
			@endif
			@if(checkAccess('reffer_and_earn',$role_id))

			<li class="nav-item">
				<a href="{{route('admin.refe.earn')}}" class="nav-link">
				  <i class="far fa-user nav-icon"></i>
				  <p>Refer & Earn</p>
				</a>
			</li>
			@endif



			<!-- <li class="nav-item has-treeview">
				<a href="#" class="nav-link">


				  <i class="fa fa-book nav-icon"></i>
				  <p>
				  	Account Settlement
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
				    <li class="nav-item">
						<a href="#" class="nav-link">
						  <i class="fa fa-arrow-right  nav-icon"></i>
						  <p>All Orders</p>
						</a>
					</li>
				</ul>
			</li> -->
			@if(checkAccess('mis_and_account',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  <i class="fa fa-book nav-icon"></i>
				  <p>
				  MIS & Account Settlement
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('mis',$role_id))
				    <li class="nav-item">
						<a href="{{ route('admin.account.mis.list') }}" class="nav-link">
						  <i class="fa fa-arrow-right  nav-icon"></i>
						  <p>MIS</p>
						</a>
					</li>
					@endif
					@if(checkAccess('account_settlement',$role_id))
					<li class="nav-item">

						<div class="dropdown pl-1 pb-2">
							<a href="#" class="px-3" data-toggle="dropdown"> <i class="far fa-circle nav-icon"></i> Account Settlement <i class="fas fa-angle-down right pl-2"></i></a>
							<div class="dropdown-menu custombox pl-3">
								<a class="dropdown-item" href="{{ route('admin.account.vendor.list') }}">								
									<p class="mb-0"><i class="fa fa-arrow-right  nav-icon" style="font-size:12px;"></i>  Vendor</p>
							   </a>
							   <a class="dropdown-item" href="{{ route('admin.account.rider.list') }}">								
									<p class="mb-0 "><i class="fa fa-arrow-right  nav-icon"  style="font-size:12px;"></i>  Rider</p>
							   </a>
							</div>
						</div>


					</li>
					@endif
					@if(checkAccess('invoice',$role_id))
					<li class="nav-item">

						<div class="dropdown pl-1 pb-2">
							<a href="#" class="px-3" data-toggle="dropdown"> <i class="far fa-circle nav-icon"></i> Invoices <i class="fas fa-angle-down right pl-2"></i></a>
							<div class="dropdown-menu custombox pl-3">
								<a class="dropdown-item" href="{{ route('admin.account.vendor.invoices.generate') }}">								
									<p class="mb-0"><i class="fa fa-arrow-right  nav-icon" style="font-size:12px;"></i>  Generate</p>
							   </a>
							   <a class="dropdown-item" href="{{ route('admin.account.mis.invoices') }}">								
									<p class="mb-0 "><i class="fa fa-arrow-right  nav-icon"  style="font-size:12px;"></i>  Invoices List</p>
							   </a>
							</div>
						</div>
					</li>
					@endif
					<!-- <li class="nav-item">
						<a href="{{ route('admin.account.mis.invoices') }}" class="nav-link">
						  <i class="fa fa-arrow-right  nav-icon"></i>
						  <p>Invoices</p>
						</a>
					</li> -->
				</ul>
			</li>
			@endif
			@if(checkAccess('content_management',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">

				  <i class="far fa-user nav-icon"></i>
				  <p>
					 Content Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('user_content',$role_id))
				    <li class="nav-item">
						<a href="{{route('admin.user.contentmanagement')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>User Content</p>
						</a>
					</li>
					@endif
					@if(checkAccess('vendor_content',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.vendor.contentmanagement')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>Vendor Content</p>
						</a>
					</li>
					@endif
					@if(checkAccess('delivery_boy_content',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.dliveryboy.contentmanagement')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>Deliveryboy Content</p>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@if(checkAccess('feedback',$role_id))
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">

				  <i class="far fa-user nav-icon"></i>
				  <p>
					 Feedback
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					@if(checkAccess('app_feedback',$role_id))
				    <li class="nav-item">
						<a href="{{route('admin.app.feedbacklist')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>App Feedback</p>
						</a>
					</li>
					@endif
					@if(checkAccess('vendor_feedback',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.app.vendorfeedbacklist')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>Vendor Feedback</p>
						</a>
					</li>
					@endif
					@if(checkAccess('delivery_boy_feedback',$role_id))
					<li class="nav-item">
						<a href="{{route('admin.app.deliveryfeedbacklist')}}" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>Delivery Boy Feedback</p>
						</a>
					</li>
					@endif
				</ul>
			</li>
			@endif
			@if(checkAccess('refund',$role_id))
			<li class="nav-item">
				<a href="{{route('admin.refund.list')}}" class="nav-link">
				  <i class="nav-icon fa fa-cog"></i>
				  <p>Refund</p>
				</a>
			</li>
			@endif
			@if(checkAccess('globle_setting',$role_id))
			<li class="nav-item">
				<a href="{{route('admin.globle.setting')}}" class="nav-link">
				  <i class="nav-icon fa fa-cog"></i>
				  <p>Global Setting</p>
				</a>
			</li>
			@endif
			@if(checkAccess('payout_setting',$role_id))
			<li class="nav-item">
				<a href="{{route('admin.payout.setting')}}" class="nav-link">
				  <i class="nav-icon fa fa-cog"></i>
				  <p>Payout Setting</p>
				</a>
			</li>
			@endif
			<!-- <li class="nav-item">
				<a href="{{route('admin.globle.productactive')}}" class="nav-link">
				  <i class="nav-icon fa fa-cog"></i>
				  <p>Product Active</p>
				</a>
			</li> -->
			<li class="nav-item">
				<a href="{{route('admin.logout')}}" class="nav-link">
				  <i class="nav-icon fas fa-power-off"></i>
				  <p>Logout</p>
				</a>
			</li>
		</ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
