
	$('#loginForm').validate({
		rules:{
			email:{
				required:true,
				email:true
			},
			password:{
				required:true
			}
		},
		messages:{
			email:{
				required:'Email is required',
				email:'Please enter valid email'
			},
			password:{
				required:'Password is required'
			}
		}
	});