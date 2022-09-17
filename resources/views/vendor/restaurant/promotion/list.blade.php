@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Promotion management</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promotion</li>
                

              </ol>
            </nav>
        </div>
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Promotion</h6>
                </div>
                <a href="{{route('restaurant.promotion.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create New</a>
              </div>
            </div>
            <div class="ms-panel-body">
              <div class="">
                <table id="menu-catalogue-table" class="table thead-primary">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Slot</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        
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
        processing: true,
        serverSide: true,
        ajax: "{{ route('restaurant.slot.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'banner', name: 'banner'},
            {data: 'slot_image', name: 'slot_image',orderable: false, searchable: false},
            {data: 'date', name: 'date'},
            {data: 'slot_status', name: 'slot_status'},
        ]
    });
  })(jQuery);
</script>
@endsection