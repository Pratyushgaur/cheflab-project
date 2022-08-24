
$(document).ready(function () {
    $(function () {
        $("#vendorForm").validate({
            onfocusout: false,
             rules: {
                category_id: {
                    required: true,
                },
                store_name: {
                    required: true,
                },
                store_owner_name: {
                    required: true,
                },
                vendor_comission: {
                    required: true,
                    number: true,
                },
                vendor_latitude: {
                    required: true,
                },
                vendor_longitude: {
                    required: true,
                  
                },
                 vendor_address: {
                    required: true,
                },
                delivery_range: {
                    required: true,
                    number: true,
                    
                },
                 vendor_email: {
                    required: true,
                    email: true
                },
                vendor_mobile_no: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password",
                },
                


            },
            // Specify the validation error messages
            messages: {
                category_id: {
                    required: '* Please select ctegory.',
                },
                store_name: {
                    required: '* Please enter store name.',
                },
                store_owner_name: {
                    required: '* Please enter store owner name.',
                },
                vendor_comission: {
                    required: '* Please enter commision.',
                    number: "The commision field only contain numerical digits.",
                },
                vendor_latitude: {
                    required: '* Please enter email id.',
                },
                 vendor_longitude: {
                    required: '* Please enter Longitude.',
                },
                vendor_address: {
                    required: '* Please enter vendor address.',
                },
                delivery_range: {
                    required: '* Please enter delivery range.',
                    number: "The delivery range field only contain delivery range.",
                },
                vendor_email: {
                    required: '* Please enter email id.',
                    email: "* Enter a valid email."
                },

                vendor_mobile_no: {
                    required: '* Please enter mobile no.',
                    number: "The mobile no field only contain numerical digits.",
                   minlength: "The mobile no field only contain 10 digits.",
                   maxlength: "The mobile no field only contain 10 digits."
                },
                password: {
                    required: '* Please enter password.',
                },
                confirm_password: {
                    required: '* Please confirm password.',
                    equalTo: "* New password and confirm new password does not match."
                },
                
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });
    });
});


$('#category_id').on('change',function() {
   var category_id = $('#category_id').val(); 
   if(category_id != ''){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
       
        // alert();
        $.ajax({
            url: base_url + '/get-store-type-of-category-id',
            type: "POST",
            dataType: "json",
            headers:headers,
            data:{
                category_id : category_id,
            },
            success:function(result) {

                if(result.status == true){
                    $('#vendor_store_type').empty();
                    $('#vendor_store_type').append('');
                    var dataObj = jQuery.parseJSON(result.store_type_list);
                    if (dataObj) {
                      $(dataObj).each(function() {
                        var option = $('<option />');
                        option.attr('value', this.id).text(this.store_type_name);
                        $('#vendor_store_type').append(option);
                      });
                    }
                }
                if(result.status == false){
                     $('#vendor_store_type').empty();
                    $('#vendor_store_type').append('');
                    $('#vendor_store_type').html('<option value=""></option>');
                }
                $('#vendor_store_type').multipleSelect({
                    placeholder: 'Select Sloat Type',
                    filter: true
                });
            }
        });
    }else{
        $('#vendor_store_type').html('<option value=""></option>');
    }
});