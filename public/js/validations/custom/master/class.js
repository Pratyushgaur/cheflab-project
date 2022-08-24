	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this class status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-class/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_class',function(e){
		if (confirm('Do you really want to delete this class ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-class/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	jQuery.validator.addMethod("classname", function(value, element) {
	  if (/^[a-zA-Z0-9 ]+$/.test(value)) { 
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid class name.');
	
	$('#classForm').validate({
		rules:{
			board_id:{
				required:true,		
			},
			super_class_id:{
				required:true,
				remote: {
                    url: base_url+ 'check-duplicate-class',
                    type: "get",
                    data: {
                        board_id: function(){ return $("#board_id").val(); },
                        class_id: function(){ return $("#class_id").val(); },
                        super_class_id: function(){ return $("#super_class_id").val(); },
                    }
                },				
			}
		},
		messages:{
			board_id:{
				required:'Board is required',		
			},
			super_class_id:{
				required:'Class is required',
				remote: "Class is already exists."
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	
	$('#importclassForm').validate({
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