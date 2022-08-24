
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this gr status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-gr/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_gr',function(e){
		if (confirm('Do you really want to delete this gr ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-gr/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('change','#board_id',function(e){
		var board_id=$('#board_id').val();
		if(board_id)
		{
			$.ajax({
				url:base_url+'get-board-class',
				method:'get',
				data:{board_id:board_id},
				datatype:'html',
				success:function(data)
				{
					$('#class_id').html(data);
				}
			});
		}
	});
	
	
	jQuery.validator.addMethod("validpromo", function(value, element) {
	  if (/^[a-zA-Z0-9]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid promocode.');
	
	$('#grForm').validate({
		onfocusout: false,
		rules:{
			heading:{
				required:true,
			},
			description:{
				required:true,
			},
			gr_link:{
				required:true,
			},
			board_id:{
				required:true,
			},
			class_id:{
				required:true,
			},
			state_id:{
				required:true,
			}			
		},
		messages:{
			heading:{
				required:'Heading is required',
			},
			description:{
				required:'Description is required',
			},
			gr_link:{
				required:'GR Link is required',
			},
			board_id:{
				required:'Board is required',
			},
			class_id:{
				required:'Class is required',
			},
			state_id:{
				required:'State is required',
			}	
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});