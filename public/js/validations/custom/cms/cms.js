
	$(document).ready(function () {
		$(".note-codable").attr("name", "cms_content");
		$(".note-codable").attr("id", "cms_content");
	});
	$(document).on('change','#cms_id',function(){
		var cms_id=$(this).val();
		if(cms_id)
		{
			$.ajax({
				url:base_url+'fetch-cms',
				method:'POST',
				data:{cms_id:cms_id},
				datatype:'json',
				success:function(data)
				{
					var data=JSON.parse(data);
					$('#cms_id').val(data[0].cms_id);
					$('#meta_description').val(data[0].meta_description);
					$('#meta_keywords').val(data[0].meta_keywords);
					$('#meta_title').val(data[0].meta_title);
					$('.note-editable').html(data[0].cms_content);
				}
			});
		}
	});
	
	$('#cmsForm').validate({
		rules:{
			cms_id:{
				required:true
			},
			cms_content:{
				required:true
			},
			meta_title:{
				required:true
			},
			meta_keywords:{
				required:true
			},
			meta_description:{
				required:true
			},
			
		},
		messages:{
			cms_id:{
				required:'Cms page is required'
			},	
			cms_content:{
				required:'Cms content is required'
			},
			meta_title:{
				required:'Meta title is required'
			},
			meta_keywords:{
				required:'Meta keywords is required'
			},
			meta_description:{
				required:'Meta description is required'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	