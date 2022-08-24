	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this student status ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-student/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_student',function(e){
		if (confirm('Do you really want to delete this student ?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-student/'+id,
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
		var state_id=$('#state_id').val();
		if(state_id)
		{
			$.ajax({
				url:base_url+'get-states-cities',
				method:'post',
				data:{state_id:state_id},
				datatype:'html',
				success:function(data)
				{
					$('#city_id').html(data);
				}
			});
		}
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
	
	var state_id=$('#state_id').val();
	if(state_id)
	{
		$.urlParam = function(name){
			var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
			return results[1] || 0;
		}
	}
	
	
	$( document ).ready(function() {
		var state_id=$('#state_id').val();
		if(state_id)
		{
			var city_id=$.urlParam('city_id');
			if(state_id)
			{
				$.ajax({
					url:base_url+'get-states-cities-filter',
					method:'get',
					data:{state_id:state_id,city_id:city_id},
					datatype:'html',
					success:function(data)
					{
						$('#city_id').html(data);
					}
				});
			}
		}
	});
	