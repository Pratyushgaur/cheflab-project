@extends('vendor.chef-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Promotion management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Promotion</li>


                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Promotion</h6>
                            </div>
                            <a href="{{route('chef.promotion.create')}}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <div class="">
                            <table id="menu-catalogue-table" class="table thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Slot</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">From Date</th>
                                    <th scope="col">To Date</th>
                                    <th scope="col">From time</th>
                                    <th scope="col">To time</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Status</th>

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
        (function ($) {
            let table = $('#menu-catalogue-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('chef.slot.list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'slot_image', name: 'slot_image', orderable: false, searchable: false},
                    {data: 'from_date', name: 'from_date'},
                    {data: 'to_date', name: 'to_date'},
                    {data: 'from_time', name: 'from_time'},
                    {data: 'to_time', name: 'to_time'},
                    {data: 'position', name: 'position'},
                    {data: 'is_active', name: 'is_active'},
                ]
            });
        })(jQuery);
    </script>
@endsection
