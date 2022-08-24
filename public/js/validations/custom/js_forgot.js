
$(function () {

    $("#frm").validate({
// Specify the validation rules
        rules: {
            email_id: {
                required: true,
                email: true,
                remote: $('#base_url').val() + 'admin/login/Cn_forgot/check_email'
            },
        },
        // Specify the validation error messages
        messages: {
            email_id: {
                required: "* Please enter email id.",
                email: "* Please enter vaild email id.",
                remote : "* Please enter correct email id",
            },
        },
        submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
});

});
