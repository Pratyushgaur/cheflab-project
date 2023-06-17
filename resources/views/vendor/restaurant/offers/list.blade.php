@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb pl-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                <li class="breadcrumb-item"><a href="#">Offer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Offer List</li>
                

              </ol>
            </nav>
        </div>
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <div class="d-flex justify-content-between">
                <div class="align-self-center align-left">
                  <h6>Offer List</h6>
                </div>
                <a href="{{route('restaurant.offer.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create New</a>
              </div>
            </div>
            <div class="ms-panel-body">
              <div class="">
                <table id="menu-catalogue-table" class="table thead-primary">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Offer</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                        <!-- <th scope="col">Status</th> -->
                        <th scope="col">Duration</th>
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
        ajax: "{{ route('restaurant.offer.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'offer_persentage', name: 'offer_persentage'},
            {data: 'from_date', name: 'from_date'},
            {data: 'to_date', name: 'to_date'},
            //{data: 'status', name: 'status',orderable: false ,searchable: false},
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
  $(document).on('click','.delete-offer',function(){
    if(confirm("Are You Sure")){
      return true;
    }else{
      return false;
    }
  })
  })(jQuery);
</script>
@endsection