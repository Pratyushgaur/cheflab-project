
$(document).ready(function () {
    $(function () {
        $("#bannerForm").validate({
            onfocusout: false,
             rules: {
                
                banner_name: {
                    required: true,
                },
                banner_position: {
                    required: true,
                     remote: {
                        url: base_url + "/check_banner_position",
                        type: "post",
                        headers : {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                        data: {
                          banner_position: function () {
                            return $("#banner_position").val();
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
               
                banner_name: {
                    required: '* Please enter Banner Name.',
                },
                banner_position: {
                    required: '* Please enter Banner position .',
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