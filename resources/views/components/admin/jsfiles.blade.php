</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<!-- jQuery UI 1.11.4 -->
<script src="{{asset('commonarea/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('commonarea/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{asset('commonarea/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('commonarea/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('commonarea/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('commonarea/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('commonarea/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('commonarea/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('commonarea/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('commonarea/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('commonarea/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- timepicker -->
<script src="{{asset('commonarea/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
<script src="{{asset('commonarea/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('commonarea/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('commonarea/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('commonarea/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('commonarea/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('commonarea/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('commonarea/dist/js/demo.js')}}"></script>
<script src="{{asset('commonarea/plugins/iCheck/icheck.js')}}"></script>
<script src="{{asset('commonarea/plugins/iCheck/icheck.min.js')}}"></script>
<script src="{{asset('commonarea/plugins/file-manager/js/file-manager-panel.js')}}"></script>
<script src="{{asset('commonarea/plugins/file-manager/js/jquery.dm-uploader.min.js')}}"></script>
<script src="{{asset('commonarea/plugins/file-manager/js/ui.js')}}"></script>

<script src="{{asset('commonarea/multiple-select-assets/multiple-select.js')}}"></script>

<!-- AdminLTE for summernote -->
<script src="{{asset('commonarea/plugins/summernote/summernote.js')}}"></script>
<!-- select2.min start -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script src="{{asset('js/sweetalert.js')}}"></script> -->


<script type="text/javascript" src="{{asset('controller_js/common/common.js')}}"></script>

<link rel="stylesheet" href="{{asset('commonarea/plugins/toaster/jquery.toast.min.css')}}">
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<script src="{{asset('commonarea/plugins/toaster/jquery.toast.min.js')}}"></script>
<!-- dynamically class name added -->

<script>
  function loadFunction() {
    $('#preloader').hide();
  }
  function change_img(img, preview_img) {
       var oFReader = new FileReader();
       oFReader.readAsDataURL($('#' + img)[0].files[0]);
   
       oFReader.onload = function(oFREvent) {
           $('#' + preview_img).attr('src', oFREvent.target.result);
       }
   }
</script>

<script>
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

    <?php if (count($errors) > 0):?>
      fail_toast(title = 'Error', message = "{{ $errors }}");
   <?php  endif; ?>
  });
</script>
</body>

</html>