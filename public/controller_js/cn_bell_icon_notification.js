
$(document).ready(function () {
    $(function () {
        $("#bell_icon_notification_form").validate({
            onfocusout: false,
             rules: {
                city_id: {
                    required: true,
                },
                notification_title: {
                    required: true,
                },
                message: {
                    required: true,
                }

            },
            // Specify the validation error messages
            messages: {
                city_id: {
                    required: '* Please enter city Name.',
                },
                notification_title: {
                    required: '* Please enter notification title.',
                },
                message: {
                    required: '* Please enter message.',
                }
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });
    });
});