@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Menus</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="{{route('restaurant.menu.list')}}">Menu Catalogue</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Menu Catalogue</li>
              

            </ol>
          </nav>
        </div>
        <div class="col-xl-6 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Edit  Menu</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="menu-form" action="{{route('restaurant.menu.update')}}"  method="post">
                @csrf
                
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                <div class="form-row">
                  <div class="col-xl-12 col-md-12 mb-3">
                    <label for="validationCustom10">Name of Menu</label>
                    <div class="input-group">
                      <input type="text" value="{{$menu_data->menuName}}" class="form-control" name="name"  id="validationCustom03" placeholder="Enter Menu Name " >
                      <input type="hidden" value="{{$menu_data->id}}" name="id">
                    </div><br>
                    @error('name')
                      <p class="text-danger">
                          {{ $message }}
                      </p>
                    @enderror
                  </div>
                    
                  
                </div>
                <button class="btn btn-primary float-right" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  
@endsection

@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script type="text/javascript">
     $("#menu-form").validate({
        rules: {
            name: {
                  required: true,
                  maxlength: 25,
                  remote: '{{route("restaurant.menu.check_duplicate.edit",$menu_data->id)}}',
              },
              
          },
          messages: {
              name:{
                remote:"Menu Name Already Exist"
              }
              
          }
    });
</script>
<script>
  (function($) {
    
  })(jQuery);
</script>
@endsection