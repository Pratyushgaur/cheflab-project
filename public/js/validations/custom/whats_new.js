
$(document).ready(function () {
   $(function () {

      $("#whats_newform").validate({
         ignore: [],
         onfocusout: false,
         rules: {
            sec1_heading: {
               required: true,
            },
            description1: {
               required: true,
            },
            url: {
               required: true,
            },
         },
         // Specify the validation error messages
         messages: {
            sec1_heading: {
               required: '* Please enter heading.',
            },
            description1: {
               required: '* Please enter description.',
            },
            url: {
               required: '* Please enter url.',
            },
         },
         submitHandler: function (form) {
            $("#submit_sec").text("Please wait..");
            $("#submit_sec").attr("disabled", true);
            form.submit();
         }
      });
   });



    var fileold = ($("#fileold").val() != "") ? false : true;
   $(function () {

      $("#whats_newform2").validate({
         ignore: [],
         onfocusout: false,
         rules: {
            sec_two_heading: {
               required: true,
            },
            description2: {
               required: true,
            },
            image: {
               required: fileold,
            },
         },
         // Specify the validation error messages
         messages: {
              sec_two_heading: {
               required: '* Please enter heading.',
            },
            description2: {
               required: ' Please enter description.',
            },
            image: {
               required: '* Please select image.',
            },
         },
         submitHandler: function (form) {
            $("#submit_secs").text("Please wait..");
            $("#submit_secs").attr("disabled", true);
            form.submit();
         }
      });
   });




  var uploads = ($("#fileolde").val() != "") ? false : true;
   $(function () {

      $("#whats_newform3").validate({
         ignore: [],
         onfocusout: false,
         rules: {
            
            description3: {
               required: true,
            },
            images: {
               required: uploads,
            },
         },
         // Specify the validation error messages
         messages: {
            description3: {
               required: ' Please enter description.',
            },
            images: {
               required: '* Please select image.',
            },
         },
         submitHandler: function (form) {
            $("#submit_secse").text("Please wait..");
            $("#submit_secse").attr("disabled", true);
            form.submit();
         }
      });
   });


    });
