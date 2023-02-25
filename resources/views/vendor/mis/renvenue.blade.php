@extends('vendor.restaurants-layout')
@section('main-content')
<link href="{{ asset('js/bootstrap-datepicker3.css') }}" rel="stylesheet">
<style>
  .datepicker.datepicker-dropdown.dropdown-menu {
    opacity: 1;
    visibility: unset;
  }

  .datepicker.datepicker-dropdown.dropdown-menu .datepicker-days .new {
    display: none;
  }
</style>
<div class="ms-content-wrapper">
  <div class="row">
    <div class="col-md-12">
      <h1 class="db-header-title">Revenue Data</h1>
    </div>
  </div>
  <div class="revenue_box  mb-4">
    <form action="{{ route('restaurant.mis.order.export') }}" enctype="multipart/form-data">
      <input type="hidden" name="id" id="vendorId" value="{{ Auth::guard('vendor')->user()->id }}">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="form-group mb-0">
            <div class="row align-items-center">
              <div class="col-3">
                <lable><b>Weekly Date: </b></lable>
              </div>
              <div class="col-md-9 px-md-0">
              
                              <input type="hidden" class="form-control" name="start_date" id="datePicker"  placeholder="Date" required value="{{ date('Y-m-d', strtotime('this week')) }} / {{ date('Y-m-d', strtotime('sunday')) }}" autocomplete="off" >
                                <div   id="reportrange"  style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                  <i class="fa fa-calendar"></i>&nbsp;
                                  <span >{{ date('F D, Y') }}</span> <i class="fa fa-caret-down"></i>
                                </div>
                             
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="filter_btn">
            <a href="javascript:void(0);" class="btn mt-0 btn-sm" onclick="filter_date()"><small>Filter</small></a>
          </div>
        </div>
        <div class="col-md-3">
          <div class="download_btn text-right">
            <button type="submit" class="btn mt-0">Download CSV</button>
          </div>
        </div>
      </div>

    </form>
  </div>

  <div class="revenue_ajax"></div>
  <div class="view_box">
    <div class="viewdownload_btn">
      <a href="javascript:void(0);" class="btn mt-0" onclick="view_detail()">View Detailed Report</a>
    </div>
  </div>
  <div id="viewDetail" style="display:none;" class="mt-5">

    <div class="ms-panel">
      <div class="ms-panel-header">
        <div class="d-flex justify-content-between">
          <div class="align-self-center align-left">
            <h6>Order List </h6>
          </div>
        </div>
      </div>
      <div class="ms-panel-body">
        <div class="table-responsive">
          <table class="table table-hover thead-primary w-100" id="example">
            <thead>
              <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Order ID</th>
                <th scope="col">Order Date</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Gross Revenue</th>
                <th scope="col">Net Receivable</th>
                <th scope="col">Payment Status</th>
                <th scope="col">Status</th>
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

<div class="modal" id="renvenue">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    </div>
  </div>
</div>
@endsection

@push('scripts')

 
<script src="{{asset('commonarea/ass/plugins/moment/moment.min.js')}}"></script><script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
 $(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('#datePicker').val(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);
 
});
  var start_date = $('#datePicker').val();
  revenue_ajax(start_date);



  let table = $('#example').dataTable({

    dom: 'Bfrtip',
    buttons: [{
      extend: 'excel',
      className: 'btn-info'
    }],
    processing: true,
    serverSide: true,
    // buttons: true,
    ajax: {
      url: "{{ route('restaurant.mis.order.data') }}",
      data: function(d) {
        d.status = $('#filter-by-status').val(),
          d.role = $('#filter-by-role').val(),
          d.vendor = $('#filter-by-vendor').val()
        d.datePicker = $('#datepicker').val()
        d.vendorId = $('#vendorId').val()
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
        data: 'order_date',
        name: 'order_date'
      },
      {
        data: 'payment_type',
        name: 'payment_type'
      },
      {
        data: 'gross_revenue',
        name: 'gross_revenue'
      },
      {
        data: 'net_receivables',
        name: 'net_receivables'
      },
      {
        data: 'payment_status',
        name: 'payment_status'
      },
      {
        data: 'status',
        name: 'status'
      },
      {
        data: 'action-js',
        name: 'action-js'
      },
    ]
  });


  function revenue_ajax(start_date) {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('restaurant.mis.renvenue.ajax') }}",
      method: "POST",
      data: {
        "_token": "{{ csrf_token() }}",
        "start_date": start_date
      },
      success: function(res) {
        $('.revenue_ajax').html(res);
      }
    });
  }


  function additions(start_date,end_date) {
    $('#renvenue .modal-content').html('');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('restaurant.mis.renvenue.addition') }}",
      method: "GET",
      data: {
        'start_date':start_date,'end_date':end_date
      },
      success: function(res) {
        $('#renvenue .modal-content').html(res);
        $('#renvenue').modal('show');
      }
    });
  }

  function deductions(start_date,end_date) {

    $('#renvenue .modal-content').html('');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('restaurant.mis.renvenue.deductions') }}",
      method: "GET",
      data: {
        'start_date':start_date,'end_date':end_date
      },
      success: function(res) {
        $('#renvenue .modal-content').html(res);
        $('#renvenue').modal('show');
      }
    });
  }


  function view_detail() {
    var start_date = $('#datePicker').val();
    $('#viewDetail').toggle();

  }

  function filter_date() {
    var start_date = $('#datePicker').val();

    revenue_ajax(start_date);
    table.DataTable().ajax.reload(null, false);

  }

  function settlements(){
          $('#renvenue .modal-content').html('');
          $.ajax({  
            headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }, 
              url :"{{ route('restaurant.mis.renvenue.settlements') }}",  
              method:"GET",  
              data:{ },
              success:function(res){  
                $('#renvenue .modal-content').html(res);
                $('#renvenue').modal('show');                    
              } 
          });
      }
</script>
@endpush