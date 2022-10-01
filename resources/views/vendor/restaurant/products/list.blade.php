@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Items</li>
                

              </ol>
            </nav>
        </div>
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Items</h6>
                </div>
                <a href="{{route('restaurant.product.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create New</a>
              </div>
            </div>
            <div class="ms-panel-body">
              <div class="">
                <table id="menu-catalogue-table" class="table thead-primary">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Admin Review</th>
                        <th scope="col">Created at</th>
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
        <div class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-labelledby="modal-8">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h3 class="modal-title has-icon text-white"><i class="flaticon-alert"></i> Reject Rejoin </h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <div id="price"></div> 
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
        ajax: "{{ route('restaurant.product.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'product_name', name: 'name'},
            {data: 'product_price', name: 'product_price'},
            {data: 'categoryName', name: 'categoryName'},
            {data: 'product_approve', name: 'product_approve'},
            {data: 'admin_review', name: 'admin_review'},
            {data: 'date', name: 'date'},
          
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  })(jQuery);
  $(document).on('click', '.openModal', function () {
        var id = $(this).data('id');
        $('#price').append("<p>'."+id+".'</p>");
  });
  $(document).on('click', '.offproduct', function () {
       var id = $(this).data('id');
       $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("restaurant.product.inactive")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: { 
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
              toastr.info('Product Inactive On App Successfully', 'Alert');
              window.location.reload();
            }
      });
  });
  $(document).on('click', '.onProduct', function () {
    var id = $(this).data('id');
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("restaurant.product.active")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: { 
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
              toastr.info('Your Product is Active On App ');
              window.location.reload();
            }
      });
  });
</script>

@endsection