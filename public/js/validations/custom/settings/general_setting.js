		
	$(document).ready(function () {
		$(".note-codable").attr("name", "cms_content");
		$(".note-codable").attr("id", "cms_content");
	});
	
	
	$('#contactSettingForm').validate({
		rules:{
			address:{
				required:true
			},
			email_address:{
				required:true,
				email:true
			},
			phone:{
				required:true,
			},
			contact_text:{
				required:true
			}
			
		},
		messages:{
			address:{
				required:'Address is required'
			},
			email_address:{
				required:'Email address is required',
				email:'Invalid email address'
			},
			phone:{
				required:'Phone no is required',
			},
			contact_text:{
				required:'Contact content is required'
			}
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
   
    $('#socialmediaForm').validate({
		rules:{
			facebook_url:{
				url:true
			},
			twitter_url:{
				url:true
			},
			instagram_url:{
				url:true
			},
			pinterest_url:{
				url:true
			},
			linkedin_url:{
				url:true
			},
			vk_url:{
				url:true
			},
			youtube_url:{
				url:true
			},
			
		},
		messages:{
			facebook_url:{
				url:'Invalid facebook url'
			},
			twitter_url:{
				url:'Invalid twitter url'
			},
			instagram_url:{
				url:'Invalid instagram url'
			},
			pinterest_url:{
				url:'Invalid pinterest url'
			},
			linkedin_url:{
				url:'Invalid linkedin url'
			},
			vk_url:{
				url:'Invalid vk url'
			},
			youtube_url:{
				url:'Invalid youtube url'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
   
    
   
   
   