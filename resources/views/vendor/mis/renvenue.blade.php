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
        <div class="col-md-12">
          <div class="form-group mb-0">
            <div class="row align-items-center">
               <div class="col-md-2 " >
                <label for="">Select Year</label>
                <select name="" id="select_year" class="form-control" onChange="getWeek();">
                    <option value="">Select Year</option>
                    <?php 
                      for($i=2023;$i <= 2030; $i++){
                        if($i == date("Y")){
                          $selected = 'selected';
                        }else{
                          $selected = '';

                        }
                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                      }
                    ?>
                </select>
               </div>
               <div class="col-md-3 " >
                <label for="">Select Month</label>
                  <select name="" id="filter-by-month" class="form-control" onChange="getWeek();">
                    <option value="">Select Month</option>
                    <option value="01" @if(date('m') == '01') selected @endif>Jan</option>
                    <option value="02" @if(date('m') == '02') selected @endif>Feb</option>
                    <option value="03" @if(date('m') == '03') selected @endif>March</option>
                    <option value="04" @if(date('m') == '04') selected @endif>April</option>
                    <option value="05" @if(date('m') == '05') selected @endif>May</option>
                    <option value="06" @if(date('m') == '06') selected @endif>Jun</option>
                    <option value="07" @if(date('m') == '07') selected @endif>July</option>
                    <option value="08" @if(date('m') == '08') selected @endif>Aug</option>
                    <option value="09" @if(date('m') == '09') selected @endif>Sep</option>
                    <option value="10" @if(date('m') == '10') selected @endif>Oct</option>
                    <option value="11" @if(date('m') == '11') selected @endif>Nov</option>
                    <option value="12" @if(date('m') == '12') selected @endif>Dec</option>
                    
                  </select>  
               </div>
               <div class="col-md-4 " >
                  <label for="">Select Week</label>
                  <select name="" id="filter-by-week" class="form-control" onChange="filter_date()">
                      <option value="<?php echo date('d-m-Y',strtotime($start)).'&'.date('d-m-Y',strtotime($end)); ?>"><?php echo date('d-M-Y',strtotime($start)).' TO '.date('d-M-Y',strtotime($end)); ?></option>
                      
                  </select>
               </div>
               <!-- <div class="col-md-3 " >
                
                  <div class="filter_btn" style="margin-top:25px;">
                    <a href="javascript:void(0);" class="btn mt-0 btn-sm btn-primary" onclick="filter_date()"><small>Filter</small></a>
                  </div>
               </div> -->
            </div>
          </div>
        </div>
        <!-- <div class="col-md-3">
          <div class="filter_btn">
            <a href="javascript:void(0);" class="btn mt-0 btn-sm btn-primary" onclick="filter_date()"><small>Filter</small></a>
          </div>
        </div> -->
        <div class="col-md-3">
          <div class="download_btn text-right">
            <!-- <button type="submit" class="btn mt-0">Download CSV</button> -->
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
                
                <th scope="col">Gross Revenue</th>
                <th scope="col">Net Receivable</th>
               
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

//var start = moment().subtract(29, 'days');
var start = moment().startOf('week').subtract(6,'days');
var end = moment().endOf('week').subtract(6, 'days');
//var end = moment().endOf('week');
//alert(end.format('MMMM D, YYYY'));
//var end = moment();

function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('#datePicker').val(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
      //  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      //  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
      //  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
      'Last Week':[moment().startOf('week').subtract(6,'days'),moment().endOf('week').subtract(6, 'days')],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);
 
});
  getWeek();
  //revenue_ajax(start_date);


  function revenue_ajax() {
    var week = $('#filter-by-week').val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('restaurant.mis.renvenue.ajax') }}",
      method: "POST",
      data: {
        "_token": "{{ csrf_token() }}",
        "start_date": week
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

  function getWeek(){
    
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('restaurant.mis.week.get') }}",
      method: "GET",
      data: {
        'year':$("#select_year").val(),'month':$("#filter-by-month").val()
      },
      success: function(res) {
        $('#filter-by-week').html(res);
        revenue_ajax();
      }
    });
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
<script>
  
  let table = $('#example').dataTable({
    
    dom: 'Bfrtip',
    buttons: [{
      extend: 'excel',
      className: 'btn-info'
    }],
    processing: true,
    serverSide: true,
    paging: false,
    // buttons: true,
    ajax: {
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('restaurant.mis.order.data') }}",
      
      data: function(d) {
        d.status = $('#filter-by-status').val(),
        d.role = $('#filter-by-role').val(),
        d.vendor = $('#filter-by-vendor').val()
        d.datePicker = $('#filter-by-week').val()
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
        data: 'gross_revenue',
        name: 'gross_revenue'
      },
      {
        data: 'net_receivables',
        name: 'net_receivables'
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
</script>
@endpush