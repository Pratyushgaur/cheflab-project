<footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="http://adminlte.io/">CHEFLAB</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0-rc.3
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script src="{{asset('commonarea/ass/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('commonarea/ass/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- jQuery Mapael -->
<script src="{{asset('commonarea/ass/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('commonarea/ass/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('commonarea/ass/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('commonarea/ass/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('commonarea/ass/plugins/chart.js/Chart.min.js')}}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{asset('commonarea/ass/dist/js/pages/dashboard2.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<!-- Bootstrap 4 -->
<script src="{{asset('commonarea/ass/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('commonarea/ass/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('commonarea/ass/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->

<!-- jQuery Knob Chart -->
<script src="{{asset('commonarea/ass/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('commonarea/ass/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('commonarea/ass/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('commonarea/ass/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('commonarea/ass/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('commonarea/ass/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('commonarea/ass/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- AdminLTE for demo purposes -->
<script src="{{asset('commonarea/ass/dist/js/demo.js')}}"></script>


<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script src="{{asset('commonarea/ass')}}/dist/js/adminlte.min.js"></script>
<script src="{{asset('commonarea/ass')}}/plugins/dropzone/min/dropzone.min.js"></script>
<script src="{{asset('commonarea/ass')}}/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="{{asset('commonarea/ass')}}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="{{asset('commonarea/ass')}}/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- sweatalert -->
<!-- <script src="{{asset('commonarea/ass')}}/plugins/sweetalert2/sweetalert2.min.js"></script> -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('commonarea/ass')}}/plugins/toastr/toastr.min.js"></script>
<script src="{{asset('commonarea/ass')}}/plugins/select2/js/select2.full.min.js"></script>

<!-- sweatalert -->

<!-- this is footer ending -->

@yield('js_section')

<!-- delete records -->
<script>
  $(document).ready(function(){
    
    $(document).on('click','.delete-record',function(){
      

        Swal.fire({
            title: 'Are you sure?',
            text: $(this).attr('data-alert-message'),
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
              var id = $(this).attr('data-id');
              var action = $(this).attr('data-action-url');
              var table = $(this).attr('data-table');
              //
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              $.ajax({
                  url: action,
                  type: 'POST',
                  // dataType: "JSON",
                  data: {
                      "id": id,
                  },
                  success: function (response)
                  {
                      //console.log();
                      if (response.success == true) {
                        Swal.fire({icon: 'success',title: 'Good',text: response.message, footer: ''});
                        $('#example').DataTable().ajax.reload();
                      } else {
                        Swal.fire({icon: 'error',title: 'Oops...',text: response.error_message, footer: ''});
                      }
                  },
                  error: function(xhr) {
                  console.log(xhr.responseText); 
                  
                }
              });

            }
        })
    })
    
    
  })
</script>
@if (\Session::has('message'))
    <script>
       $(document).ready(function(){
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Success',
            subtitle: '',
            body: '<?php echo  \Session::get('message'); ?>'
          })
       });
    </script>                
    
@endif

</body>
</html>