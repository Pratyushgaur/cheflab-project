$('#adminCmsForms').validate({
    rules:{
        title_id:{
            required:true
        },
        meta_title_name:{
            required:true
        },
        meta_keywords:{
           required:true

        },
        meta_description:{
        required:true
    }
     },
    messages:{
        title_id:{
            required:" * Please select pages "
        },
        meta_title_name:{
            required:"* Meta title required"
        },
        meta_keywords:{
            required:"* Meta keyword required"
        },
        meta_description:{
            required:"* Description is required"
        }
    },

    submitHandler: function (form) {
        $("#cmsBtns").attr("disabled", true);
        form.submit();
    }
 

});