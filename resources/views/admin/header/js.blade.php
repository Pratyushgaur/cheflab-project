
   <!-- jQuery 3 -->
  <script src="{{asset('commonarea/bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('commonarea/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- iCheck -->
  <script src="{{asset('commonarea/plugins/toaster/jquery.toast.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/js_common_validations.js')}}"></script>
    <script type="text/javascript" src="{{asset('controller_js/login.js')}}"></script>

  <script>
    $(".pass-show").on('click', function() {
      var passwordId = $(this).siblings();
      console.log("passwordId........", passwordId)
      if (passwordId.attr("type") === "password") {
        passwordId.attr("type", "text");
        $(this).find("i").removeClass("fa-eye-slash")
        $(this).find("i").addClass("fa-eye")
      } else {
        passwordId.attr("type", "password");
        $(this).find("i").addClass("fa-eye-slash")
        $(this).find("i").removeClass("fa-eye")
      }
    })
  </script>
     <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

  <script type="text/javascript">
      function success_toast(title = '', message = '') {
    $.toast({
      heading: title,
      text: message,
      icon: 'success',
      loader: true, // Change it to false to disable loader
      loaderBg: '#9EC600', // To change the background,
      position: "bottom-right"
    });
  }

  function fail_toast(title = '', message = '') {
    $.toast({
      heading: title,
      text: message,
      icon: 'error',
      loader: true, // Change it to false to disable loader
      loaderBg: '#9EC600', // To change the background,
      position: "bottom-right"
    });
  }

  $(document).ready(function() {
    let $is_set_success_message = "{{ Session('message') ? 'yes' : 'no'; }}";
    if ($is_set_success_message == "yes") {
      success_toast(title = 'Success', message = "{{ Session('message') }}");
    }

    let $is_set_fail_message = "{{ Session('error') ? 'yes' : 'no'; }}";
    if ($is_set_fail_message == "yes") {
      fail_toast(title = 'Error', message = "{{ Session('error') }}");
    }
  });
  </script>

