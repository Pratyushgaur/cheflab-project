@extends('vendor.chefs-layout')
@section('main-content')
<!-- Body Content Wrapper -->
<div class="ms-content-wrapper">
      <div class="row">
        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>
            </ol>
          </nav>
        </div>
        
        @include('vendor.chef.globleseting.setting_menu')

 

        
      </div>
    </div>



@endsection

@section('page-js')
{{-- <script>
  (function($) {
    let table = $('#order').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('order.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'order_status', name: 'order_status'},
            {data: 'order_total_price', name: 'order_total_price'},
            {data: 'pyment_type', name: 'pyment_type'},
            {data: 'order_time', name: 'order_time'},
            {data: 'created_at', name: 'created_at'},
           {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  })(jQuery);
</script> --}}
@endsection