
$(function () {

    $("#frm").validate({
// Specify the validation rules
        rules: {
            new_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            confirm_password: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo : "#new_password"
            },
        },
        // Specify the validation error messages
        messages: {
            new_password: {
                required: "* Please enter password.",
                minlength: "* Please enter atleast 6 characters.",
                maxlength: "* Please enter only 20 characters.",
            },
            confirm_password: {
                required: "* Please enter confirm password.",
                equalTo: "* New password and confirm password should be same.",
                minlength: "* Please enter atleast 6 characters.",
                maxlength: "* Please enter only 20 characters.",
            },
        },
        submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
});
});
