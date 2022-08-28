@extends('admin.layouts.layoute')
@section('content')


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Create New Product </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="product-form" method="POST" enctype='multipart/form-data' action="{{ url('admin/product-action') }}">
                      @csrf
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title">Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Product</label>
                                        <input type="text" name="product_name" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Product Name">
                                        <input type="hidden" name="userId" value="1">
                                        <input type="hidden" name="status" value="1">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Image</label>
                                          
                                          <div class="custom-file">
                                            <input type="file" name="product_image" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Categorie</label>
                                        <select class="form-control select2" name="category" style="width: 100%;">
                                            <option selected="selected">Select Category</option>
                                            <option value="1">Pizza</option>
                                        </select>
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Product Description</label>
                                          <textarea class="textarea" name="dis" placeholder="Place some text here"
                                         style="width: 100%; height: 30px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        
                                        <label for="exampleInputEmail1">Product Type</label><br>
                                        <input type="radio" name="type" value="veg"  id="radioSuccess2" data-rule-required="true"  placeholder="Enter Name">
                                        <label for="radioSuccess2">
                                            Veg
                                        </label>
                                        <input type="radio" name="type" value="nonveg"  id="radioSuccess2" data-rule-required="true"  placeholder="Enter Name">
                                        <label for="radioSuccess2">
                                            Non Veg
                                        </label>
                                        <input type="radio" name="type" value="eggs"  id="radioSuccess2" data-rule-required="true"  placeholder="Enter Name">
                                        <label for="radioSuccess2">
                                           Eggs
                                        </label>
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Ptoduct Owner</label>
                                          <input type="text" name="product_owner" class="form-control" data-rule-required="true" id="product_owner" placeholder="Product Owner">
                                      </div>
                                  </div>
                                 <!-- <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Customisation</label>
                                        
                                      <div class="custom-control custom-switch">
                                        <input type="checkbox"  onclick="myFunction()" name="customisation" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">OFF</label>
                                        
                                      </div>
                                    </div>  
                                  </div>-->
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Customisation</label>
                                          <input type="text" name="customisation" class="form-control" data-rule-required="true" id="product_owner" placeholder="Product Owner">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Product Keyword</label>
                                          <input type="text" name="product_keyword" class="form-control" id="product_keyword" placeholder="Product Keyword">
                                      </div>
                                  </div>
                                  <div class="input_fields_wrap" id="adds" style="display:none">
                                      <button class="add_field_button">Add More Fields</button>
                                  <div>
                                     
                                 </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </form>
                      
                    </div>

                  </div>

                </div>
                
              </div>
            </div>

          
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#product-form').validate({
        rules: {
            product_name: {
            required: true,
            maxlength: 50,
          },
          
        },
        messages: {
            product_name: {
            required: "Please enter Name of Product",
            maxlength: "You Have Enter Lots of Charactor"
          },
          
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
  })
 </script>
 <script>
    function myFunction() {
      var checkBox = document.getElementById("customSwitch1");
      var adds = document.getElementById("adds");
      
      if (checkBox.checked == true){
        adds.style.display = "block";
      } else {
        adds.style.display = "none";  
      }
    }
    
</script>
<script>
    $('.add').on('click', add);
    $('.remove').on('click', remove);

    function add() {
      var new_chq_no = parseInt($('#total_chq').val()) + 1;
      var new_input = "<input type='text' id='new_" + new_chq_no + "'>";

      $('#new_chq').append(new_input);

      $('#total_chq').val(new_chq_no);
    }

    function remove() {
      var last_chq_no = $('#total_chq').val();

      if (last_chq_no > 1) {
        $('#new_' + last_chq_no).remove();
        $('#total_chq').val(last_chq_no - 1);
      }
    }  
</script>
<script>
  $(document).ready(function() {
	var max_fields      = 10; //maximum input boxes allowed
	var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
	var add_button      = $(".add_field_button"); //Add button ID
	
	var x = 1; //initlal text box count
	$(add_button).click(function(e){ //on add input button click
		e.preventDefault();
		if(x < max_fields){ //max input box allowed
			x++; //text box increment
			$(wrapper).append('<div class="col-md-6"> <label for="exampleInputEmail1">Dis</label><input type="text" name="customisation[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
      $(wrapper).append('<div class="col-md-6"> <label for="exampleInputEmail1">Pice</label><input type="text" name="pice[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
		}
	});
	
	$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
		e.preventDefault(); $(this).parent('div').remove(); x--;
	})
});
</script>
@endsection