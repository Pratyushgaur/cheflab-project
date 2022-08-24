

$(document).ready(function () {
    $(function () {
        $("#categoryForm").validate({
            onfocusout: false,
             rules: {
                ui_category: {
                    required: true,
                },
                category_name: {
                    required: true,
                },
                category_position: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
                ui_category: {
                    required: '* Please select UI.',
                },
                category_name: {
                    required: '* Please enter category Name.',
                },
                category_position: {
                    required: '* Please enter category position Name.',
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