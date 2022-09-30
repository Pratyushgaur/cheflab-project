
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
	  		<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  <i class="nav-icon fas fa-edit"></i>
				  <p>
					System Master
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{ route('city') }}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>City</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{route('admin.category.create')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Food Categories</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{route('admin.cuisines.create')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Cuisines Categories</p>
						</a>
					</li>
					
				</ul>
			</li>
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  <i class="nav-icon fas fa-users"></i>
				  <p>
					 User Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
				    
					<li class="nav-item">
						<a href="{{route('admin.vendors.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>All Vendors</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>All Delivery Boy</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>App Users</p>
						</a>
					</li>
				</ul>
			</li>
			
			<li class="nav-item">
				<a href="{{route('admin.product.cheflabProduct')}}" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Product Management</p>
				</a>
			</li>  
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				<i class="nav-icon fa fa-star"></i>
				  <p>
					 Vendor Request
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="{{route('admin.vendor.pendigProduct')}}" class="nav-link">
						<i class="fa fa-arrow-right nav-icon"></i>
						<p>Product Request</p>
						</a>
					</li>
					<li class="nav-item">
                      	<a href="{{route('admin.slotebook.list')}}" class="nav-link">
					  		<i class="fa fa-arrow-right nav-icon"></i>
                        	<p>Banner Request</p>
						</a>
                  	</li>
				</ul>
			</li>
			 
			<li class="nav-item">
				<a href="{{route('admin.coupon.list')}}" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Coupon Management</p>
				</a>
			</li>  
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  
				  <i class="far fa-circle nav-icon "></i>
				  <p>
					 Order Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
				    <li class="nav-item">
						<a href="{{route('admin.order.list')}}" class="nav-link">
						  <i class="fa fa-arrow-right nav-icon"></i>
						  <p>Vendor Orders</p>
						</a>
					</li>	
				</ul>
			</li>
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  
				  <i class="fa fa-bullhorn  nav-icon"></i>
				  <p>
				  	Promotion Management 
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">

					<li class="nav-item">
						<a href="{{route('admin.root.banner')}}" class="nav-link">
							<i class="fa fa-arrow-right nav-icon"></i>
							<p>Root Banner</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="{{route('admin.banner.createbanner')}}" class="nav-link">
						<i class="fa fa-arrow-right nav-icon"></i>
						<p>Banner Promotion</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{route('admin.application.blog')}}" class="nav-link">
						<i class="fa fa-arrow-right nav-icon"></i>
						<p>Application Blog</p>
						</a>
					</li>-->
					
					
					
						
				</ul>
			</li>
			
			<li class="nav-item">
				<a href="{{route('admin.coupon.list')}}" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Notification</p>
				</a>
			</li>  
			<li class="nav-item">
				<a href="{{route('admin.coupon.list')}}" class="nav-link">
				  <i class="far fa-user nav-icon"></i>
				  <p>Reffer & Earn</p>
				</a>
			</li>  
			
			
			
		
			<li class="nav-item has-treeview">
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
			</li>
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
				  
				  <i class="far fa-user nav-icon"></i>
				  <p>
					 Content Management
					<i class="fas fa-angle-left right"></i>
				  </p>
				</a>
				<ul class="nav nav-treeview">
				    <li class="nav-item">
						<a href="#" class="nav-link">
						  <i class="far fa-circle nav-icon"></i>
						  <p>All Orders</p>
						</a>
					</li>	
				</ul>
			</li>
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
  