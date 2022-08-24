var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#profile").change(function () {
    readURL(this);
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#fileold').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

        $("#expertform").validate({
            ignore: [],
            onfocusout: false,
            rules: {
                name: {
                    required: true,
                },
                designation: {
                    required: true,
                },
                linkedin_profile: {
                    required: true,
                },
                description: {
                    required: true,
                },

                profile: {
                    required:old_image,
                    //   accept:'png|jpg|jpeg|pdf|doc',
                }
            },
            // Specify the validation error messages
            messages: {
                name: {
                    required: '* Please enter name.',
                },
                designation: {
                    required: '* Please enter designation.',
                },
                linkedin_profile: {
                    required: '* Please enter linkedin profile.',
                },
                description: {
                    required: '* Please enter designation.',
                },

                profile: {
                    required: "* Please select file.",
                    // accept:'file type must be JPG|PDF|DOC',
                }

            },
            submitHandler: function (form) {
                $("#submit_sec_one").text("Please wait..");
                $("#submit_sec_one").attr("disabled", true);
                form.submit();
            }
        });
     
$('#profile').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
