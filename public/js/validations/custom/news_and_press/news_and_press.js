var old_image = ($('#product_image_old').val() == "") ? true : false;
$("#news_image").change(function () {
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

 $.validator.addMethod("chk_unique", function(value, element) {
            var ret = '';
            if ($('#name').val() != '') {
               var url = base_url+'admin/news/Cn_news/check_unique?news_id=' + $('#news_ids').val() + '&name=' + $('#name').val();
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
         '* This News is already exists.'
      );
$(document).ready(function () {
$('#newsform').validate({
    ignore: ".note-editor *",
        //ignore: [],
        debug: false,
        onclick: false,
        onkeyup: false,
    rules: {
        name: {
            required: true,
            chk_unique: true,
        },
        date:{
            required:true
        },
        news_image:{
            required:old_image
        },
         
        description1:{
            required:true
        },
        meta_title:{
            required:true
        },
        meta_keyword:{
            required:true
        },
        description2:{
            required:true
        }

    },
    messages: {
        name: {
            required: "Enter name"
        },
        date:{
            required:"select Date "
        },
        news_image:{
            required:"Upload image"
        },
        
        description1:{
            required:"Enter description"
        },
        meta_title:{
            required:"Enter meta title"
        },
        meta_keyword:{
            required:"Enter meta keyword"
        },
        description2:{
            required:"Enter description"
        }


    }

});
$('#news_image').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
$('#name').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
$('#slug_url').on('change', function() { // fires every time this field changes
    $(this).valid();                  // force a validation test on this field
});
    
      });
$("#name").keyup(function () {
    $("#slug_url").val($(this).val().split(" ").join("-").toLowerCase());
});

