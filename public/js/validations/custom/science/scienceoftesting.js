var old_image=($('#product_image_old').val()== "") ? true : false;

$("#science_image").change(function() {
    readURL(this);
});
function reload_table() {
    table.DataTable().ajax.reload(null, false);
}


function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
  
    reader.onload = function(e) {
        $('#fileold').attr('src', e.target.result);
    }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}


$('#scienceoftestingform').validate({
rules:{
    heading:{
         required:true
     },
     description:{
         required:true
     },
     science_image:{
         required:old_image
     }
},
messages:{
    heading:{
        required:"Enter heading"
    },
    description:{
        required:"Enter description"
    },
    science_image:{
        required:"upload image"
    }
}

 
});
$('#science_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
 });
 