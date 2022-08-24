var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#gallery_image").change(function () {
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
 
$('#galleryform').validate({
    rules: {
        title: {
            required: true
        },
        gallery_image: {
            required: old_image
        }
    },
    messages: {
        title: {
            required: "Enter title"
        },
        gallery_image: {
            required: "upload images"
        }
    }

});
$('#gallery_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});