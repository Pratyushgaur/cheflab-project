	
	$('#changePasswordForm').validate({
		rules:{
			old_pass:{
				required:true,
				remote:base_url+ 'check-password-valid?' + $('#old_pass').val()
			},
			new_pass:{
				required:true
			},
			cpassword:{
				required:true,
				equalTo :'#new_pass'
			},
		},
		messages:{
			old_pass:{
				required:'Old password is required',
				remote:'Invalid password'
			},	
			new_pass:{
				required:'New password is required'
			},
			cpassword:{
				required:'Confirm password is required',
				equalTo :'Password not matched'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	