		
	jQuery.validator.addMethod("statename", function(value, element) {
	  if (/^[a-zA-Z\s]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid state name.');
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this state status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-state/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
			 
		}
	});

	$(document).on('click','.delete_state',function(e){ 
		if (confirm('Do you really want to delete this state ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-state/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	$('#stateForm').validate({
		rules:{
			state_name:{
				required:true,
				statename:true,	
				minlength: 3,
				remote:base_url+'check-duplicate-state?state_id=' + $('#state_id').val()
			}
		},
		messages:{
			state_name:{
				required:'State name is required',
				minlength:'Minimum 3 characters is required',
				remote: "State name is already exists."
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
         $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
         }
	});