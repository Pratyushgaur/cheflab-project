	var old_subject_icon_img = ($('#old_subject_icon_img').val()== "") ? true : false;
	
	var question_audio_file = ($('#old_question_audio_file').val()== "") ? true : false;
	
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
	
	$("#question_image").change(function() {
	  readURL(this);
	});
	
	function readURL(input) {
	  if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
		  $('#question_image_img').attr('src', e.target.result);
		}		
		reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}
	
	
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
			var subject_id=$('#e_subject_id').val();
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
	
	$( document ).ready(function() {
		var class_id=$('#class_id').val();
		var subject_id=$('#e_subject_id').val();
		var lesson_id=$('#e_lesson_id').val();
		if(class_id)
		{
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

	
	$('#mcqForm').validate({
		rules:{
			board_id:{
				required:true,
			},
			class_id:{
				required:true,
			},
			subject_id:{
				required:true,
			},
			lesson_id:{
				required:true,
			},
			question:{
				required:'#question_image:blank'
			},
			question_image:{
				required: '#question:blank'
			},
			option_a:{
				required:true,
			},
			option_b:{
				required:true,
			},
			option_c:{
				required:true,
			},
			option_d:{
				required:true,
			},
			correct_ans:{
				required:true,
			},
// 			question_audio_file:{
// 				required:question_audio_file,
// 			},
			explanation:{
				required:true,
			},
			teacher_hint:{
				required:true,
			},
		},
		messages:{
			board_id:{
				required:'Board is required',
			},
			class_id:{
				required:'Class is required',
			},
			subject_id:{
				required:'Subject is required',
			},
			lesson_id:{
				required:'Lesson is required',
			},
			question:{
				required:'Question is required',
			},
			question_image:{
				required:'Question image is required',
			},
			option_a:{
				required:'Option A is required',
			},
			option_b:{
				required:'Option B is required',
			},
			option_c:{
				required:'Option C is required',
			},
			option_d:{
				required:'Option D is required',
			},
// 			question_audio_file:{
// 				required:'Question audio is required',
// 			},
			correct_ans:{
				required:'Answer is required',
			},
			explanation:{
				required:'Explanation is required',
			},
			teacher_hint:{
				required:'Teacher hint is required',
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});