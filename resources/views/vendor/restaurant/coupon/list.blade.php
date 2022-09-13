@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Coupon</a></li>
                <li class="breadcrumb-item active" aria-current="page">Coupon List</li>
                

              </ol>
            </nav>
        </div>
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Coupon List</h6>
                </div>
                <a href="{{route('restaurant.coupon.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create New</a>
              </div>
            </div>
            <div class="ms-panel-body">
              <div class="">
                <table id="menu-catalogue-table" class="table thead-primary">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Code</th>
                        <th scope="col">Discount Type</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Expire At</th>
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
        processing: true,
        serverSide: true,
        ajax: "{{ route('restaurant.coupon.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'code', name: 'code'},
            {data: 'discount_type', name: 'discount_type'},
            {data: 'discount', name: 'discount'},
            {data: 'expires_coupon', name: 'expires_coupon'},
          
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  })(jQuery);
</script>
@endsection