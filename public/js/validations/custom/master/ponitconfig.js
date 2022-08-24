
	$(document).ready(function(){	
		var ind = 1;
		$('[name*="points_"]').each(function () {
			$(this).rules('add', {
				required: true,
				min:1,
				max:9999,
				messages: {
					required: "Q. "+ind+" points is required",
					min:'Point is greater than 0',
					max:'Point is less than 9999'
				}
			});
			ind++;
		});
	});
	
	$(document).ready(function(){	
		var ind = 1;
		$('[name*="bonus_"]').each(function () {
			$(this).rules('add', {
				min:1,
				max:9999,
				messages: {
					min:'Bonus point is greater than 0',
					max:'Point is less than 9999'
				}
			});
			ind++;
		});
	});
	

	
	$('#ponitconfigForm').validate({
		rules:{
			points_1:{
				required:true
			},
			points_2:{
				required:true
			},
			points_3:{
				required:true
			},
			points_4:{
				required:true
			},
			points_5:{
				required:true
			},
		},
		messages:{
			points_1:{
				required:'Q. 1 points is required'
			},
			points_2:{
				required:'Q. 2 points is required'
			},
			points_3:{
				required:'Q. 3 points is required'
			},
			points_4:{
				required:'Q. 4 points is required'
			},
			points_5:{
				required:'Q. 5 points is required'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	