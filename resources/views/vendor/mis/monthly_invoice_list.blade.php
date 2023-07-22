@extends('vendor.restaurants-layout')
@section('main-content')
<div class="ms-content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Monthly Invoice</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Monthly Invoice List</li>


                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <div class="ms-panel">
                <div class="ms-panel-header">
                    
                </div>
                <div class="ms-panel-body">
                    <div class="">
                    <table class="table table-hover thead-primary w-100" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">S.No.</th>
                                    <th scope="col">Invoice Number</th>
                                    <th scope="col">Month - Year</th>
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

@push('scripts')
<script>
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
            url: "{{ route('restaurant.mis.monthly_invoice_list_data') }}",
            data: function(d) {
                // d.status = $('#filter-by-status').val(),
                //     d.role = $('#filter-by-role').val(),
                //     d.vendor = $('#filter-by-vendor').val()
                // d.datePicker = $('#datepicker').val()
                // d.vendorId = $('#vendorId').val()
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'id',
                name: 'invoice_number'
            },
            {
                data: 'month_year',
                name: 'month_year'
            },
            {
                data: 'action-js',
                name: 'action-js'
            },
        ]
    });
</script>
@endpush