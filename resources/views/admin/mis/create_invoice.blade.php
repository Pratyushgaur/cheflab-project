@extends('admin.layouts.layoute')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="modal-header">
            <h4 class="modal-title">Genrate Invoice</h4>

        </div>


        <form id="restaurant-form" action="{{route('admin.mis.genrate.invoice')}}" method="post" >
            <div class="row">
            <input type="hidden" value=" {{ csrf_token() }}" name="_token">
            <input type="hidden" value=" {{ $vendor_id }}" name="vendor_id">
                <div class="col-md-4">
                    <!-- <input type="text" class="form-control" name="start_date" value="{{ date('Y-m-d', strtotime('this week')) }} / {{ date('Y-m-d', strtotime('sunday 1 week')) }}" placeholder="" id="datePicker"> -->
                    <input type="text" class="form-control" name="datepicker" id="datepicker" />
                </div>

                <div class="col-md-3" id="filter_yester" style="display:none;">
                    <input type="date" class="form-con">
                </div>
                <div class="col-3 mt-0 mb-3">
                    <div class="exportbtn text-end d-flex">

                        <button type="submit" class="me-2 btn btn-info text-white rounded-0 px-4 py-2">Genrate Invoice</button>
                        &nbsp;

                    </div>
                </div>
            </div>
        </form>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<link href="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>


<script>
 $("#datepicker").datepicker( {
    format: "mm-yyyy",
    startView: "months", 
    minViewMode: "months"
});
</script>


@endsection