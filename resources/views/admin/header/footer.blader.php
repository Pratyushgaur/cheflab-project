<script src="{{asset('commonarea/backend/plugins/jquery/jquery.min.js')}}">

</script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('commonarea/backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('commonarea/backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('commonarea/backend/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('commonarea/backend/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('commonarea/backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('commonarea/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('commonarea/backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('commonarea/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('commonarea/backend/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('commonarea/backend/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('commonarea/backend/dist/js/demo.js')}}"></script>
</body>
<script src="{{asset('commonarea/backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('commonarea/backend/plugins/toastr/toastr.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('commonarea/backend/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('commonarea/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('commonarea/backend/plugins/select2/js/select2.full.min.js')}}"></script>
<?php 
  if ($this->session->flashdata('msg')) {
    ?>
    <script type="text/javascript">
        $(function() {
          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });

          
            Toast.fire({
              type: 'success',
              title: ' <?php echo $this->session->flashdata('msg'); ?>'
            })
          
        });

    </script>
    <?php
  }
?>
<script>
  $(document).ready(function(){
    $(".datatable").DataTable();
    $('.select2').select2();
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
<script>
	jQuery(function(){
		$('#state_id').change(function(){
			$('#city_id').html('');
			var base_url = '<?php echo base_url(); ?>';
			var state_id = $(this).val();
			var city = '';
			$.ajax({
				url:base_url + 'welcome/getCity',
				type:'POST',
				data:{
					state_id:state_id
				},
			   
				dataType: 'json', 
				success:function(data){
					var d = data['data'];
					//city = d.city_name
					//console.log(city);
					$.each(d, function(i, data) {
					 
				        	city += "<option value=" + data.city_id + ">" + data.city_name + "</option>";
				        	console.log(city);
					   
					});
					
			    	$('#city_id').append(city);
				}
			});
			
		});
	});
</script>
</body>

<!-- Mirrored from adminlte.io/themes/dev/AdminLTE/pages/examples/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 05 Oct 2019 11:47:25 GMT -->
</html>