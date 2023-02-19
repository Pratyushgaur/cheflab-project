<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from metropolitanhost.com/themes/themeforest/html/costic/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Aug 2022 10:35:47 GMT -->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Cheflab || Restaurant Dashboard</title>
  <link rel="icon" type="image/x-icon" href="{{asset('cheflab-fav-icon.png')}}">

  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="{{asset('frontend')}}/vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('frontend')}}/vendors/iconic-fonts/flat-icons/flaticon.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/vendors/iconic-fonts/cryptocoins/cryptocoins.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/vendors/iconic-fonts/cryptocoins/cryptocoins-colors.css">
  <!-- Bootstrap core CSS -->
  <link href="{{asset('frontend')}}/assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery UI -->
  <link href="{{asset('frontend')}}/assets/css/jquery-ui.min.css" rel="stylesheet">
  <!-- Page Specific CSS (Slick Slider.css) -->
  <link href="{{asset('frontend')}}/assets/css/slick.css" rel="stylesheet">
  <link href="{{asset('frontend')}}/assets/css/image-zoom/demo.css" rel="stylesheet">
  <link href="{{asset('frontend')}}/assets/css/image-zoom/style.css" rel="stylesheet">
  <link href="{{asset('frontend')}}/assets/css/datatables.min.css" rel="stylesheet">
  <!-- Costic styles -->
  <link href="{{asset('frontend')}}/assets/css/style.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="favicon.ico">
  <!-- select 2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/mis.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend') }}/assets/css/toastr.min.css" rel="stylesheet">
{{--    <link href="{{ asset('frontend') }}/assets/toasty/toasty.min.css" rel="stylesheet">--}}

{{-- msg bar shows on top --}}
  <style>
  #message-box {
    width: 100%;
    background-color: #FFA339;
    height: 30px;
    line-height: 30px;
    text-align: center;
    font-size: 15px;
    color: #35220C;
    position: absolute;
    top: 0;
    z-index: 50;
    font-weight: bold;
    transform: translateY(-100%);
    transition: transform .6s;
    opacity: 0.7;
  }

  #message-box.show {
    transform: none;
  }
    .ms-text-danger{width: 100%;}

    .modal-backdrop {
        /* bug fix - no overlay */
        display: none;
    }

      .error{
          width: 100% !important;
          color:red;
      }
    </style>
 @yield('page-css')

</head>

<body class="ms-body @if(!isset($hideSidebar)) ms-aside-left-open @endif ms-primary-theme @if(!isset($hideSidebar))  ms-has-quickbar @endif ">

  <!-- Preloader -->
  <div id="preloader-wrap">
    <div class="spinner spinner-8">
      <div class="ms-circle1 ms-child"></div>
      <div class="ms-circle2 ms-child"></div>
      <div class="ms-circle3 ms-child"></div>
      <div class="ms-circle4 ms-child"></div>
      <div class="ms-circle5 ms-child"></div>
      <div class="ms-circle6 ms-child"></div>
      <div class="ms-circle7 ms-child"></div>
      <div class="ms-circle8 ms-child"></div>
      <div class="ms-circle9 ms-child"></div>
      <div class="ms-circle10 ms-child"></div>
      <div class="ms-circle11 ms-child"></div>
      <div class="ms-circle12 ms-child"></div>
    </div>
  </div>
  <!-- Overlays -->
  <div class="ms-aside-overlay ms-overlay-left ms-toggler " data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
  <!-- Sidebar Navigation Left -->

{{-- restaurant offline msg on top bar  --}}
    @if (!Auth::guard('vendor')->user()->is_online)
    <div id='message-box'>Now your restaurant is offline,you will not able to get orders from mobile app.<a href="#" style="float: right;    margin-right: 18px;" id="close_msg_bar">X</a></div>
    @endif
{{--  <audio controls autoplay>--}}
{{--      <source src="horse.ogg" type="audio/ogg">--}}
{{--      <source src="{{url('/notification-sound.mp3')}}" type="audio/mpeg">--}}
{{--      Your browser does not support the audio element.--}}
{{--  </audio>--}}

{{--  <audio id="chatAudio"  controls autoplay>--}}
{{--      <source src="notify.ogg" type="audio/ogg">--}}
{{--      <source id="chatAudio1" src="{{url('/notification-sound.mp3')}}" type="audio/mpeg">--}}
{{--  </audio>--}}
