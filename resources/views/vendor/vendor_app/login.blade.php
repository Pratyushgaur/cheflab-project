<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from metropolitanhost.com/themes/themeforest/html/costic/pages/prebuilt-pages/default-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Aug 2022 10:48:30 GMT -->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Cheflab Vendor login</title>
  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('frontend')}}/vendors/iconic-fonts/flat-icons/flaticon.css">
  <link href="{{asset('frontend')}}/vendors/iconic-fonts/font-awesome/css/all.min.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link href="{{asset('frontend')}}/assets/css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery UI -->
  <link href="{{asset('frontend')}}/assets/css/jquery-ui.min.css" rel="stylesheet">
  <!-- Costic styles -->
  <link href="{{asset('frontend')}}/assets/css/style.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="../../favicon.ico">
</head>

<body class="ms-body ms-primary-theme ms-logged-out">
 
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
  <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
  <!-- Sidebar Navigation Left -->
 
  <!-- Main Content -->
  <main class="body-content">
    <!-- Navigation Bar -->
    
    <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper ms-auth">
      <div class="ms-auth-container">
        <div class="ms-auth-col">
          <div class="ms-auth-bg"></div>
        </div>
        <div class="ms-auth-col">
          <div class="ms-auth-form">
          <img src="{{URL::TO("")}}/commonarea/logo.png" alt="" style="height:200px;margin-left:70px;">
              
            <form class="needs-validation" novalidate="" action="{{route('app.action.vendor.login')}}" method="post" style="padding-top: 00px;">
            <!-- src="http://127.0.0.1:8000/commonarea/logo.png" -->
            @csrf
                @if (\Session::has('error'))
                    
                    <div class="alert alert-danger" role="alert">
                        <strong>Opps!</strong> {!! \Session::get('error') !!}.
                    </div>
                @endif
                    
              <div class="mb-3">
                <label for="validationCustom08">Email Address</label> 
                <div class="input-group">
                  <input type="email" name="email" class="form-control" id="validationCustom08" placeholder="Email Address" required="">
                  <div class="invalid-feedback">Please provide a valid email.</div>
                    @error('title')
                    <div class="invalid-feedback">Please provide a valid email.</div>
                    @enderror
                </div>
              </div>
              <div class="mb-2">
                <label for="validationCustom09">Password</label>
                <div class="input-group">
                  <input type="password" name="password" class="form-control" id="validationCustom09" placeholder="Password" required="">
                    @error('title')
                    <div class="invalid-feedback">Please provide a valid email.</div>
                    @enderror
                  <div class="invalid-feedback">Please provide a password.</div>
                </div>
              </div>
              <div class="form-group">
                <label class="ms-checkbox-wrap">
                  <input class="form-check-input" type="checkbox" value=""> <i class="ms-checkbox-check"></i>
                </label> <span> Remember Password </span>
                <label class="d-block mt-3"><a href="#" class="btn-link" data-toggle="modal" data-target="#modal-12">Forgot Password?</a>
                </label>
              </div>
              <button class="btn btn-primary mt-4 d-block w-100" type="submit">Sign In</button> 
              <!-- <p class="mb-0 mt-3 text-center">Don't have an account? <a class="btn-link" href="default-register.html">Create Account</a> 
              </p> -->
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Forgot Password Modal -->
    <div class="modal fade" id="modal-12" tabindex="-1" role="dialog" aria-labelledby="modal-12">
      <div class="modal-dialog modal-dialog-centered modal-min" role="document">
        <div class="modal-content">
          <div class="modal-body text-center">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button> <i class="flaticon-secure-shield d-block"></i>
            <h1>Forgot Password?</h1>
            <p class="msg-txt">Enter your email to recover your password</p>
            <form method="post" action="" id="form-forget">
              @csrf
              <div class="ms-form-group has-icon email-input">
                <input type="text" placeholder="Email Address" name="email" class="form-control email" name="forgot-password" value=""> <i class="material-icons">email</i>
                <br><span class="text-danger forget-email-error"></span>
              </div>
              
              <div class="ms-form-group has-icon otp-input" style="display:none">
                <input type="text" placeholder="Enter One Time Password" class="form-control otp" name="forgot-password" value=""> <i class="material-icons">key</i>
                <br><span class="text-danger forget-email-error"></span>
              </div>
              <div class="ms-form-group has-icon changepass-input" style="display:none">
                <input type="password" placeholder="Enter New Password" class="form-control new_pass" name="" value=""> <i class="material-icons">key</i>
                <br><span class="text-danger forget-email-error"></span>
              </div>
              <div class="form-btn">
                <button type="button" class="btn btn-primary shadow-none check">Check Account </button>
              </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!-- SCRIPTS -->
  <!-- Global Required Scripts Start -->
  <script src="{{asset('frontend')}}/assets/js/jquery-3.5.0.min.js"></script>
  <script src="{{asset('frontend')}}/assets/js/popper.min.js"></script>
  <script src="{{asset('frontend')}}/assets/js/bootstrap.min.js"></script>
  <script src="{{asset('frontend')}}/assets/js/perfect-scrollbar.js">
  </script>
  <script src="{{asset('frontend')}}/assets/js/jquery-ui.min.js">
  </script>
  <!-- Global Required Scripts End -->
  <!-- Costic core JavaScript -->
  <script src="{{asset('frontend')}}/assets/js/framework.js"></script>
  <!-- Settings -->
  <script src="{{asset('frontend')}}/assets/js/settings.js"></script>
  <script>
    $(document).ready(function(){
      $('.check').click(function(){
        var email = $('.email').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                  url: "{{route('action.vendor.changepass')}}",
                  type: 'POST',
                  // dataType: "JSON",
                  data: {
                      "email": email,
                  },
                  success: function (response)
                  {
                      if(!response.status){
                        $('.forget-email-error').text(response.error);
                      }else{
                        $('.msg-txt').text("We Have Sent OTP In your Register  Mobile Number");
                        $('.email-input').hide();
                        $('.otp-input').show();
                        $('.check').remove();
                        $('.form-btn').html('<button type="button" class="btn btn-primary shadow-none verify">Verify OTP </button>');

                      }
                  },
                  error: function(xhr) {
                  console.log(xhr.responseText); 
                  
                }
              });
      });

      $(document).on('click','.verify',function(){
        var email = $('.email').val();
        var otp = $('.otp').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                  url: "{{route('action.vendor.verify_pass')}}",
                  type: 'POST',
                  // dataType: "JSON",
                  data: {
                      "email": email,
                      "otp": otp,
                  },
                  success: function (response)
                  {
                      if(!response.status){
                        $('.forget-email-error').text(response.error);
                      }else{
                        $('.msg-txt').text("Enter New Password");
                        $('.otp-input').hide();
                        $('.changepass-input').show();
                        $('.check').remove();
                        $('.form-btn').html('<button type="button" class="btn btn-primary shadow-none change_pass_btn">Change New Password </button>');
                      }
                  },
                  error: function(xhr) {
                  console.log(xhr.responseText); 
                  
                }
              });
      })
      $(document).on('click','.change_pass_btn',function(){
        var new_pass = $('.new_pass').val();
        var email = $('.email').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                  url: "{{route('action.vendor.change_new_pass')}}",
                  type: 'POST',
                  // dataType: "JSON",
                  data: {
                      "email": email,
                      "new_pass": new_pass,
                  },
                  success: function (response)
                  {
                      if(!response.status){
                        $('.forget-email-error').text(response.error);
                      }else{
                        $('.modal').modal('hide');

                      }
                  },
                  error: function(xhr) {
                  console.log(xhr.responseText); 
                  
                }
              });
      })
    })
  </script>
</body>


<!-- Mirrored from metropolitanhost.com/themes/themeforest/html/costic/pages/prebuilt-pages/default-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Aug 2022 10:48:30 GMT -->
</html>