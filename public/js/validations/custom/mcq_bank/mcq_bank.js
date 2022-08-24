	
	$(document).on('click','.delete_mcq',function(e){
		 return confirm("Do you really want to delete this mcq ?");
	});
	
	$(document).on('change','#board_id',function(){
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
	
	$(document).on('change','#class_id',function(e){
		var class_id=$('#class_id').val();
		if(class_id)
		{
			$.ajax({
				url:base_url+'get-class-subject',
				method:'get',
				data:{class_id:class_id},
				datatype:'html',
				success:function(data)
				{
					$('#subject_id').html(data);
				}
			});
		}
	});
	
	var class_id=$('#class_id').val();
	if(class_id)
	{
		$.urlParam = function(name){
			var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
			return results[1] || 0;
		}
	}
	
	$( document ).ready(function() {
		var class_id=$('#class_id').val();
		if(class_id)
		{
			var subject_id=$.urlParam('subject_id');
			if(class_id)
			{
				$.ajax({
					url:base_url+'get-class-subject',
					method:'get',
					data:{class_id:class_id,subject_id:subject_id},
					datatype:'html',
					success:function(data)
					{
						$('#subject_id').html(data);
					}
				});
			}
		}
	});
	
	$(document).on('change','#subject_id',function(e){
		var subject_id=$('#subject_id').val();
		if(subject_id)
		{
			$.ajax({
				url:base_url+'get-class-lessons',
				method:'get',
				data:{subject_id:subject_id},
				datatype:'html',
				success:function(data)
				{
					$('#lesson_id').html(data);
				}
			});
		}
	});
	
	$( document ).ready(function() {
		var class_id=$('#class_id').val();
		if(class_id)
		{
			var subject_id=$.urlParam('subject_id');
		    var lesson_id=$.urlParam('lesson_id');
			$.ajax({
				url:base_url+'get-class-lessons',
				method:'get',
				data:{subject_id:subject_id,lesson_id:lesson_id},
				datatype:'html',
				success:function(data)
				{
					$('#lesson_id').html(data);
				}
			});
		}
	});
	
	$('#importmcqForm').validate({
		rules:{
			mcqexcel:{
				requird:true,
			}
		},
		messages:{
			mcqexcel:{
				requird:'Please select excel file'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
