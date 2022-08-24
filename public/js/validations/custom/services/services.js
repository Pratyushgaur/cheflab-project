var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#service_image").change(function () {
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
 


 $.validator.addMethod("chk_unique", function(value, element) {
            var ret = '';
            if ($('#service_name').val() != '') {
               var url = base_url+'admin/services/Cn_services/check_unique?news_id=' + $('#service_id').val() + '&service_name=' + $('#service_name').val();
               // alert(url);
               $.ajax({
                  type: "get",
                  dataType: 'json',
                  url: url,
                  data: {},
                  async: false,
                  success: function(result) {
                     ret = result;
                  }
               });

               if (ret == false) {
                  return false;
               } else {
                  return true;
               }
            }
         },
         '* This Service is already exists.'
      );
$('#serviceform').validate({
     ignore: ".note-editor *",
        //ignore: [],
        debug: false,
    rules: {
        main_id: {
            required: true
        },
        service_name: {
            required: true,
             chk_unique: true,
        },
        description: {
            required: true
        },
        service_image: {
            required: old_image
        }

    },
    messages: {

        main_id: {
            required: "Select services"
        },
        service_name: {
            required: "Enter service name"
        },
        description: {
            required: "Enter Description"
        },
        service_image: {
            required: "upload image"
        },
    },
    submitHandler: function (form) {
        $("#servicebtn").attr("disabled", true);
        form.submit();
    }
});
$('#service_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});