	var subject_icon = ($('#old_subject_icon_img').val()== "") ? true : false;
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this subject status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-subject/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_subject',function(e){
		if (confirm('Do you really want to delete this subject ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-subject/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$("#subject_icon").change(function() {
	  readURL(this);
	});
	
	$(document).on('change','#board_id',function(e){
		var board_id=$(this).val();
		var subject_id=$('#subject_id').val();
		if(board_id)
		{
			$.ajax({
				url:base_url+'get-board-class',
				method:'get',
				data:{board_id:board_id,subject_id:subject_id},
				datatype:'html',
				success:function(data)
				{
					$('#class_id').html(data);
				}
			});
		}
	});
	
	jQuery.validator.addMethod("subjectname", function(value, element) {
	  if (/^[a-zA-Z ]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid subject name.');
	
	function readURL(input) {
	  if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
		  $('#subject_icon_img').attr('src', e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}
	var subject_id=$('#subject_id').val();
	$('#subjectForm').validate({
		rules:{
			board_id:{
				required:true
			},
			class_id:{
				required:true
			},
			subject_name:{
				required:true,
				subjectname:true,
				minlength: 3,
				remote: {
                    url: base_url+ 'check-duplicate-subject',
                    type: "post",
                    data: {
                        board_id: function(){ return $("#board_id").val(); },
						class_id: function(){ return $("#class_id").val(); },
                        subject_id: function(){ return $("#subject_id").val(); },
                        subject_name: function(){ return $("#subject_name").val(); },
                    }
                },
			},
			subject_icon:{
				required:subject_icon
			}
		},
		messages:{
			board_id:{
				required:'Board is Required',
			},
			class_id:{
				required:'Class is required'
			},
			subject_name:{
				required:'Subject name is required',
				minlength:'Minimum 3 characters is required',
				remote: "Subject name is already exists."
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
	
	
	$('#importsubjectForm').validate({
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
	
	