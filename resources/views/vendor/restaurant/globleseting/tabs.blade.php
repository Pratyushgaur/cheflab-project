@extends('vendor.restaurants-layout')
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
        <div class="col-md-6">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Globel Setting</h6>

            </div>

            <div class="ms-panel-body">
              <div class="accordion" id="accordionExample1">
                <div class="card">
                  <div class="card-header" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span>Order Time</span>
                  </div>

                  <div id="collapseOne" class="collapse show" data-parent="#accordionExample1">
                    <div class="card-body">
                    <li> <a href="{{route('restaurant.globleseting.ordertime')}}" class="">Order Time Setting</a>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" data-toggle="collapse" role="button" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <span> Lorem Ipsum has been the industry standard dummy text</span>
                  </div>

                  <div id="collapseTwo" class="collapse" data-parent="#accordionExample1">
                    <div class="card-body">
                      Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition.
                      Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.
                    </div>
                  </div>
                </div>

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
</script>
@endsection