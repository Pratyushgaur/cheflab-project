	
	$('#forgetpasswordForm').validate({
		rules:{
			email:{
				required:true,				
				remote:base_url+ 'check-account-exits?'
			},
		},
		messages:{
			email:{
				required:'Email is required',
				remote: 'Email does not exists.'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
   
 
   