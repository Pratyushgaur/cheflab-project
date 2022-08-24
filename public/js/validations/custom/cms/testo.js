var old_image=($('#product_image_old').val()== "") ? true : false;
$("#testo_image").change(function() {
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
 function reload_table() {
    table.DataTable().ajax.reload(null, false);
}
 $(document).on('click','.delete_testo',function(e){ 
    if (confirm('Do you really want to delete this testominal ?')) {
        var id=$(this).attr('id');
        $.ajax({
            url:base_url+'delete-testo/'+id,
            method:'get',
            data:{},
            success:function(data)
            {
               reload_table();
            }
        });
    }
});
$(document).on('click','.change_status_testo',function(e){
    if (confirm('Do you really want to change this testo status ?')) {
        var id=$(this).attr('id');
        $.ajax({
           url:base_url+'change-testo/'+id,
            method:'get',
            data:{},
            success:function(data)
            {
               reload_table();
           }
        });
        
    }
});


$('#testominalform').validate({
rules:{
    section1_heading:{
     required:true
    },
    company:{
      required:true
    },
    date:{
        required:true
    },
    description:{
        required:true
    },
    testo_image:{
        required:old_image
    }
 },
messages:{
    section1_heading:{
        required:"Enter testominal name"
    },
    company:{
        required:"Enter Company name"
    },
    date:{
        required:"blog date",
    },
    description:{
        required:"Enter description"
    },
    testo_image:{
        required:"upload image"
    }
}
});
$('#testo_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});