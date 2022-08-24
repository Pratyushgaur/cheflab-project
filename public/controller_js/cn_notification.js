
$(document).ready(function () {
    $(function () {
        $("#on_screen_notification_form").validate({
            onfocusout: false,
             rules: {
                notification_title: {
                    required: true,
                },
                message: {
                    required: true,
                },
                time_slot_id: {
                    required: true,
                }

            },
            // Specify the validation error messages
            messages: {
                notification_title: {
                    required: '* Please enter notification title.',
                },
                message: {
                    required: '* Please enter message.',
                },
                time_slot_id: {
                    required: '* Please select time slot.',
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



   $('#example').on('click','.approvel-btn-status',function() {
        var notification_id = $(this).attr('data-id');

        if(notification_id != ''){
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            
            $.ajax({
                url: 'http://127.0.0.1:8000/check-on-screen-notification-slot-and-approved',
                type: "POST",
                dataType: "json",
                headers:headers,
                data:{
                    notification_id : notification_id,
                },
                success:function(result) {
                     if (result.status == true) {
                            success_toast('', result.message);
                            reload_table();
                        }    
                }
            });
        }
    });