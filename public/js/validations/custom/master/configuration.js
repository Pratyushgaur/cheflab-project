	
	// Other
	$(document).on('keyup','#sub_2_from_questions_no',function(){
		var sub_2_from_questions_no=$(this).val();
		if(sub_2_from_questions_no)
		{
			$("#sub_2_to_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_2_to_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_2_to_questions_no',function(){
		var sub_2_to_questions_no=$(this).val();
		if(sub_2_to_questions_no)
		{
			$("#sub_2_from_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_2_from_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_3_from_questions_no',function(){
		var sub_3_from_questions_no=$(this).val();
		if(sub_3_from_questions_no)
		{
			$("#sub_3_to_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_3_to_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_3_to_questions_no',function(){
		var sub_3_to_questions_no=$(this).val();
		if(sub_3_to_questions_no)
		{
			$("#sub_3_from_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_3_from_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_5_from_questions_no',function(){
		var sub_5_from_questions_no=$(this).val();
		if(sub_5_from_questions_no)
		{
			$("#sub_5_to_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_5_to_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_5_to_questions_no',function(){
		var sub_5_to_questions_no=$(this).val();
		if(sub_5_to_questions_no)
		{
			$("#sub_5_from_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_5_from_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_6_from_questions_no',function(){
		var sub_6_from_questions_no=$(this).val();
		if(sub_6_from_questions_no)
		{
			$("#sub_6_to_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_6_to_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_6_to_questions_no',function(){
		var sub_6_to_questions_no=$(this).val();
		if(sub_6_to_questions_no)
		{
			$("#sub_6_from_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_6_from_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_8_from_questions_no',function(){
		var sub_8_from_questions_no=$(this).val();
		if(sub_8_from_questions_no)
		{
			$("#sub_8_to_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_8_to_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_8_to_questions_no',function(){
		var sub_8_to_questions_no=$(this).val();
		if(sub_8_to_questions_no)
		{
			$("#sub_8_from_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_8_from_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_9_from_questions_no',function(){
		var sub_9_from_questions_no=$(this).val();
		if(sub_9_from_questions_no)
		{
			$("#sub_9_to_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_9_to_questions_no").rules("remove", "required");
		}
	});
	
	$(document).on('keyup','#sub_9_to_questions_no',function(){
		var sub_9_to_questions_no=$(this).val();
		if(sub_9_to_questions_no)
		{
			$("#sub_9_from_questions_no").rules('add', {
				required: true,
				messages: {
					required: "to questions no is required",
				}
			});
		}else{
			$("#sub_9_from_questions_no").rules("remove", "required");
		}
	});
	

	
	// End Other
	$(document).on('keyup','#sub_1_time',function(){
		var sub_1_time=$(this).val();
		if(sub_1_time)
		{
			document.getElementById("sub_1_time_limit").disabled = true;
			$('#sub_1_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_1_time_limit").disabled = false;
			$('#sub_1_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_1_time_limit').click(function() {
		if(this.checked) {
			$('#sub_1_time').val('');
			$("#sub_1_time").attr('readonly','readonly');
		}else{
			$('#sub_1_time').val('10');
			document.getElementById("sub_1_time_limit").disabled = true;
			$("#sub_1_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_2_time',function(){
		var sub_2_time=$(this).val();
		if(sub_2_time)
		{
			document.getElementById("sub_2_time_limit").disabled = true;
			$('#sub_2_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_2_time_limit").disabled = false;
			$('#sub_2_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_2_time_limit').click(function() {
		if(this.checked) {
			$('#sub_2_time').val('');
			$("#sub_2_time").attr('readonly','readonly');
		}else{
			$('#sub_2_time').val('10');
			document.getElementById("sub_2_time_limit").disabled = true;
			$("#sub_2_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_3_time',function(){
		var sub_3_time=$(this).val();
		if(sub_3_time)
		{
			document.getElementById("sub_3_time_limit").disabled = true;
			$('#sub_3_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_3_time_limit").disabled = false;
			$('#sub_3_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_3_time_limit').click(function() {
		if(this.checked) {
			$('#sub_3_time').val('');
			$("#sub_3_time").attr('readonly','readonly');
		}else{
			$('#sub_3_time').val('10');
			document.getElementById("sub_3_time_limit").disabled = true;
			$("#sub_3_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_4_time',function(){
		var sub_4_time=$(this).val();
		if(sub_4_time)
		{
			document.getElementById("sub_4_time_limit").disabled = true;
			$('#sub_4_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_4_time_limit").disabled = false;
			$('#sub_4_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_4_time_limit').click(function() {
		if(this.checked) {
			$('#sub_4_time').val('');
			$("#sub_4_time").attr('readonly','readonly');
		}else{
			$('#sub_4_time').val('10');
			document.getElementById("sub_4_time_limit").disabled = true;
			$("#sub_4_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_5_time',function(){
		var sub_5_time=$(this).val();
		if(sub_5_time)
		{
			document.getElementById("sub_5_time_limit").disabled = true;
			$('#sub_5_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_5_time_limit").disabled = false;
			$('#sub_5_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_5_time_limit').click(function() {
		if(this.checked) {
			$('#sub_5_time').val('');
			$("#sub_5_time").attr('readonly','readonly');
		}else{
			$('#sub_5_time').val('10');
			document.getElementById("sub_5_time_limit").disabled = true;
			$("#sub_5_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_6_time',function(){
		var sub_6_time=$(this).val();
		if(sub_6_time)
		{
			document.getElementById("sub_6_time_limit").disabled = true;
			$('#sub_6_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_6_time_limit").disabled = false;
			$('#sub_6_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_6_time_limit').click(function() {
		if(this.checked) {
			$('#sub_6_time').val('');
			$("#sub_6_time").attr('readonly','readonly');
		}else{
			$('#sub_6_time').val('10');
			document.getElementById("sub_6_time_limit").disabled = true;
			$("#sub_6_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_7_time',function(){
		var sub_7_time=$(this).val();
		if(sub_7_time)
		{
			document.getElementById("sub_7_time_limit").disabled = true;
			$('#sub_7_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_7_time_limit").disabled = false;
			$('#sub_7_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_7_time_limit').click(function() {
		if(this.checked) {
			$('#sub_7_time').val('');
			$("#sub_7_time").attr('readonly','readonly');
		}else{
			$('#sub_7_time').val('10');
			document.getElementById("sub_7_time_limit").disabled = true;
			$("#sub_7_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_8_time',function(){
		var sub_8_time=$(this).val();
		if(sub_8_time)
		{
			document.getElementById("sub_8_time_limit").disabled = true;
			$('#sub_8_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_8_time_limit").disabled = false;
			$('#sub_8_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_8_time_limit').click(function() {
		if(this.checked) {
			$('#sub_8_time').val('');
			$("#sub_8_time").attr('readonly','readonly');
		}else{
			$('#sub_8_time').val('10');
			document.getElementById("sub_8_time_limit").disabled = true;
			$("#sub_8_time").removeAttr('readonly');
		}
	});
	
	$(document).on('keyup','#sub_9_time',function(){
		var sub_9_time=$(this).val();
		if(sub_9_time)
		{
			document.getElementById("sub_9_time_limit").disabled = true;
			$('#sub_9_time_limit').prop('checked',false);
		}else{
			document.getElementById("sub_9_time_limit").disabled = false;
			$('#sub_9_time_limit').prop('checked',true);
		}
	});
	
	$('#sub_9_time_limit').click(function() {
		if(this.checked) {
			$('#sub_9_time').val('');
			$("#sub_9_time").attr('readonly','readonly');
		}else{
			$('#sub_9_time').val('10');
			document.getElementById("sub_9_time_limit").disabled = true;
			$("#sub_9_time").removeAttr('readonly');
		}
	});
	
	// First Level	
	$.validator.addMethod("greaterThan1", function( value, element, param ) {
        var val_a = $("#sub_1_from_questions_no").val();
		var total_questions= $("#total_questions").val();
        return this.optional(element)|| (parseInt(value) >= val_a);
    },"To question no is >= from.");
	
	$.validator.addMethod("greaterThan2", function( value, element, param ) {
        var val_a = $("#sub_1_to_questions_no").val();  
		var val_a=parseInt(val_a) + 1;
        return this.optional(element)|| (parseInt(value)==val_a);
    },"From question no value is previous + 1.");
	
	$.validator.addMethod("greaterThan3", function( value, element, param ) {
        var val_a = $("#sub_2_from_questions_no").val(); 
        return this.optional(element)|| (parseInt(value) >= val_a);
    },"To question no is >= from.");
	
	$.validator.addMethod("greaterThan4", function( value, element, param ) {
        var val_a = $("#sub_2_to_questions_no").val();  
		var val_a=parseInt(val_a) + 1;
		var sub_2_from_questions_no=$("#sub_2_from_questions_no").val();		
        return this.optional(element)|| (parseInt(value)==val_a);
    },"From question no value is previous + 1.");
	
	$.validator.addMethod("greaterThan5", function( value, element, param ) {
        var val_a = $("#sub_3_from_questions_no").val();  
        return this.optional(element)|| (parseInt(value)>= val_a);
    },"To question no is >= from.");
	
	// Second Level
	$.validator.addMethod("greaterThan6", function( value, element, param ) {
        var val_a = $("#sub_4_from_questions_no").val();
		var total_questions= $("#total_questions").val();
        return this.optional(element)|| (parseInt(value) >= val_a);
    },"To question no is >= from.");
	
	$.validator.addMethod("greaterThan7", function( value, element, param ) {
        var val_a = $("#sub_4_to_questions_no").val();  
		var val_a=parseInt(val_a) + 1;
        return this.optional(element)|| (parseInt(value)==val_a);
    },"From question no value is previous + 1.");
	
	$.validator.addMethod("greaterThan8", function( value, element, param ) {
        var val_a = $("#sub_5_from_questions_no").val();  
        return this.optional(element)|| (parseInt(value) >= val_a);
    },"To question no is >= from.");
	
	$.validator.addMethod("greaterThan9", function( value, element, param ) {
        var val_a = $("#sub_5_to_questions_no").val();  
		var val_a=parseInt(val_a) + 1;
        return this.optional(element)|| (parseInt(value)==val_a);
    },"From question no value is previous + 1.");
	
	$.validator.addMethod("greaterThan10", function( value, element, param ) {
        var val_a = $("#sub_6_from_questions_no").val();  
        return this.optional(element)|| (parseInt(value)>= val_a);
    },"To question no is >= from.");
	
	// Third Level
	$.validator.addMethod("greaterThan11", function( value, element, param ) {
        var val_a = $("#sub_7_from_questions_no").val();
		var total_questions= $("#total_questions").val();
        return this.optional(element)|| (parseInt(value) >= val_a);
    },"To question no is >= from.");
	
	$.validator.addMethod("greaterThan12", function( value, element, param ) {
        var val_a = $("#sub_7_to_questions_no").val();  
		var val_a=parseInt(val_a) + 1;
        return this.optional(element)|| (parseInt(value)==val_a);
    },"From question no value is previous + 1.");
	
	$.validator.addMethod("greaterThan13", function( value, element, param ) {
        var val_a=$("#sub_8_from_questions_no").val();  
        return this.optional(element)|| (parseInt(value) >= val_a);
    },"To question no is >= from.");
	
	$.validator.addMethod("greaterThan14", function( value, element, param ) {
        var val_a = $("#sub_8_to_questions_no").val();  
		var val_a=parseInt(val_a) + 1;
        return this.optional(element)|| (parseInt(value)==val_a);
    },"From question no value is previous + 1.");
	
	$.validator.addMethod("greaterThan15", function( value, element, param ) {
        var val_a = $("#sub_9_from_questions_no").val();  
        return this.optional(element)|| (parseInt(value)>= val_a);
    },"To question no is >= from.");
	
	var total_questions=parseInt($('#total_questions').val()); 
    
  

	$('#configurationForm').validate({
		rules:{
			total_questions:{
				required:true
			},
			sub_1_from_questions_no:{
				required:true
			},
			sub_1_to_questions_no:{
				required:true,
				greaterThan1:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_2_from_questions_no:{
				greaterThan2:true
			},
			sub_2_to_questions_no:{
				greaterThan3:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_3_from_questions_no:{
				greaterThan4:true
			},
			sub_3_to_questions_no:{
				greaterThan5:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_4_from_questions_no:{
				required:true
			},
			sub_4_to_questions_no:{
				required:true,
				greaterThan6:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_5_from_questions_no:{
				greaterThan7:true
			},
			sub_5_to_questions_no:{
				greaterThan8:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_6_from_questions_no:{
				greaterThan9:true
			},
			sub_6_to_questions_no:{
				greaterThan10:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_7_from_questions_no:{
				required:true
			},
			sub_7_to_questions_no:{
				required:true,
				greaterThan11:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_8_from_questions_no:{
				greaterThan12:true
			},
			sub_8_to_questions_no:{
				greaterThan13:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},
			sub_9_from_questions_no:{
				greaterThan14:true
			},
			sub_9_to_questions_no:{
				greaterThan15:true,
				max:function(){ return parseInt($("#total_questions").val()); },
			},		
		},
		messages:{
			total_questions:{
				required:'Total questions is required'
			},	
			sub_1_from_questions_no:{
				required:'From questions no is required'
			},
			sub_1_to_questions_no:{
				required:'To questions no is required',
				max:'not greater than total questions'
			},
			sub_2_to_questions_no:{
				max:'not greater than total questions'
			},
			sub_3_to_questions_no:{
				max:'not greater than total questions'
			},
			sub_4_from_questions_no:{
				required:'From questions no is required'
			},
			sub_4_to_questions_no:{
				required:'To questions no is required',
				max:'not greater than total questions'
			},
			sub_5_to_questions_no:{
				max:'not greater than total questions'
			},
			sub_6_to_questions_no:{
				max:'not greater than total questions'
			},
			sub_7_from_questions_no:{
				required:'From questions no is required'
			},
			sub_7_to_questions_no:{
				required:'To questions no is required',
				max:'not greater than total questions'
			},
			sub_8_to_questions_no:{
				max:'not greater than total questions'
			},
			sub_9_to_questions_no:{
				max:'not greater than total questions'
			},
		},
		submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
	});
	
	