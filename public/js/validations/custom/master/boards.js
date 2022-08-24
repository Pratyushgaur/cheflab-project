
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this board status?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-boards/'+id,
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
		if (confirm('Do you really want to delete this board ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-board/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	jQuery.validator.addMethod("boardname", function(value, element) {
	  if (/^[a-zA-Z\s]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid board name.');
	
	$('#boardForm').validate({
		rules:{
			board_name:{
				required:true,
				boardname:true,
				minlength: 3,
				remote:base_url+ 'check-duplicate-board?state_id=' + $('#state_id').val()
			}
		},
		messages:{
			board_name:{
				required:'Board name is required',
				minlength:'Minimum 3 characters is required',
				remote: "Board name is already exists."
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	$('#importboardsForm').validate({
		rules:{
			excel:{
				requird:true,
			}
		},
		messages:{
			excel:{
				requird:'Please select excel file'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});