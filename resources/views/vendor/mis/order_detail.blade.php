  @extends('vendor.restaurants-layout')
  @section('main-content')

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/mis.css') }}" rel="stylesheet">
  <div class="ms-content-wrapper">
    <div class="row">
      <div class="col-md-12">
        <h1 class="db-header-title">Order Detail</h1>
      </div>
    </div>
    <div class="revenue_box  mb-4">
      <div class="row mb-4">
        <div class="col-4">
          <div class="card">
            <div class="card-body p-4">
              <h5 class="mb-3">Gross Revenue</h5>
              <h6>₹ {{ $order->gross_revenue }}</h6>
            </div>
          </div>
        </div>
        <!-- <div class="col-4">
          <div class="card">
            <div class="card-body p-4">
              <h5 class="mb-3">Additions</h5>
              <h6 class="text-danger">₹ {{ $order->additions }}</h6>
            </div>
          </div>
        </div> -->
        <div class="col-4">
          <div class="card">
            <div class="card-body p-4">
              <h5 class="mb-3">Deductions</h5>
              <h6 class="text-danger">₹ {{ $order->deductions }}</h6>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-body p-4">
              <h5 class="mb-3">Net Receivable</h5>
              <h6 class="text-success">₹ {{ $order->net_receivables }}</h6>
            </div>
          </div>
        </div>
      </div>

      

      <div class="card mt-5">
        <div class="card-body">
          <div class="table_box">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>
                    <table class="table table-borderless">
                      <tbody>
                        <tr>
                          <td class="border-bottom">
                            <h6>Order ID</h6>
                          </td>
                          <td class="border-bottom">{{ $order->order_id }}</td>
                        </tr>
                        <tr>
                          <td class="border-bottom">
                            <h6>Order Date</h6>
                          </td>
                          <td class="border-bottom">{{ $order->order_date }}</td>
                        </tr>

                      </tbody>
                    </table>
                  </td>
                  <td class="border-bottom">
                    <table class="table  table-borderless">
                      <tbody>
                        <tr>
                          <td class="border-bottom">
                            <h6>Status</h6>
                          </td>
                          <td class="border-bottom">{{ $order->order_status }}</td>
                        </tr>
                        <tr>
                          <td class="border-bottom">
                            <h6>Payment Method </h6>
                          </td>
                          <td class="border-bottom">{{ $order->payment_type }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td class="border-bottom">
                    <table class="table  table-borderless">
                      <tbody>
                        <tr>
                          <td class="border-bottom">
                            <h6>Payment Status</h6>
                          </td>
                          <td class="border-bottom">{{ $order->payment_status }}</td>
                        </tr>
                        <tr>
                          <!-- <td class="border-bottom">
                            <h6>Unsettled amount</h6>
                          </td>
                          <td class="border-bottom">₹0</td> -->
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <hr>
          <div class="table_box">
            <h6 class="mb-4 mt-3 text-primary">Deductions</h6>
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>
                    <table class="table table-borderless">
                      <tbody>
                        <tr>
                          <td class="border-bottom">
                            <h6>Commission</h6>
                          </td>
                          <td class="border-bottom">₹{{ $order->admin_commision }}</td>
                        </tr>
                        <tr>
                          <td class="border-bottom">
                            <h6>Tax On Commission</h6>
                          </td>
                          <td class="border-bottom">₹{{ $order->tax_on_commission }}</td>
                        </tr>

                      </tbody>
                    </table>
                  </td>
                  <td>
                    <table class="table table-borderless">
                      <tbody>
                        <tr>
                          <td class="border-bottom">
                            <h6>Convenience Fee (Including Tax)</h6>
                          </td>
                          <td class="border-bottom">₹{{ $order->total_convenience_fee }}</td>
                        </tr>
                        <tr> 
                        </tr>

                      </tbody>
                    </table>
                  </td>


                </tr>
              </tbody>
            </table>
          </div>
          <hr>
           
        </div>
      </div>
    </div>

  </div>


  @endsection

  @push('scripts')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker3.min.css">

  @endpush