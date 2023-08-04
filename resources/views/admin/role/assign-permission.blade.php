@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
    
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
        .image-upload{
            display:inline-block;
            margin-right:15px;
            position:relative;
        }
        .image-upload > input
        {
            display: none;
        }
        .upload-icon{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        .upload-icon img{
          width: 100px;
          height: 100px;
          margin:19px;
          cursor: pointer;
        }
        
        
        .upload-icon.has-img {
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon.has-img img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        /*  */
        .upload-icon2{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon2 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon2.has-img2{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon2.has-img2 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
      </style>
@endsection
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Assign Permission</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Role</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		  <div class="row">
			
		
          <div class="col-md-12">
          
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Create</h3>

                  <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.role.assign.permission.post',$encrypt_id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="order_management" value="1"> Order Management </h1>
                                <label><input type="checkbox" name="vendor_order" value="admin.order.list"> Vendor-Order</label>
                                <label><input type="checkbox" name="vendor_dashboard" value="admin.order.dashboard"> Order-Dashboard</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="system_master" value="1"> System Master </h1>
                                <label><input type="checkbox" name="city" value="city"> City</label>
                                <label><input type="checkbox" name="food_category" value="admin.category.create"> Food-Category</label>
                                <label><input type="checkbox" name="food_cuisines" value="admin.cuisines.create"> Food-Cuisines</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="user_management" value="1"> User Management </h1>
                                <label><input type="checkbox" name="all_vendor" value="admin.vendors.list"> All Vendor</label>
                                <label><input type="checkbox" name="app_user" value="admin.user.list"> App-User</label>
                                <label><input type="checkbox" name="system_user" value="admin.system.user.list"> System-User</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="role_management" value="admin.role.list"> Role Management </h1>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="delivery_management" value="1"> Delivery Management </h1>
                                <label><input type="checkbox" name="all_delivery_boy" value="admin.deliverboy.list"> All Delivery Boy</label>
                                <label><input type="checkbox" name="rider_live_map" value="driver_map"> Rider Live Map</label>
                                <label><input type="checkbox" name="setting" value="admin.deliverboy.setting"> Setting</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="vendor_request" value="1"> Vendor Request </h1>
                                <label><input type="checkbox" name="product_request" value="admin.vendor.pendigProduct"> Product Request</label>
                                <label><input type="checkbox" name="banner_request" value="admin.slotebook.list"> Banner Request</label>
                                
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="coupon_management" value="admin.coupon.list"> Coupon Management </h1>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="promotion_management" value="1"> Promotion Management </h1>
                                <label><input type="checkbox" name="admin_banner" value="admin.root.banner"> Admin Banner</label>
                                <label><input type="checkbox" name="banner_promotion" value="admin.banner.createbanner"> Banner Promotion</label>
                                <label><input type="checkbox" name="application_blog" value="admin.application.blog"> Application Blog</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="push_notification" value="admin.notification.view"> Push Notification </h1>
                            </div>
                            <br>
                            
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="reffer_and_earn" value="admin.refe.earn"> Reffer & earn Management </h1>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="mis_and_account" value="1"> Mis & Account Settlement</h1>
                                <label><input type="checkbox" name="mis" value="admin.account.mis.list"> Mis</label>
                                <label><input type="checkbox" name="account_settlement" value="1"> Account settlement</label>
                                <label><input type="checkbox" name="invoice" value="1"> Invoice</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="content_management" value="1"> Content Management</h1>
                                <label><input type="checkbox" name="user_content" value="admin.user.contentmanagement"> User Content</label>
                                <label><input type="checkbox" name="vendor_content" value="admin.vendor.contentmanagement"> Vendor Content</label>
                                <label><input type="checkbox" name="delivery_boy_content" value="admin.dliveryboy.contentmanagement"> Delivery Boy Content</label>
                                
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="feedback" value="1"> Feedback</h1>
                                <label><input type="checkbox" name="app_feedback" value="admin.app.feedbacklist"> App Feedback</label>
                                <label><input type="checkbox" name="vendor_feedback" value="admin.app.vendorfeedbacklist"> Vendor Feedback</label>
                                <label><input type="checkbox" name="delivery_boy_feedback" value="admin.app.deliveryfeedbacklist"> Delivery Boy Feedback</label>
                                
                            </div>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="refund" value="1"> Refund </h1>
                            </div>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="globle_setting" value="1"> Globle Setting </h1>
                            </div>
                            <div class="col-md-12">
                                <h1 class=""><input type="checkbox" name="payout_setting" value="1"> Payout Setting </h1>
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <!-- /.card-body -->
              </div>
              
            
            <!-- /.card -->
				  </div>

        
                  
      </div>
    </section>
        <!-- /.content -->
  </div>
    <!-- /.content-wrapper -->

    <!-- /.content-wrapper -->

    <!-- /.row -->
@endsection


@section('js_section')
    <script>
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>

<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.role.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'role_name', name: 'name'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#restaurant-form").validate({
      rules: {
            name: {
                required: true,
                maxlength: 20,
                remote: '{{route("check-duplicate-category")}}',
            },
            position: {
                required: true,
                number: true,
            },
            categoryImage:{
              required: true,
              image: true,
            }
        },
        messages: {
            name: {
                remote:"Category  Already Exist",
            },
            position:{
                remote:"Position Required",
            },
            categoryImage:{
                remote:"Image Required",
            }
            
        }
      });
      $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
      $('#file-input2').change( function(event) {
          $("img.icon2").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon2").parents('.upload-icon2').addClass('has-img2');
      });
    </script>
@endsection