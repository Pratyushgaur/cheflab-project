	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this role status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-role/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_role',function(e){
		if (confirm('Do you really want to delete this role ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-role/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	jQuery.validator.addMethod("rolename", function(value, element) {
	  if (/^[a-zA-Z\s]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid role name.');
	
	$('#privilegeForm').validate({
		rules:{
			role_name:{
				required:true,
				rolename:true,
				minlength: 3,
				remote:base_url+ 'check-duplicate-role?role_id=' + $('#role_id').val()				
			}
		},
		messages:{
			role_name:{
				required:'Role name is required',
				minlength:'Minimum 3 characters is required',
				remote: "Role name is already exists."
			}
			
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	