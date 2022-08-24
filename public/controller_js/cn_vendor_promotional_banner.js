$(document).ready(function () {
    $(function () {
        $("#promotionbannerForm").validate({
            onfocusout: false,
             rules: {
                
                promotion_date: {
                    required: true,
                },
                sloat_id: {
                    required: true,
                },
                
            },
            // Specify the validation error messages
            messages: {
               
                promotion_date: {
                    required: '* Please enter Category Name.',
                },
                sloat_id: {
                    required: '* Please enter Category Name.',
                },
                
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });
    });
});
