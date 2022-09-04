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
                      <h3 class="card-title">Create New Product for Restaurant  ({{$vendor->name}}) </h3>
                      

                      
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="product-form" method="POST" enctype='multipart/form-data' action="{{ url('admin/product-action') }}">
                      @if ($errors->any())
                          @foreach ($errors->all() as $error)
                              <div class="alert alert-danger">{{$error}}</div>
                          @endforeach
                      @endif
                        <input type="hidden"  name="userId" value="{{\Crypt::encryptString($vendor->id)}}">
                          @csrf
                        <div class="card card-default">
                          <div class="card-header">
                                <h3 class="card-title">Product Information</h3>
                          </div>
                          <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Name of Product</label>
                                      <input type="text" name="product_name" class="form-control" data-rule-required="true" id="exampleInputEmail1" placeholder="Enter Product Name">
                                    
                                  </div>  
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Cuisines</label>
                                      <select class="form-control select2" name="category" style="width: 100%;">
                                            @foreach($cuisines as $k =>$value)
                                              <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                      </select>
                                  </div>  
                                </div>


                                <div class="col-md-4">
                                  <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control select2" style="width: 100%;">
                                      @foreach($categories as $k =>$value)
                                      <option value="{{$value->id}}">{{$value->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                
                                

                                <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Product Description</label>
                                      <textarea class="form-control" name="dis" ></textarea>
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-group">
                                    
                                      <label for="exampleInputEmail1">Product Type</label><br>
                                      
                                      <div class="form-group clearfix">
                                        <div class="icheck-success d-inline">
                                          <input type="radio" id="veg" name="type" value="veg" checked>
                                          <label for="veg">Veg</label>
                                        </div>
                                        <div class="icheck-danger d-inline">
                                          <input type="radio" id="non_veg" name="type" value="non_veg">
                                          <label for="non_veg">Non Veg</label>
                                        </div>
                                        <div class="icheck-warning d-inline">
                                          <input type="radio" id="eggs" name="type" value="eggs">
                                          <label for="eggs">Eggs</label>
                                        </div>
                                        
                                      </div>
                                  </div>  
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                      <label for="">Product Price</label>
                                      <input type="text" name="product_price" class="form-control"  id="product_owner" placeholder="Product Price">
                                  </div>
                                </div>

                                <div class="col-md-3">
                                  <div class="form-group">
                                      <label for="">Customizable Availablity</label>

                                      
                                      <select name="customizable" id="customizable" class="form-control">
                                        <option value="false">No</option>
                                        <option value="true">Yes</option>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group">
                                      <label for="">Addons </label>
                                      <select name="customizable" id="" class="form-control">
                                        <option value="false">No</option>
                                        <option value="true">Yes</option>
                                      </select>
                                  </div>
                                </div>

                            
                              </div>

                                
                            </div>
                            <div class="custmization-block" style="display:none">
                              <div class="row">
                                <div class="col-md-12">
                                    <h3>Add More Variant</h3>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-4">
                                    <input type="text" class="form-control variant_name"  placeholder="Enter Variant Name">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control price" placeholder="Enter Price">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary add">Add This Variant</button>
                                </div>
                              </div>
                              <br>
                              <div class="variant-container"> 
                              </div>
                              
                            </div>
                            
                            

                          </div>
                          <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                              
                              
                                    <!-- <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div> -->
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
<script src="{{asset('commonarea/ass')}}/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript">
    $('.select2').select2()

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

      $('#customizable').change(function(){
        if ($(this).val() == 'true') {
          $('.custmization-block').show();
        } else {
          $('.custmization-block').hide();
        }
      })
      $('.add').click(function(){
        if ($('.variant_name').val() !='' && $('.price').val() !='') {
          var html = '<div class="row"><div class="col-md-4" style="text-align:center"><span>'+$('.variant_name').val()+'</span></div><div class="col-md-2"><span>'+$('.price').val()+'</span></div><div class="col-md-2"><button class="btn btn-danger "><i class="fa fa-trash"></i></button></div></div><br>';  
          $('.variant-container').append(html);
        }else{
          return false;
        }
        
        
      })
  })
 </script>
@endsection