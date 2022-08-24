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
$(document).on('click', '.delete_team', function (e) {

    if (confirm('Do you really want to delete this our team ?')) {
        var id = $(this).attr('id');

        $.ajax({
            url: base_url + 'soft-delete/' + id,
            method: 'get',
            data: {},
            success: function (data) {
                reload_table();
            }
        });
    }
});

$('#teamform').validate({
    ignore: ".note-editor *",
    //ignore: [],
    debug: false,
    rules: {
        name: {
            required: true
        },
        designation: {
            required: true
        },
        linkedin_profile: {
            required: true,
            url: true
        },
        description: {
            required: true
        },
        profile: {
            required: old_image
        }
    },
    messages: {
        name: {
            required: "Enter name"
        },
        designation: {
            required: "Enter designation"
        },
        linkedin_profile: {
            required: "Enter linkedin profile"
        },
        description: {
            required: "Enter Description"
        },
        profile: {
            required: "upload profile"
        }
    }

});
$('#profile').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
