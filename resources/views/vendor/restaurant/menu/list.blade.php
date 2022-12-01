@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="{{route("restaurant.dashboard")}}"><i class="material-icons">home</i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Menus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu Catalogue</li>


              </ol>
            </nav>
        </div>
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Menu Catalogue</h6>
                </div>
                <a href="{{route('restaurant.menu.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create New</a>
              </div>
            </div>
            <div class="ms-panel-body">
              <div class="">
                <table id="menu-catalogue-table" class="table thead-primary">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>




      </div>
    </div>

@endsection

@section('page-js')
<script>
  (function($) {
    let table = $('#menu-catalogue-table').dataTable({
        ext:{errMode:'throw'},
        ajax: "{{ route('restaurant.menu.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'menuName', name: 'name'},
            {data: 'date', name: 'date'},

            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  })(jQuery);
</script>
@endsection
