

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
                    remote: {
                        url: base_url + "/check_category_position",
                        type: "post",
                         headers : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        data: {
                          category_position: function () {
                            return $("#category_position").val();
                          },
                          txtpkey:function () {
                            return $("#txtpkey").val();
                          },
                        },
                    },
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
                    remote: '* This position is already booked'
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




$(document).ready(function () {
    $(function () {
        $("#productTypeMasterForm").validate({
            onfocusout: false,
             rules: {
                product_category_id: {
                    required: true,
                },
                product_type_name: {
                    required: true,
                },
                
            },
            // Specify the validation error messages
            messages: {
                product_category_id: {
                    required: '* Please select category.',
                },
                product_type_name: {
                    required: '* Please enter product Name.',
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



