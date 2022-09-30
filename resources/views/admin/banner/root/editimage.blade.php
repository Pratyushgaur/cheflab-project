@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
        .image-upload{
            display:inline-block;
            margin-right:15px;
            position:relative;
        }
        .image-upload > input
        {
            display: none;
        }
        .upload-icon{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        
        
        .upload-icon img{
          width: 100px;
          height: 100px;
          margin:19px;
          cursor: pointer;
        }
        
        
        .upload-icon.has-img {
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon.has-img img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        /*  */
        .upload-icon2{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon2 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon2.has-img2{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon2.has-img2 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
      </style>
@endsection
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Root Banner Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Root Banner Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-4">
        @if($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
        @endif
        <form id="restaurant-form" action="{{route('admin.root.update')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit</h3>

                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="category_name">Banner Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{$root->name}}" class="form-control" placeholder="Category Name">
                    <input type="hidden" name="id" id="txtpkey" value="{{$root->id}}">
                    <input type="hidden" name="txtpkey" id="txtpkey" value="{{$root->id}}">
                </div>
                
                <div class="form-group">
                    <div>
                        <label for="">Images <span class="text-danger">*</span></label>
                    </div>
                    <div class="image-upload">
                        <label for="file-input">
                            <div class="upload-icon">
                                <img class="icon" src="{{ asset('admin-banner'.'/'.$root->bannerImage) }}">
                            </div>
                        </label>
                        <input id="file-input" type="file" name="bannerImage" required/>
                    </div>      
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <div>
        
            <input type="submit" value="Save Changes" class="btn btn-success float-right">
        </div>
    </form>
    <!-- /.card -->
</div>

           
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

  <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>

<script type="text/javascript">
  // $(function () 
    $("#restaurant-form").validate({
          rules: {
            name: {
                  required: true,
                  maxlength: 25,
                  
              },
              bannerImage: {
                required: true,
            }
              
          },
          messages: {
            name:{
                remote:"Category Name Already Exist"
            },
            bannerImage:{
                remote:"Image Required",
            }
              
          }
      });
      $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
      $('#file-input2').change( function(event) {
          $("img.icon2").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon2").parents('.upload-icon2').addClass('has-img2');
      });
  
      
  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection