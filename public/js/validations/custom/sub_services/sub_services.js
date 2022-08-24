var old_image=($('#product_image_old').val()== "") ? true : false;
$("#sub_service_image").change(function() {
    readURL(this);
 });
 function readURL(input) {
    if (input.files && input.files[0]) {
     var reader = new FileReader();

      reader.onload = function(e) {
        $('#fileold').attr('src', e.target.result);
      }
   reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
 }
 
$.validator.addMethod("chk_unique", function(value, element) {
    var ret = '';
    if ($('#sub_service_name').val() != '')   {
          
       var url = base_url+'admin/sub_services/Cn_sub_services/check_unique?news_id=' + $('#sub_service_id').val() + '&sub_service_name=' + $('#sub_service_name').val()+ '&main_id=' + $('#main_id').val()+ '&service_id=' + $('#service_id').val();
      
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
 '* This Sub service is already exists.'
);
$('#sub_serviceform').validate({
    ignore: ".note-editor *",
        //ignore: [],
        debug: false,
    rules: {
        main_id: {
            required: true
        },
        service_id: {
            required: true
        },
        description: {
            required: true
        },
        sub_service_image: {
            required: old_image
        },
        sub_service_name: {
            required: true,
            chk_unique: true,
        }
    },
    messages: {
        main_id: {
            required: "Select main services"
        },
        service_id: {
            required: "Select services"
        },
        
        description: {
            required: "Enter Description"
        },
        sub_service_name: {
            required: "Enter sub service name"
        }
    }

});

$('#sub_service_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
jQuery('#sub_service_name').on('input', function() {
    $(this).valid();
});
// $('#main_id').change(function () {
//     var main_id = $('#main_id').val();
//     if (main_id != '') {
//         $.ajax({
//             type: "post",
//             url: 'sub_services/Cn_sub_services/fetch_services',
//             data: { main_id: main_id },
//             success: function (data) {
//                 $('#service_id').html(data);

//             }
//         });
//     }

// });
    var servoces_id = $("#servoces_id").val();
    if (servoces_id == '') {} else {
        window.onload = category_fune();
    }
    function category_fune() {
        var doc_name = $("#main_id").val();
        var servoces_id = $("#servoces_id").val();
        $.ajax({
            url: base_url+"fetch-services",
            data: {
                doc_name: doc_name,
                servoces_id: servoces_id
            },
            type: "POST",
            success: function(html) {
                 //alert(html);
                $('#service_id').find("option:gt(0)").remove();
                $('#service_id').append(html);
                //  window.onload = category();

            }
        });
    }
