
$(document).ready(function () {
    $(function () {
        $("#cityForm").validate({
            onfocusout: false,
             rules: {
                city_name: {
                    required: true,
                    remote: {
                        url: base_url + "/check-duplicate-city",
                        // url: "{{ route('city.duplicate-city') }}",
                        type: "post",
                        data: {
                          txtpkey:  function () {
                            return $("#txtpkey").val();
                          },
                          city_name: function () {
                            return $("#city_name").val();
                          },
                          _token : _token,
                        },
                    },
                }

            },
            // Specify the validation error messages
            messages: {
                city_name: {
                    required: '* Please enter city Name.',
                    remote:'* This city name are already in use'
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