	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this subscription ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-subscription/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_subscription',function(e){
		if (confirm('Do you really want to delete this subscription ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-subscription/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('change','#subscription_name',function(){
		$('#board_id').val('');
	});
	
	$(document).on('change','#board_id',function(){  
		var board_id=$(this).val();
		if(board_id)
		{
			$.ajax({
				url:base_url+'master/subscription-board-class',
				method:'get',
				data:{board_id:board_id,subscription_name: function(){ return $("#subscription_name").val(); },},
				datatype:'html',
				success:function(data)
				{
					$('#clas_id').html(data);
				}
			});
		}
	});
	
	$('#subscriptionForm').validate({
		rules:{
			board_id:{
				required:true
			},
			"classes[]":{
				required:true
			},
			subscription_name:{
				required:true
			},
			subscription_price:{
				required:true
			},
			subscription_days:{
				required:true
			},
			subscription_description:{
				required:true
			},
		},
		messages:{
			board_id:{
				required:'Board is required'
			},
			"classes[]":{
				required:'Class is required'
			},
			subscription_name:{
				required:'Subscription type is required'
			},
			subscription_price:{
				required:'Subscription price is required'
			},
			subscription_days:{
				required:'Subscription days is required'
			},
			subscription_description:{
				required:'Subscription description is required'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	