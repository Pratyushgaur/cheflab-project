<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cheflab</title>

  <!-- FAVICONS -->
  <!-- Toaster -->
   <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome -->
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
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet')}}">
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- jQuery -->
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('commonarea/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
  <script src="{{asset('commonarea/backend/plugins/jquery/jquery.min.js')}}"></script> 
  <script src="{{asset('commonarea/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{asset('js/jquery.validate.min.js')}}"></script>
  <style>
    .error {
      color: #FF0000;
    }

    .back-to-login-btn{
      margin-top: 7px;
      color: white;
      background-color: #760707;
      font-size: 19px;
      line-height: 1;
    }

    .back-to-login-btn:hover {
      color: white !important;
    }
  </style>

  
</head>

<!--<body class="skin-blue sidebar-mini scrollbar" id="style-7" style="height: auto; min-height: 100%;">
  <div class="loader3" id="preloader" style="display: none;">
    <span></span>
    <span></span>
  </div>
  <div id="cover-spin"></div>
  <div class="wrapper" style="height: auto; min-height: 100%;"></div>
  <input type="hidden" value="{{ URL::to('/'); }}" id="base_url">
-->