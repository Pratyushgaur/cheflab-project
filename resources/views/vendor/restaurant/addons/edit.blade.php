@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Products</a></li>
              <li class="breadcrumb-item" aria-current="page" ><a href="{{route('restaurant.product.addon')}}">Addons List</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit  Addons</li>


            </ol>
          </nav>
        </div>
        <div class="col-xl-6 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Create New  Addons</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="menu-form" action="{{route('restaurant.product.addon.update')}}"  method="post">
                @csrf
                <div class="form-row">
                  <div class="col-xl-12 col-md-12 mb-3">
                    <label for="validationCustom10">Edit Addon Product</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="name" value="{{$addons->addon}}"  id="validationCustom03" placeholder="Enter Product Addon Name " >
                      <input type="hidden" class="form-control" name="id" value="{{$addons->id}}"  id="validationCustom03" placeholder="Enter Product Addon Name " >
                    </div>
                    @error('name')
                      <p class="text-danger">
                          {{ $message }}
                      </p>
                    @enderror
                  </div>
                  <div class="col-xl-12 col-md-12 mb-3">
                    <label for="validationCustom10">Price</label>
                    <div class="input-group">
                      <input type="number" class="form-control" name="price" value="{{(int)$addons->price}}" id="validationCustom03" placeholder="Enter Price" >
                    </div>
                    @error('price')
                      <p class="text-danger">
                          {{ $message }}
                      </p>
                    @enderror
                  </div>


                </div>
                <button class="btn btn-primary float-right" type="submit">Update</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

@endsection

@section('page-js')
<script>
  (function($) {

  })(jQuery);
</script>
@endsection
