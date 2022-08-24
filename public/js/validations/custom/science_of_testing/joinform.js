var old_image = $('#product_image_old').val() == "" ? true : false;
// $(document).on("click", ".delete-record", function () {
//    var actionDiv = $(this);
//    var id = actionDiv.attr("data-id");
//    var flash = actionDiv.attr("flash");
//    var table = actionDiv.attr("table");

//    if (confirm("Do you really want to delete this record ?")) {
//       $.ajax({
//          url: base_url + "soft-delete",
//          type: "POST",
//          dataType: "json",
//          data: {
//             pk_id: id,
//             flashdata_message: flash,
//             table: table
//          },
//          beforeSend: function () {
//             actionDiv.html(
//                "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
//             );
//          },
//          success: function (data) {
//             success_toast(data.name, data.message);
//             reload_table();
//          },
//       });
//    }
// });

$("#science_image").change(function () {
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


$('#joinform').validate({
   ignore: [],
    onfocusout: false,
   rules: {
      heading: {
         required: true,

      },
      science_image: {
         required: old_image
      },
      description: {
         required: true
      }

   },
   messages: {

      heading: {
         required: "Enter science of testing heading"
      },
      science_image: {
         required: "upload image"
      },
      description: {
         required: "Enter Description"
      }



   }
});
$('#science_image').on('change', function() { // fires every time this field changes
   $(this).valid();                  // force a validation test on this field
});