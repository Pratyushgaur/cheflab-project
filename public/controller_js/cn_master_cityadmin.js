
$(document).ready(function () {
    $(function () {
        $("#cityAdminForm").validate({
            onfocusout: false,
             rules: {
                city_id: {
                    required: true,
                },
                admin_name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                commision: {
                    required: true,
                    number: true,
                },
                admin_email: {
                    required: true,
                    email: true
                },
                admin_mobile: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password",
                },
                


            },
            // Specify the validation error messages
            messages: {
                city_id: {
                    required: '* Please select city.',
                },
                admin_name: {
                    required: '* Please enter name.',
                },
                address: {
                    required: '* Please enter address.',
                },
                commision: {
                    required: '* Please enter commision.',
                    number: "The commision field only contain numerical digits.",
                },
                admin_email: {
                    required: '* Please enter email id.',
                    email: "* Enter a valid email."
                },
                admin_mobile: {
                    required: '* Please enter mobile no.',
                    number: "The mobile no field only contain numerical digits.",
                   minlength: "The mobile no field only contain 10 digits.",
                   maxlength: "The mobile no field only contain 10 digits."
                },
                password: {
                    required: '* Please enter password.',
                },
                confirm_password: {
                    required: '* Please confirm password.',
                    equalTo: "* New password and confirm new password does not match."
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