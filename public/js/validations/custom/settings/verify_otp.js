	
	$('#verifyotpForm').validate({
		rules:{
			otp:{
				required:true,				
				remote:base_url+ 'verify-otp-forget-password?'
			},
		},
		messages:{
			otp:{
				required:'OTP is required',
				remote: 'Invalid OTP.'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
   
 
   