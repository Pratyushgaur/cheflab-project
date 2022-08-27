
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login V17</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">



<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/fontawesome.min.css" integrity="sha512-R+xPS2VPCAFvLRy+I4PgbwkWjw1z5B5gNDYgJN5LfzV4gGNeRQyVrY7Uk59rX+c8tzz63j8DeZPLqmXvBxj8pA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
<link rel="stylesheet" href="{{asset('commonarea/backend/plugins/fontawesome-free/css/all.min.css')}}">

<!-- <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css"> -->
<link rel="stylesheet" href="path/iconfont/css/iconfont.min.css">

<!-- <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css"> -->
<link rel="stylesheet" href="path/iconfont/css/iconfont-animate.min.css">


<link rel="stylesheet" type="text/css" href="{{asset('login/util.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('login/main.css')}}">

<body>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <form class="login100-form validate-form">
          <span class="login100-form-title p-b-34">
            Account Login
          </span>
          <div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
            <input id="first-name" class="input100" type="text" name="username" placeholder="User name">
            <span class="focus-input100"></span>
          </div>
          <div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
            <input class="input100" type="password" name="pass" placeholder="Password">
            <span class="focus-input100"></span>
          </div>
          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
            Sign in
            </button>
          </div>
          <div class="w-full text-center p-t-27 p-b-239">
            <span class="txt1">
              Forgot
            </span>
            <a href="#" class="txt2">
              User name / password?
            </a>
          </div>
          <div class="w-full text-center">
            <a href="#" class="txt3">
              Sign Up
            </a>
          </div>
        </form>
        <div class="login100-more" style="background-image: url('{{asset('login/loginbanner.jpg')}}');"></div>
      </div>
    </div>
  </div>
  <div id="dropDownSelect1"></div>

  <script src="{{asset('commonarea/backend/plugins/jquery/jquery.min.js')}}"></script> 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</body>
</html>
