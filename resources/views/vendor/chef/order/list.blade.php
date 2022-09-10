@extends('chef.chef-layout')
@section('main-content')

<div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Orders</li>
              <li class="breadcrumb-item active" aria-current="page">Orders List</li>
            </ol>
          </nav>
          <div class="col-md-12">
            <div class="ms-panel ms-panel-fh">
              <div class="ms-panel-header">
                <h6>Favourite Orders</h6>
              </div>
              <div class="ms-panel-body order-circle">

                <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-6">
                      <h6 class="text-center">Pizza</h6>
                    <div class="progress-rounded progress-round-tiny">

                      <div class="progress-value">12%</div>
                      <svg>
                        <circle class="progress-cicle bg-success" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="12" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">
                        </circle>
                      </svg>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6">
                        <h6 class="text-center">Mexican Noodels</h6>
                    <div class="progress-rounded progress-round-tiny">
                      <div class="progress-value">38.8%</div>
                      <svg>
                        <circle class="progress-cicle bg-primary" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="38.8" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">
                        </circle>
                      </svg>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6">
                      <h6 class="text-center">Spicy Salad</h6>
                    <div class="progress-rounded progress-round-tiny">
                      <div class="progress-value">78.8%</div>
                      <svg>
                        <circle class="progress-cicle bg-secondary" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="78.8" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">
                        </circle>
                      </svg>
                    </div>
                  </div>
                  <div class="col-xl-3 col-lg-3 col-md-6">
                      <h6 class="text-center">French Fries</h6>
                    <div class="progress-rounded progress-round-tiny">
                      <div class="progress-value">100%</div>
                      <svg>
                        <circle class="progress-cicle bg-dark" cx="65" cy="65" r="57" stroke-width="4" fill="none" aria-valuenow="100" aria-orientation="vertical" aria-valuemin="0" aria-valuemax="100" role="slider">
                        </circle>
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="ms-panel">
              <div class="ms-panel-header">
                <h6> Order List</h6>
              </div>
              <div class="ms-panel-body">

                <div class="table-responsive">
                  <table class="table table-hover thead-primary" id="order">
                    <thead>
                      <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Tax</th>
                        <th scope="col">Delivery Fee</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Method</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    
                  </table>
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