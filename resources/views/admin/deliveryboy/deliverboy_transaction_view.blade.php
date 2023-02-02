<div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title">Order Transaction</h5>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>




<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
    <input type="hidden" id="riderId" value="{{ $rider_id }}">
      <div class="card-body pad table-responsive">
        <table id="example_transaction" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
          <thead>
            <tr role="row">
              <th class="text-center">S. No.</th>
              <th>Order ID</th>
              <th>Delivery Fee Earned</th>
              <th>Date</th>
            </tr>
          </thead>

        </table>
      </div>
    </div>

  </div>

</div>

<script type="text/javascript">
  window.transaction_table = $('#example_transaction').dataTable({

    dom: 'Bfrtip',
    buttons: [{
      extend: 'excel',
      className: 'btn-info',
      title: 'Account-rider'
    }],
    processing: true,
    serverSide: true,
    // buttons: true,
    ajax: {
      url: "{{ route('admin.delivery_boy.transaction.data') }}",
      data: function(d) {
        d.rider_id = $("#riderId").val()
      }
    },
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      },
      {
        data: 'order_id',
        name: 'order_id'
      },
      {
        data: 'earning',
        name: 'earning'
      },
      {
        data: 'date',
        name: 'date'
      },
     

    ]
  });

  </script>
