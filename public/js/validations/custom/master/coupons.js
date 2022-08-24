
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this coupon status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-coupons/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_coupons',function(e){
		if (confirm('Do you really want to delete this coupon ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-coupons/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('change','#state_id',function(){
		var state=[];
		$('#state_id :selected').each(function(i, sel){ 
			state.push($(sel).val());
		});
		$.ajax({
			url:base_url+'get-states-city-multiple',
			method:'post',
			data:{state:state},
			datatype:'html',
			success:function(data)
			{
				$('#city_id').html(data);
			}
		});
	});
	
	jQuery.validator.addMethod("validpromo", function(value, element) {
	  if (/^[a-zA-Z0-9]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid promocode.');
	
	$('#couponForm').validate({
		onfocusout: false,
		rules:{
			subscription_type:{
				required:true,
			},
			promocode:{
				required:true,
				validpromo:true,
				minlength: 6,
			},
			discount_percentage:{
				required:true,
			},
			maximum_discount:{
				required:true,
			},
			fromdate:{
				required:true,
			},
			todate:{
				required:true,
			},
			"state_id[]":{
				required:true,
			},
			"city_id[]":{
				required:true,
			},
			details:{
				required:true,
			}
			
		},
		messages:{
			subscription_type:{
				required:'Subscription type is required'
			},
			promocode:{
				required:'Promocode is required',
				minlength:'Minimum 3 characters is required',
			},
			discount_percentage:{
				required:'Discount percentage is required'
			},
			maximum_discount:{
				required:'Maximum discount is required'
			},
			fromdate:{
				required:'From date is required'
			},
			todate:{
				required:'To date is required'
			},
			"state_id[]":{
				required:'Atleast one state is required'
			},
			"city_id[]":{
				required:'Atleast one city is required'
			},
			details:{
				required:'Details is required',
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});