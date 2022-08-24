
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this lesson ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-lesson/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_lesson',function(e){
		if (confirm('Do you really want to delete this lesson ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-lesson/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	jQuery.validator.addMethod("lessonname", function(value, element) {
	  if (/^[a-zA-Z0-9,.! ]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid lesson name.');
	
	$(document).on('change','#board_id',function(){
		var board_id=$(this).val();
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
	
	$(document).on('change','#class_id',function(){
		var board_id=$('#board_id').val();
		var class_id=$(this).val();
		if(class_id)
		{
			$.ajax({
				url:base_url+'get-class-subjects',
				method:'post',
				data:{class_id:class_id,board_id:board_id},
				datatype:'html',
				success:function(data)
				{
					$('#subject_id').html(data);
				}
			});
		}
	});
	
	$('#lessonForm').validate({
		rules:{
			board_id:{
				required:true
			},
			class_id:{
				required:true
			},
			subject_id:{
				required:true
			},
			lesson_name:{
				required:true,
				//lessonname:true,
				minlength: 3,
				remote: {
                    url: base_url+ 'check-duplicate-lesson',
                    type: "post",
                    data: {
						lesson_id: function(){ return $("#lesson_id").val(); },
						board_id: function(){ return $("#board_id").val(); },
                        class_id: function(){ return $("#class_id").val(); },
                        subject_id: function(){ return $("#subject_id").val(); },
                        lesson_name: function(){ return $("#lesson_name").val(); },
                    }
                },
			},
			subject_icon:{
				required:true
			}
		},
		messages:{
			board_id:{
				required:'Board is required'
			},
			class_id:{
				required:'Class is required'
			},
			subject_id:{
				required:'Subject is required'
			},
			lesson_name:{
				required:'Lesson name is required',
				minlength:'Minimum 3 characters is required',
				remote: "Lesson name is already exists."
			},
			subject_icon:{
				required:'Subject icon is required'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	$('#importlessonsForm').validate({
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
	
	
	
	
	