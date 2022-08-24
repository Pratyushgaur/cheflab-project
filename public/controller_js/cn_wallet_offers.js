
$(document).ready(function () {
    $(function () {
        $("#normalPlanForm").validate({
            onfocusout: false,
             rules: {
                wallet_amount: {
                    required: true,
                    remote: {
                        url: base_url + "/check-duplicate-plan",
                        // url: "{{ route('city.duplicate-city') }}",
                        type: "post",
                        data: {
                          txtpkey:  function () {
                            return $("#txtpkey").val();
                          },
                          wallet_amount: function () {
                            return $("#wallet_amount").val();
                          },
                          _token : _token,
                        },
                    },
                }

            },
            // Specify the validation error messages
            messages: {
                wallet_amount: {
                    required: '* Please enter wallet amount.',
                    remote:'* This plan amount already added'
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



$(document).ready(function () {
    $(function () {
        $("#offerPlanForm").validate({
            onfocusout: false,
             rules: {
                offer_amount: {
                    required: true,
                    number:true,
                },
                discount_value_type: {
                    required: true,
                },
                discount_amount: {
                    required: true,
                    number:true,
                },
                maximum_offer: {
                    required: true,
                    number:true,
                },

            },
            // Specify the validation error messages
            messages: {
                offer_amount: {
                    required: '* Please enter Offer amount.',
                },
                discount_value_type: {
                    required: '* Please select discount type.',
                },
                discount_amount: {
                    required: '* Please enter discount value.',
                },
                maximum_offer: {
                    required: '* Please enter maximum offer amount.',
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