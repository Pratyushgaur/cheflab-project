	
	$(document).on('click','.delete_query',function(e){
		 return confirm("Do you really want to delete this query ?");
	});
	
	$('#helpdeskForm').validate({
		rules:{
			status:{
				required:true
			},
			remark:{
				required:true
			},
		},
		messages:{
			status:{
				required:'Status is required'
			},	
			remark:{
				required:'Remark is required'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	news
	