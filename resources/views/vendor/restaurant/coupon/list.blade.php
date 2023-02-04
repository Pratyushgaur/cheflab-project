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
                        <th scope="col">Code Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Discount Type</th>
                        <th scope="col">Apply Status</th>
                        <th scope="col">Durations</th>
                        <th scope="col">Running</th>
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
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'discount_type', name: 'discount_type'},
            {data: 'status', name: 'status'},
            {data: 'duration', name: 'duration',orderable: false ,searchable: false},
            {data: 'expired', name: 'expired',orderable: false ,searchable: false},
            
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
    $(document).on('click', '.couponOff', function () {
       var id = $(this).data('id');
       $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("restaurant.coupon.inactive")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: { 
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
              toastr.error('Coupon Inactive Successfully', 'Alert');
              
            }
      });
      $(this).removeClass('couponOff');
      $(this).addClass('couponON');
  });
  $(document).on('click', '.couponON', function () {
       var id = $(this).data('id');
       $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          type: "POST",
          url: '{{route("restaurant.coupon.active")}}', // This is what I have updated
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: { 
            "_token": "{{ csrf_token() }}",
            "id":id },
            success: function(response){
              toastr.info('Your Coupon is Active ');
              
            }
      });
      $(this).removeClass('couponON');
      $(this).addClass('couponOff');
  });
  })(jQuery);
</script>
@endsection