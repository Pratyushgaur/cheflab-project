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
            <h1>Create FAQ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create FAQ</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
				<div class="col-md-12">
        <form id="restaurant-form" action="{{route('admin.deliveryboy.update_faq')}}" method="post" enctype="multipart/form-data">
          @if ($errors->any())
              @foreach ($errors->all() as $error)
                  <div class="alert alert-danger">{{$error}}</div>
              @endforeach
          @endif
          @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_name">Question <span class="text-danger">*</span></label>
                        <input type="text" id="faq_question" value="{{$faq->faq_question}}" name="faq_question" value="{{!empty($class_name[0]->name) ? $class_name[0]->name : ''}}" class="form-control" placeholder="Your Question">
                        <input type="hidden" id="faq_question" value="{{$faq->id}}" name="id" value="{{!empty($class_name[0]->name) ? $class_name[0]->name : ''}}" class="form-control" placeholder="Your Question">
                        <input type="hidden" name="txtpkey" id="txtpkey" value="{{!empty($class_name[0]->id) ? $class_name[0]->id : ''}}">
                    </div>
                    <div class="form-group">
                        <label for="category_name">Answer <span class="text-danger">*</span></label>
                        <textarea type="text" id="position" value="{{$faq->faq_answer}}" name="faq_answer" value="{{!empty($class_name[0]->answer) ? $class_name[0]->answer : ''}}" class="form-control" placeholder="Your Answer ">{{$faq->faq_answer}}</textarea>
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
x
<script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.user.faqdata') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'faq_question', name: 'faq_question'},
            {data: 'faq_answer', name: 'faq_answer'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $("#restaurant-form").validate({
      rules: {
           faq_question: {
                required: true,
            },
            faq_answer: {
                required: true,
            },
        },
        messages: {
            faq_question: {
                remote:"Category  Already Exist",
            },
            faq_answer:{
                remote:"Position Required",
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