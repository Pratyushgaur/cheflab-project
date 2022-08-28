@extends('admin.layouts.layoute')
@section('content')


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              
            </div><!-- /.container-fluid -->
          </section>

          <!-- Main content -->
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Listing of Product </h3>
                      <a href="" class="pull-right btn btn-sm btn-success " style="margin-left:100px; color:#fff;">Create New Product</a>
                     
                      
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                
                                    <th >Product Name</th>
                                    <th  >Category</th>
                                    <th  >Image</th>
                                    <th>Type</th>
                                    <th  >Action</th>
                                  </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $list)
                                <tr>
                          
                                <td>{{$list['product_name']}}</td>
                                <td>{{$list['category']}}</td>
                                <td><img src="{{$list['product_image']}}" style="width:75px;height:50px;"></td>
                                <td>{{$list['type']}}</td>
                                <td>
                                    <a href="{{url('admin/edit-product/'.$list['id'])}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    <a onclick="confirmation('')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>

                </div>
                
              </div>
            </div>

          
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')
<script type="text/javascript">
    $(".s_meun").removeClass("active");
    $(".city_cityadmin").addClass("active");
    $(".city_menu").addClass("active");
</script>


 <script type="text/javascript">
  // $(function () {
    let table = $('#example').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('product-list.getProduct') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'city_name', name: 'city_name'},
            {data: 'date', name: 'date'},
            {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
   }

 </script>
@endsection