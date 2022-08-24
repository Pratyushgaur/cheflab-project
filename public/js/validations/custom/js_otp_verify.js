
$(function () {

    $("#frm").validate({
// Specify the validation rules
        rules: {
            otp: {
                required: true,
                remote: $('#base_url').val() + 'admin/login/Cn_forgot/check_otp?email_id=' + $("#email_id").val()
            },
        },
        // Specify the validation error messages
        messages: {
            otp: {
                required: "* Please enter otp.",
                remote : "* Please enter correct otp",
            },
        },
        submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            form.submit(); // <- use 'form' argument here.
        }
});

});
