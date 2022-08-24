$(document).ready(function () {
    $(function () {
        $("#vendorAddRestaurantProductForm").validate({
            onfocusout: false,
             rules: {
                vendor_category_id: {
                    required: true,
                },
                product_name: {
                    required: true,
                },
                quantity: {
                    required: true,
                },
                price: {
                    required: true,
                },
                offer_price: {
                    required: true,
                    // max: '#price'
                    max: function() {
                        return parseInt($('#price').val());
                    }
                },
                product_description: {
                    required: true,
                },
                unit: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
                vendor_category_id: {
                    required: '* Please select category.',
                },

                product_name: {
                    required: '* Please enter product name.',
                },
                 quantity: {
                    required: '* Please enter quantity.',
                },
                price: {
                    required: '* Please enter price.',
                },
                offer_price: {
                    required: '* Please enter offer price.',
                    max:'* Offer price should be less than price'
                },
                product_description: {
                    required: '* Please product description.',
                },
                unit: {
                    required: '* Please enter unit.',
                },
                
            },
            submitHandler: function (form) {
                $(".submit").text("Please wait..");
                $(".submit").attr("disabled", true);

               form.submit();
            }
        });


        $("#vendorRestoProductVariantForm").validate({
            onfocusout: false,
             rules: {
                
                variant_quantity: {
                    required: true,
                },
                variant_price: {
                    required: true,
                },
                variant_offer_price: {
                    required: true,
                    // max: '#price'
                    max: function() {
                        return parseInt($('#variant_price').val());
                    }
                },
                variant_unit: {
                    required: true,
                },
                

            },
            // Specify the validation error messages
            messages: {
                
                variant_quantity: {
                    required: '* Please enter quantity.',
                },
                variant_price: {
                    required: '* Please enter price.',
                },
                variant_offer_price: {
                    required: '* Please enter offer price.',
                    max:'* Offer price should be less than price'
                },
                variant_unit: {
                    required: '* Please enter unit.',
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


// Get subcategory on category
 $('#vendor_category_id').on('change',function(){
    var category_id = $(this).val();
    if(category_id != ''){
        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        // alert();
        $.ajax({
            url: base_url + '/get-sub-category-list-on-category-id',
            type: "POST",
            dataType: "json",
            headers:headers,
            data:{
                category_id : category_id,
            },
            success:function(result) {
                if(result.status == true){
                    $('#vendor_sub_category_id').html(result.sub_category_list);
                }
                if(result.status == false){
                    $('#vendor_sub_category_id').html('<option value="">Select Sub Category </option>');
                }
            }
        });
    }else{
        $('#vendor_sub_category_id').html('<option value="">Select Sub Category </option>');
    }
    
 });


// Delete Product varient
$(document).on('click', '.delete-product-variant', function() 
{           
    var actionDiv = $(this); 
    var id = actionDiv.attr('data-id');  
    var flash = actionDiv.attr('flash');
    var table = actionDiv.attr('table');
    var row_id = actionDiv.attr('row-id');
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    if (confirm('Do you really want to delete this record ?')) {
        $.ajax({
            url: base_url + '/soft-delete-of-vendor',                    
            type: 'POST',
            dataType: 'json',
            headers:headers,
            data: {id:id,flashdata_message:flash,table:table},
            beforeSend: function() {
                actionDiv.html(
                    "<i class='fa fa-spin fa-spinner' style='color: #0c0c0c !important;'></i>"
                );
            },
            success: function(data) {
                if (data.status == true) {
                    success_toast('', data.message);
                    // reload_table();
                    // $('#variant_row_'+row_id).remove();
                    location.reload();
                }                         
            }
        });
    }
});