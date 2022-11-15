<?php
$product_approve = config('custom_app_setting.product_approve');
$product_status = config('custom_app_setting.product_status');
?>
@extends('vendor.restaurants-layout')
@section('main-content')

    <div class="ms-content-wrapper">
        <div class="row">

            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pl-0">
                        <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Items</li>


                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <div class="ms-panel">
                    <div class="ms-panel-header">
                        <div class="d-flex justify-content-between">
                            <div class="align-self-center align-left">
                                <h6>Items</h6>
                            </div>
                            <a href="{{route('restaurant.product.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                                Create New</a>
                        </div>
                    </div>
                    <div class="ms-panel-body">
                        <code>You have total products: {{$product_count}}</code>
                        <div class="table-responsive">
                            <table id="" class="table thead-primary">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Product Price</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Admin Review</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <form action="{{route('restaurant.product.list')}}" method="get">
                                        <td scope="col">#</td>
                                        <td scope="col">{{ Form::text('name', app()->request->name, ['class' => 'form-control', 'placeholder' => 'Name']) }}</td>
                                        <td scope="col">{{ Form::number('price', app()->request->price, ['class' => 'form-control', 'placeholder' => 'price']) }}</td>
                                        <td scope="col">{{ Form::select('categories', $categories,app()->request->categories, ['class' => 'form-control select2', 'placeholder' => 'Select']) }}</td>
                                        <td scope="col">{{ Form::select('status', $product_status,app()->request->status, ['class' => 'form-control select2', 'placeholder' => 'Select']) }}</td>
                                        <td scope="col">{{ Form::select('approve', $product_approve,null, ['class' => 'form-control select2', 'placeholder' => 'Select']) }}</td>
                                        <td scope="col"><a href="{{route('restaurant.product.list')}}" class="btn-info btn-sm">Reset</a></td>
                                        <td scope="col">
                                            <button type="submit" class="btn-primary btn-sm">Search</button>
                                        </td>
                                    </form>
                                </tr>
                                <?php $count = 1;
                                ?>
                                @if(count($products)<=0)
                                    <tr>
                                        <td colspan="8">No record found</td>
                                    </tr>
                                @else
                                    @foreach($products as $k=>$product)
                                        <tr>
                                            <td>{{$count++}}</td>
                                            <td>{{$product->product_name}}</td>
                                            <td>{{$product->product_price}}</td>
                                            <td>{{$product->categoryName}}</td>
                                            <td>
                                                <?php if ($product->product_approve == 1) {
                                                    $btn = '<label class="ms-switch"><input type="checkbox" checked> <span class="ms-switch-slider round offproduct" data-id="' . $product->id . '"></span></label>';
                                                } elseif ($product->product_approve == 0) {
                                                    $btn = '<label class="ms-switch"><input type="checkbox"> <span class="ms-switch-slider round onProduct" data-id="' . $product->id . '"></span></label>';
                                                } else {
                                                    $btn = '<label class="ms-switch"><input type="checkbox" disabled> <span class="ms-switch-slider round"></span></label>';
                                                }
                                                echo $btn;
                                                ?>
                                            </td>
                                            <td><?php if ($product->status == 1) {
                                                    $btn = '<span class="badge badge-success">Active</span>';
                                                } elseif ($product->status == 2) {
                                                    $btn = '<span class="badge badge-primary">Pending</span>';
                                                } elseif ($product->status == 0) {
                                                    $btn = '<span class="badge badge-primary">Inactive</span>';
                                                } else {
                                                    $btn = '<a href="javascript:void(0)" class="openModal"  data-id="' . $product->comment_reason . '"><span class="badge badge-primary" data-toggle="modal" data-target="#modal-8">Reject</span></a>';
                                                }
                                                echo $btn;?></td>
                                            <td>{{front_end_short_date_time($product->created_at)}}</td>

                                            <td><?php if ($product->status == '1') {?>
                                                <a href="{{route('vendor.product.edit', ['id' => Crypt::encryptString($product->id)])}}"><i class="fa fa-edit"></i></a>
                                                <a href="{{route('restaurant.product.delete', ['id' => Crypt::encryptString($product->id)])}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i></a>
                                                <?php } else {?>
                                                <a onclick="return confirm('Are you sure you want to delete this item?');" href="{{route('restaurant.product.delete', ['id' => Crypt::encryptString($product->id)])}}"><i class="fa fa-trash"></i></a>
                                                <?php } ?></td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="">{{ $products->links('vendor.pagination.bootstrap-4') }}</div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-8" tabindex="-1" role="dialog" aria-labelledby="modal-8">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h3 class="modal-title has-icon text-white"><i class="flaticon-alert"></i> Reject Rejoin
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>

                        <div class="modal-body">
                            <div id="price"></div>
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
                ajax: "{{ route('restaurant.product.datatable') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'product_name', name: 'name'},
                    {data: 'product_price', name: 'product_price'},
                    {data: 'categoryName', name: 'categoryName'},
                    {data: 'product_approve', name: 'product_approve'},
                    {data: 'admin_review', name: 'admin_review'},
                    {data: 'date', name: 'date'},

                    {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
                ]
            });
        })(jQuery);
        $(document).on('click', '.openModal', function () {
            var id = $(this).data('id');
            $('#price').append("<p>'." + id + ".'</p>");
        });
        $(document).on('click', '.offproduct', function () {
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route("restaurant.product.inactive")}}', // This is what I have updated
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function (response) {
                    toastr.info('Product Inactive On App Successfully', 'Alert');
                    window.location.reload();
                }
            });
        });
        $(document).on('click', '.onProduct', function () {
            var id = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '{{route("restaurant.product.active")}}', // This is what I have updated
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function (response) {
                    toastr.info('Your Product is Active On App ');
                    window.location.reload();
                }
            });
        });
    </script>

@endsection
