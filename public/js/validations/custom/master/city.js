	
	$(document).on('change','#state_id',function(e){
		var state_id=$(this).val();
	});
	
	$(document).on('click','.change_status',function(e){
		if (confirm('Do you really want to change this city status?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'change-status-city/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	$(document).on('click','.delete_city',function(e){
		if (confirm('Do you really want to delete this city?')) {
			var id=$(this).attr('id');
			$.ajax({
				url:base_url+'delete-city/'+id,
				method:'get',
				data:{},
				success:function(data)
				{
					location.reload();
				}
			});
		}
	});
	
	jQuery.validator.addMethod("cityname", function(value, element) {
	  if (/^[a-zA-Z\s]+$/.test(value)) {
		return true;
	  } else {
		return false;
	  };
	}, 'Please enter valid city name.');
	
	$('#cityForm').validate({
		rules:{
			state_id:{
				required:true
			},
			city_name:{
				required:true,
				cityname:true,
				minlength: 3,
				remote: {
                    url: base_url+"check-duplicate-city",
                    type: "post",
                    data: {
                        city_id: function(){ return $("#city_id").val(); },
                        state_id: function(){ return $("#state_id").val(); },
                        city_name: function(){ return $("#city_name").val(); },
                    }
                },			
			}
		},
		messages:{
			state_id:{
				required:'State is required'
			},
			city_name:{
				required:'City name is required',
				minlength:'Minimum 3 characters is required',
				remote: "City name is already exists."
			}
			
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	$('#importcitiesForm').validate({
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
	
	