var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#banner_image").change(function () {
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
function reload_table() {
    table.DataTable().ajax.reload(null, false);
}
// $(document).on('click', '.change_status_banner', function (e) {
//     if (confirm('Do you really want to change this banner status ?')) {
//         var id = $(this).attr('id');
//         $.ajax({
//             url: base_url + 'change-banner/' + id,
//             method: 'get',
//             data: {},
//             success: function (data) {
//                 reload_table();
//             }
//         });

//     }
// });
$(document).on('click', '.delete_banner', function (e) {

    if (confirm('Do you really want to delete this banner ?')) {
        var id = $(this).attr('id');

        $.ajax({
            url: base_url + 'delete-banner/' + id,
            method: 'get',
            data: {},
            success: function (data) {
                reload_table();
            }
        });
    }
});



var fileold = ($("#product_image_old").val() != "") ? false : true;
$("#bannerform").validate({
    // ignore: ".note-editor *",
    // //ignore: [],
    // debug: false,
    rules: {
        banner_heading: {
            required: true,
        },
        banner_image: {
            required: fileold,
        },
         button_url: {
            required:true,
            url:true
        },
         button_name: {
            required: true,
        },

    },
    messages: {
        banner_heading: {
            required: "* Enter banner heading.",
        },

        banner_image: {
            required: "* Please select image.",
        },
         button_url: {
            required: "* Enter banner button url.",
        },
         button_name: {
            required: "* Enter banner button name.",
        },

    },
    submitHandler: function (form) {
        $("#submit_sec").attr("disabled", true);
        form.submit();
    }
});

$('#banner_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});



