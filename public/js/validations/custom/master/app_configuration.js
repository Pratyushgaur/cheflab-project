
	$('#appconfigurationForm').validate({
		rules:{
			premier_discount:{
				required:true,		
			},
			premium_discount:{
				required:true,		
			},
			referal_points:{
				required:true,		
			},
			purchase_plan_points:{
				required:true,		
			},
			fifty_fifty_points:{
				required:true,		
			},
			double_dip_points:{
				required:true,		
			},
			flip_the_question_points:{
				required:true,		
			},
			advance_poll_points:{
				required:true,		
			},
			ask_the_teacher:{
				required:true,		
			},			
		},
		messages:{
			premier_discount:{
				required:'Premier Discount is required',		
			},
			premium_discount:{
				required:'Premium Discount is required',	
			},
			referal_points:{
				required:'Referal points is required',
			},
			purchase_plan_points:{
				required:'Purchase plan points is required',	
			},
			fifty_fifty_points:{
				required:'50-50 lifeline points is required',		
			},
			double_dip_points:{
				required:'Double dip lifeline points is required',	
			},
			flip_the_question_points:{
				required:'Flip the question lifeline points is required',		
			},
			advance_poll_points:{
				required:'Advance poll lifeline points is required',	
			},
			ask_the_teacher:{
				required:'Ask the teacher lifeline points is required',
			},					
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});