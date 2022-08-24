$(document).ready(function () {
   var old_image = ($('#product_image_old').val() == "") ? true : false;
   $("#image").change(function () {
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
   var fileold = ($("#product_image_old").val() != "") ? false : true;
   $(function () {

      $("#staticform").validate({
         ignore: [],
         onfocusout: false,
        rules: {
            heading: {
               required: true,
            },
            description: {
               required: true,
            },
            sample_process: {
               required: true,
            },
            test_perform: {
               required: true,
            },
            center: {
               required: true,
            },
            research_publication: {
               required: true,
            },
            image: {
               required: fileold,
            }
         },
         // Specify the validation error messages
         messages: {
            heading: {
               required: '* Please enter heading.',
            },
            description: {
               required: ' Please enter description.',
            },
            sample_process: {
               required: '* Please enter sample process.',

            },
            test_perform: {
               required: '* Please enter tests performed.',
            },
            center: {
               required: '* Please enter center.',
            },
            research_publication: {
               required: '* Please enter research publication.',
            },
            image: {
               required: '* Please enter image.',
            }
         },
         submitHandler: function (form) {
            $("#submit_btn").text("Please wait..");
            $("#submit_btn").attr("disabled", true);
            form.submit();
         }
      });
   });


});
 
// $('.submit').click(function (e) { 
//    var text = $(".summernote").summernote("code").replace(/&nbsp;|<\/?[^>]+(>|$)/g, "").trim();
 
//    if(text != ''){
//       $('#description-error').hide();
//       $("#btnForm").removeAttr("disabled");
//    }else{
//       $('#description-error').show();
//       $("#submit_btn").attr("disabled", false);
//      return false;
//    }

// });