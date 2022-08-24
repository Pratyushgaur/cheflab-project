var old_image=($('#product_image_old').val()== "") ? true : false;

$("#association_image").change(function() {
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
$(document).on('click','.delete_associations',function(e){ 
    
    if (confirm('Do you really want to delete this associations ?')) {
        var id=$(this).attr('id');
      
           $.ajax({
            url:base_url+'delete-associations/'+id,
            method:'get',
            data:{},
            success:function(data)
            {
               reload_table(); 
            }
        });
    }
});

$('#associationsform').validate({
    rules:{
        description:{
            required:true
        },
        association_image:{
            required:old_image
        }
    },
    messages:{


        description:{
            required:"Enter description"
        },
        association_image:{
            required:"upload image"
        }
    }



});
$('#association_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
