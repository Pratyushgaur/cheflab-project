<?php
$breadcrumb[] = ["name"  => "Home",
                 "icon"  => '<i class = "material-icons">home</i>',
                 'route' => route("restaurant.dashboard")];
$breadcrumb[] = ["name"  => "Product",
                 'route' => route("restaurant.product.list")];
$breadcrumb[] = ["name"  => "Addons",
                 'route' => route("restaurant.product.addon")];
?>
@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                @include('vendor.vendor_breadcrumbs',['breadcrumb'=>$breadcrumb])      </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Addons List</h6>
                            </div>
                            <a href="{{route('restaurant.product.addon.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                                Create New</a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <div class="">
                            <table id="menu-catalogue-table" class="table thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Addons</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Date</th>
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

@section('page-js')

    <script>
        (function ($) {
            let table = $('#menu-catalogue-table').dataTable({
                ext: {errMode: 'throw'},
                ajax: "{{ route('restaurant.product.addon.datatable') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "searchable": true},
                    {data: 'addon', name: 'name', "searchable": true},
                    {data: 'price', name: 'price', "searchable": true},
                    {data: 'date', name: 'date', "searchable": true},

                    {data: 'action-js', name: 'action-js'},
                ]
            });
        })(jQuery);
    </script>
@endsection
