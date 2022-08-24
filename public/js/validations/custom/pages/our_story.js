$(document).ready(function () {
   var old_image = ($('#product_image_old').val() == "") ? true : false;
   $("#sec1_image").change(function () {
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

      $("#storyform").validate({
         ignore: ".note-editor *",
        // ignore: [],
         onfocusout: false,
         rules: {
            sec1_heading: {
               required: true,
            },
            sec1_description: {
               required: true,
            },
            sec1_image: {
               required: fileold,
            },
            sec2_heading: {
               required: true,
            },
            sec2_description: {
               required: true,
            },
            sec3_heading1: {
               required: true,
            },
            sec3_heading2: {
               required: true,
            },
            sec3_description1: {
               required: true,
            },
            sec3_description2: {
               required: true,
            },
            sec4_heading: {
               required: true,
            },
            sec4_description: {
               required: true,
            }
         },
         // Specify the validation error messages
         messages: {
            sec1_heading: {
               required: '* Please enter heading.',
            },
            sec1_description: {
               required: '* Please enter description.',
            },
            sec1_image: {
               required: '* Please enter image.',
            },
            sec2_heading: {
               required: '* Please enter heading.',
            },
            sec2_description: {
               required: '* Please enter description.',
            },
            sec3_heading1: {
               required: '* Please enter heading.',
            },
            sec3_heading2: {
               required: '* Please enter heading.',
            },
            sec3_description1: {
               required: '* Please enter description.',
            },
            sec3_description2: {
               required: '*Please enter description',
            },
            sec4_heading: {
               required: '* Please enter heading.',
            },
            sec4_description: {
               required: '* Please enter description.',
            }

         },
         submitHandler: function (form) {
            $("#submit_sec_one").text("Please wait..");
            $("#submit_sec_one").attr("disabled", true);
            form.submit();
         }
      });
   });


});
