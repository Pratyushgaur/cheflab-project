var old_image=($('#product_image_old').val()== "") ? true : false;
$("#certificate").change(function() {
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
 var old_image1=($('#product_image_old1').val()== "") ? true : false;
$("#accredation_image").change(function() {
    readURL1(this);
 });
 function readURL1(input) {
    if (input.files && input.files[0]) {
     var reader = new FileReader();
     
      reader.onload = function(e) {
        $('#fileold2').attr('src', e.target.result);
      }
   reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
 }




$('#accredationform').validate({
rules:{
    heading:{
        required:true
    },
    description:{
        required:true
    },
    certificate:{
        required:old_image
    },
    accredation_image:{
        required:old_image1
    }
}
,
messages:{
    heading:{
        required:"Enter heading"
    },
    description:{
        required:"Enter Description"
    },
    certificate:{
        required:"upload certificate"
    },
    accredation_image:{
        required:"upload Image"
    }
}




});
$('#accredation_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
$('#certificate').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});