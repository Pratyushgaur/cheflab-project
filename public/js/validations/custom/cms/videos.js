var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#video_image").change(function () {
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
$('#videoform').validate({
    rules: {
        title: {
            required: true
        },
        date: {
            required: true
        },
        video_url: {
            required: true,
            url: true

        },
        video_image: {
            required: old_image
        }
    },
    messages: {

        title: {

            required: "Enter Title"
        },
        date: {
            required: "Enter date"
        },
        video_url: {
            required: "Enter Video URL"
        },
        video_image: {
            required: "Select video image"
        }
    },
     errorPlacement: function(error, element) {
                    if (element.prop('name') === 'title') {
                        error.appendTo('#title_error');
                    }
                    if (element.prop('name') === 'date') {
                        error.appendTo('#date_error');
                    }

                     if (element.prop('name') === 'video_url') {
                        error.appendTo('#video_url_error');
                    }

                     if (element.prop('name') === 'video_image') {
                        error.appendTo('#video_image_error');
                    }
                },

});
$('#video_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});