var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#academic_image").change(function () {
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
// function reload_table() {
//     table.DataTable().ajax.reload(null, false);
// }
// $(document).on('click', '.delete-record', function (e) {
//     if (confirm('Do you really want to delete this acadminc partner ?')) {
//         var id = $(this).attr('id');
//         $.ajax({
//             url: base_url + 'soft-delete/' + id,
//             method: 'get',
//             data: {},
//             success: function (data) {
//                 reload_table();
//             }
//         });
//     }
// });

$('#academicform').validate({
    rules: {
        description: {
            required: true
        },
        academic_image: {
            required: old_image
        }
    },
    messages: {
        description: {
            required: "Enter description"
        },
        academic_image: {
            required: "Upload image"
        },
    },

});
$('#academic_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});