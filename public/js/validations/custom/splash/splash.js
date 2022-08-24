
	var splash_screen_image = ($('#old_splash_screen_image').val()== "") ? true : false;
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this splash screen status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-splash/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_splash',function(e){
		if (confirm('Do you really want to delete this splash screen ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-splash/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$("#splash_screen_image").change(function() {
	  readURL(this);
	});
	
	function readURL(input) {
	  if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
		  $('#banner_img').attr('src', e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}
	
	$('#splashForm').validate({
		rules:{
			splash_type:{
				required:true
			},
			splash_screen_image:{
				required:splash_screen_image
			}
		},
		messages:{
			splash_type:{
				required:'Splash type is required'
			},
			splash_screen_image:{
				required:'Splash screen image required'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});