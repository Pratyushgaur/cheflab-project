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
                <div class="col-md-9">
                  <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="row invoice-info">
                        <div class="col-sm-3 invoice-col">
                          <b>Order ID:</b># {{$order->id}}<br>
                          <b>Date</b># {{$order->created_at}}<br>
                          
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <button type="button" class="btn btn-block btn-outline-primary">Edit Order</button>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <button type="button" class="btn btn-block btn-primary">Print Invoice</button>
                            <address>
                            <strong>Status, <button type="button" class="btn  btn-xs btn-outline-info">{{$order->payment_status}}</button></strong><br>
                            Payment Method:, {{$order->payment_type}}<br>
                            Reference Code : <button type="button" class="btn  btn-xs btn-outline-primary">Add</button><br>
                            Order Type: Delivery<br>
                            Payment Status : Unpaid
                          </address>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">About Me</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="card-body p-0">
                        <table class="table table-sm" id="example">
                          <thead>
                            <tr>
                              <th>Item Details</th>
                              <th>Addons</th>
                              <th style="width: 40px">Price</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($product as $val)          
                              <tr>
                                <td><img src="{{url('products')}}/'$val['product_image']'" style="width:50px; height:30px;">{{$val['product_name']}}</td>
                                <td><{{$val['primary_variant_name']}}</td>
                                <td>{{$val['product_price']}}</td>
                              </tr>
                            @endforeach
                        

                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-6">
                        <div class="table-responsive">
                          <table class="table">
                            <tr>
                              <th style="width:50%">Items Price:</th>
                              <td>{{$order->total_amount}}</td>
                            </tr>
                            <tr>
                              <th>Tax ({{$vendor->tax}}%)</th>
                              <td>{{$order->gross_amount}}</td>
                            </tr>
                            <tr>
                              <th>Total:</th>
                              <td>{{$order->net_amount}}</td>
                            </tr>
                          </table>
                        </div>
                    </div>


                  </div>






                </div>
                <div class="col-md-3">
                  <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="invoice-col">
                            Order Setup
                          <address>
                          
                            <div class="form-group">
                                <label for="exampleInputEmail1">Change Order Status<span class="text-danger">*</span></label>
                                <select class="form-control gstavailable" name="gst_available">
                                  <option >Status</option>
                                  <option >Pending</option>
                                  <option >Confirmed</option>
                                  <option >Processing</option>
                                  <option >Handover</option>
                                  <option >Out For Delivery</option>
                                  <option >Delivered</option>
                                  <option >Canceled</option>
                                </select>
                            </div> 
                            <button type="button" class="btn btn-block btn-primary">Assign Delivery Man Munally</button>
                          </address>
                        </div>
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
<script>
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
</script>

<script type="text/javascript">
  // $(function () {

    let table = $('#').dataTable({
        processing: true,
        serverSide: true,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'product_name', name: 'name'},
            {data: '', name: ''},
            {data: 'product_price', name: 'product_price'},
        ]
    });
  // });

  function reload_table() {
      table.DataTable().ajax.reload(null, false);
  }
  $('#filter-by-role').change(function(){
    $.ajax({
      method:"GET",
      action:"{{route('admin.vendor.byRole')}}",
      data:{
        role:$(this).val()
      },
      success:function(){

      }
    })
    //
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "POST",
        url: '{{route("admin.vendor.byRole")}}', // This is what I have updated
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { "_token": "{{ csrf_token() }}","role":$(this).val() },
        success: function(response){
          var html = '<option value="">Filter By Vendor</option>';
          for(var i=0;response.length >i; i++){
            html+='<option value="'+response[i].id+'">'+response[i].name+'</option>';
          }
          $('#filter-by-vendor').html(html);
        }
      }); 
  })

 </script>
@endsection