	
	$('#confirmpasswordForm').validate({
		rules:{
			password:{
				required:true
			},
			confirmpassword:{
				required:true,
				equalTo: "#password"
			}
		},
		messages:{
			password:{
				required:'Password is required'
			},
			confirmpassword:{
				required:'Confirm password is required',
				equalTo: "Confirm password not matched"
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
   