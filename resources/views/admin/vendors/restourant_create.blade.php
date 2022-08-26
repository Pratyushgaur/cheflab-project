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
                      <h3 class="card-title">Create New Restaurant </h3>
                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form">
                          <div class="card card-default">
                              <div class="card-header">
                                <h3 class="card-title">Basic Information</h3>

                              </div>
                              <div class="card-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name of Restourant</label>
                                        <input type="text" name="name" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Name">
                                    </div>  
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="exampleInputEmail1">Email address</label>
                                          <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                      </div>
                                  </div>
                                  
                                </div>
                              </div>
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
    $('#restaurant-form').validate({
        rules: {
          name: {
            required: true,
            maxlength: 50,
          },
          
        },
        messages: {
          name: {
            required: "Please enter Name of Restourant",
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
@endsection