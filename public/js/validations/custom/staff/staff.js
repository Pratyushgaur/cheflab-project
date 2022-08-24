
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this staff status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-system-users/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_board',function(e){
		if (confirm('Do you really want to delete this staff ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-system-users/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('change','#state_id',function(){
		var state_id=$(this).val();
		if(state_id)
		{
			$.ajax({
				url:base_url+'get-states-cities',
				method:'POST',
				data:{state_id:state_id},
				success:function(data)
				{
					$('#city_id').html(data);
				}
			});
		}
	});
	
	$("#profile_image").change(function() {
	  readURL(this);
	});
	
	
	function readURL(input) {
	  if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
		  $('#profile_image_img').attr('src', e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}
	
	jQuery.validator.addMethod("mobileno", function(value, element) {
	  if (/^[6-9]\d{9}$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid mobile no.');
	
	jQuery.validator.addMethod("emailid", function(value, element) {
	  if (/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+\.[a-z]{2,9}$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid email.');
	
	
	$('#staffForm').validate({
		rules:{
			full_name:{
				required:true,
				minlength:3,
			},
			role_id:{
				required:true,
			},
			email:{
				required:true,
				emailid:true,
				remote:base_url+ 'check-duplicate-email-system-user?admin_id=' + $('#admin_id').val()
			},
			mobile_no:{
				required:true,
				mobileno:true,
				remote:base_url+ 'check-duplicate-mobile-system-user?admin_id=' + $('#admin_id').val()
			},
			state_id:{
				required:true
			},
			city_id:{
				required:true
			},
			address:{
				required:true
			},
			password:{
				required:true,
				minlength:8
			}
		},
		messages:{
			full_name:{
				required:'Full name is required',
				minlength:'Minimum 3 characters is required'
			},
			role_id:{
				required:'Role is required',
			},
			email:{
				required:'Email is required',
				email:'Please enter valid email',
				remote:'Email Already Exists'
			},
			mobile_no:{
				required:'Mobile no is required',
				remote:'Mobile No Already Exists'
			},
			state_id:{
				required:'State is required'
			},
			city_id:{
				required:'City is required'
			},
			address:{
				required:'Address is required'
			},
			password:{
				required:'Password is required'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});