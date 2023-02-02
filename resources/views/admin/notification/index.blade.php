@extends('admin.layouts.layoute')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Notification</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Notification</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="row mb-3">

            <div class="col-md-12">
                <form id="restaurant-form" action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    @csrf
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_name">Title <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_name">Zone <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Zone">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Send To <span class="text-danger">*</span></label>
                                        <select class="form-control" name="discount_type" style="width: 100%;">
                                            <option value="">Select</option>
                                            <option value="1">Rider</option>
                                            <option value="2">User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div>
                                            <label for="">Notification Banner <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <div class="upload-icon">
                                                    <img class="icon" src="">
                                                </div>
                                            </label>
                                            <input id="file-input" type="file" name="categoryImage">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="category_name">Description<span class="text-danger">*</span></label>
                                        <textarea id="name" name="name" class="form-control" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div>

                        <input type="submit" value="Send Notification" class="btn btn-success float-right">
                    </div>
                </form>
                <!-- /.card -->
            </div>
            <!--  -->




        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="notification_table" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                            <thead>
                                <tr role="row">
                                    <th class="text-center">Sr No.</th>
                                    <th>Title</th>
                                    <th>Zone</th>
                                    <th>Send To</th>
                                    <th>Notification Banner</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>


                <!-- /.card -->
            </div>
        </div>
    </section>



</div>
@endsection

@section('js_section')
<script type="text/javascript">
  window.notification_table = $('#notification_table').dataTable({

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
      url: "{{ route('admin.notification.notification_list') }}",
      data: function(d) {
        // d.rider_id = $("#riderId").val()
      }
    },
    columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      },
      {
        data: 'title',
        name: 'title'
      },
      {
        data: 'zone',
        name: 'zone'
      },
      {
        data: 'send_to',
        name: 'send_to'
      },
      {
        data: 'notification_banner',
        name: 'notification_banner'
      },
      {
        data: 'description',
        name: 'description'
      },
      {
        data: 'status',
        name: 'status'
      },
     

    ]
  });

  </script>

@endsection