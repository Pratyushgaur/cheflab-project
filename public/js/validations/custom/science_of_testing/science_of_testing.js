var old_image = $('#old_image').val() == "" ? true : false;
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
$('#science_of_testing_form').validate({
   rules: {
      heading: {
         required: true,

      },
      image: {
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
      image: {
         required: "upload image"
      },
      description: {
         required: "Enter Description"
      }
   }
});
