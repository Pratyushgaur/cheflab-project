<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cheflab</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 


  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/fontawesome-free/css/all.min.css')}}">
	<!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/dist/css/ionicons.min.css')}}">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- jQuery -->
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
  <script src="{{asset('commonarea/backend/plugins/jquery/jquery.min.js')}}"></script> 

  <style type="text/css">
    .error{
      font-size: 13px;
    color: red;
    }
  </style>


  <!-- Tell the browser to be responsive to screen width -->
 
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition register-page">
<div class="register-box">


  <div class="card">
    <div class="card-body register-card-body">
      <h1> <img src="{{asset('commonarea/logo.png')}}" style="height: 170px;margin-left:60px;" alt="logo"></h1>

		<form id="laravelAdminLoginForm" action="{{ url('check-login-for-admin') }}" method="post">
			@csrf
		   
			<div class="input-group mb-3">
			  <input type="text" name="email" class="form-control" placeholder="Email" required>
			  
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fas fa-user"></span>
				</div>
			  </div>
			</div>
		
			<div class="input-group mb-3">
			  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			  <div class="input-group-append">
				<div class="input-group-text">
				  <span class="fas fa-lock"></span>
				</div>
			  </div>
			</div>
			
			
		
			<div class="row">
			  <div class="col-8">
				<div class="icheck-primary">
				 
				</div>
			  </div>
			  <!-- /.col -->
			  <div class="col-4">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
			  </div>
			  <!-- /.col -->
			</div>
		</form>

      

      <a href="{{ url('/') }}">Forgot your password?</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>


