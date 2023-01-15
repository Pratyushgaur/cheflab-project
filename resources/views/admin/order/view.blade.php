@extends('admin.layouts.layoute')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .mainpart p{
   font-size: 18px;
   }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-8">
               <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                     <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                           <h5 class="text"><b>Order ID #{{$order->order_id}}</b></h5>
                           <p><i class="fa fa-calendar-o pr-2" aria-hidden="true"></i> {{ date('d M Y h:s',strtotime($order->created_at)) }}</p>
                           <p><b class="text-dark"><i class="fa fa-home" aria-hidden="true"></i>  Restaurant: </b> <span class="text-primary ml-1">{{ ucwords($vendor->name) }}</span></p>
                           <p><b class="text-dark"><i class="fa fa-circle" aria-hidden="true"></i>  Send Cutlery: </b> <span class="text-primary ml-1">@if($order->send_cutlery){{"Yes"}}@else {{"No"}} @endif</span></p>
                           <p><b class="text-dark"><i class="fa fa-envelope" aria-hidden="true"></i>  Chef message: </b> <span class="text-primary ml-1">{{$order->chef_message}}</span></p>
                        </div>
                        <div class="col-sm-6 invoice-col text-right">
                           <div class="mb-3">
                              <!-- <button type="button" class="btn btn-outline-primary"><i class="nav-icon fas fa-edit" aria-hidden="true"></i> Edit Order</button> -->
                              <a  href="{{ url('admin/order/generate-invoice/') }}/{{ $order->order_id }}" class="btn  btn-primary"><i class="fa fa-print" aria-hidden="true"></i>  Print Invoice</a>
                           </div>
                           <address class="mainpart">
                              <p class="mb-1"><small>Status</small>:
                              <?php 
                                if($order->order_status == 'pending'){
                                  $color = 'warining';
                                }elseif($order->order_status == 'completed'){
                                  $color = 'success';
                                }elseif($order->order_status == 'accepted'){
                                  $color = 'primary';
                                }else{
                                  $color = 'danger';
                                }
                              ?>

                              <button type="button" class="ml-2 btn px-2 py-1 btn-sm  btn-outline-{{ $color }}">{{ ucwords($order->order_status) }}</button>
                            </p>
                              <p class="mb-1"><small class="ml-2">Payment Method</small>: {{ $order->payment_type }}</p>
                              <!-- <p class="mb-1"> <small>Reference Code</small>: <button type="button" class="ml-2 btn px-2 py-1 btn-sm btn-outline-primary badge badge-soft-success">Add</button></p> -->
                              <!-- <p class="mb-1"><small>Payment Status</small>: <small class="text-danger ml-2"><b>{{ ucwords($order->payment_status) }} </b></small></p> -->

                              

                           </address>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card card-primary">
                  <div class="card-header">
                     <h3 class="card-title">Customer Product</h3>
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
                                 <td>
                                    <div class="media media--sm">
                                       <a class="avatar avatar-xl mr-3" href="javascript:void(0);">
                                       @if($val['product_image']!='')
                                       <img class="img-fluid rounded" src="<?php echo asset('products/')?>/<?php echo $val['product_image'];?>" alt="Image Description" width="60">
                                       @endif
                                       
                                       </a>
                                       <div class="media-body">
                                          <div>
                                             <strong class="line--limit-1">{{$val['product_name']}}</strong>
                                             
                                             <div class="font-size-sm text-body">
                                                <span>type : </span>
                                                <span class="font-weight-bold">{{ $val['type'] }}</span>
                                             </div>
                                             <div class="font-size-sm text-body">
                                                <span>Rate : </span>
                                                <span class="font-weight-bold">{{ $val['product_price'] }} * ({{$val['product_qty']}})</span>
                                             </div>
                                             
                                          </div>
                                       </div>
                                    </div>
                                 </td>
                                 <td>
                                    @foreach($val['addons'] as $key =>$value)
                                       {{$value['addon']}} - Rs.{{$value['addon_price']}} 
                                       <br>
                                    @endforeach
                                 </td>
                                 <td>{{ $val['product_price'] * $val['product_qty'] }}</td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-6"></div>
                     <div class="col-6">
                        <div class="table-responsive text-right">
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
            </div>
            <div class="col-md-4">
               <!-- <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                     <div class="invoice-col">
                      <h5 class="text-center mb-3"> Order Setup</h5>
                        <address>
                           <div class="form-group">
                              <label for="exampleInputEmail1">Change Order Status<span class="text-danger">*</span></label>
                              @if ($order->order_status != 'refunded')
                              <div>
                                 <div class="dropdown">
                                    <div class="dropdown-menu text-capitalize" aria-labelledby="dropdownMenuButton">
                                       <h6>
                                          <span>{{ __('messages.status') }} :</span>
                                          @if ($order['order_status'] == 'pending')
                                          <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ __('messages.pending') }}
                                          </span>
                                          @elseif($order['order_status'] == 'confirmed')
                                          <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ __('messages.confirmed') }}
                                          </span>
                                          @elseif($order['order_status'] == 'processing')
                                          <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ __('messages.processing') }}
                                          </span>
                                          @elseif($order['order_status'] == 'picked_up')
                                          <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ __('messages.out_for_delivery') }}
                                          </span>
                                          @elseif($order['order_status'] == 'delivered')
                                          <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ __('messages.delivered') }}
                                          </span>
                                          @elseif($order['order_status'] == 'failed')
                                          <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ __('messages.payment') }}
                                          {{ __('messages.failed') }}
                                          </span>
                                          @else
                                          <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize font-medium">
                                          {{ str_replace('_', ' ', $order['order_status']) }}
                                          </span>
                                          @endif
                                       </h6>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           </div>
                         <select class="form-control" name="status" onchange="change_status(this,{{ $order->id }})">
                            <option value="pending" <?php if($order->payment_status == 'pending'){echo 'selected';}else{echo '';}?>>Pending</option>
                            <option value="preparing" <?php if($order->payment_status == 'preparing'){echo 'selected';}else{echo '';}?>>Preparing</option>
                            <option value="ready_to_dispatch" <?php if($order->payment_status == 'ready_to_dispatch'){echo 'selected';}else{echo '';}?>>Ready to Dispatch</option>

                            <option value="dispatched" <?php if($order->payment_status == 'dispatched'){echo 'selected';}else{echo '';}?>>Dispatch</option>

                            <option value="cancelled_by_customer" <?php if($order->payment_status == 'cancelled_by_customer'){echo 'selected';}else{echo '';}?>>Cancelled by Customer</option>
                            <option value="cancelled_by_vendor" <?php if($order->payment_status == 'cancelled_by_vendor'){echo 'selected';}else{echo '';}?>>Cancelled by Vendor</option>
                            <option value="completed" <?php if($order->payment_status == 'completed'){echo 'selected';}else{echo '';}?>>Completed</option>
                            <option value="accepted" <?php if($order->payment_status == 'accepted'){echo 'selected';}else{echo '';}?>>Accepted</option>
                            <option value="payment_pending" <?php if($order->payment_status == 'payment_pending'){echo 'selected';}else{echo '';}?>>Payment Pending</option>
                         </select>
                        </address>
                     </div>
                  </div>
               </div> -->
               <div class="">
                  <div class="card">
                     <div class="card-body pt-3">
                        <h5 class="mb-3">
                           <span class="card-header-icon">
                           <i class="tio-user"></i>
                           </span>
                           <span><i class="fa fa-user pr-2" aria-hidden="true"></i> Customer Information</span>
                        </h5>
                        <a class="media align-items-center deco-none customer--information-single">
                           <div class="avatar avatar-circle">
                              <img class="avatar-img" src="https://stackfood-admin.6amtech.com/public/assets/admin/img/160x160/img1.png" alt="Image Description" width="80">
                           </div>
                           <div class="media-body px-3">
                              <span class="fz--14px text-title font-semibold text-hover-primary d-block">
                              {{ $users->name }}
                              </span>
                              <span>
                              <strong class="text--title font-semibold">{{ count($product) }}</strong>
                              Products
                              </span>
                              <span class="text--title font-semibold d-block">
                              <i class="tio-call-talking-quiet"></i> {{ $users->mobile_number }}
                              </span>
                              <span class="text--title">
                              <i class="tio-email"></i> {{ $users->email }}
                              </span>
                           </div>
                        </a>
                        <div class="pt-2"></div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                           <h5 class="card-title mb-3">
                              <span class="card-header-icon">
                              <i class="tio-user"></i>
                              </span>
                              <span class=""><i class="fa fa-user pr-2" aria-hidden="true"></i> Delivery Information</span>
                           </h5>
                           <a class="link" data-toggle="modal" data-target="#shipping-address-modal" href="javascript:"><i class="tio-edit"></i></a>
                        </div>
                        <span class="delivery--information-single mt-3">
                        <b class="name pr-2">Name: </b>
                        <span class="info">{{ $users->name }}</span></br>
                       
                        <b class="name pr-2">Contact: </b>
                        <a class="deco-none info" href="tel:{{ $users->mobile_number }}">
                        <i class="tio-call-talking-quiet"></i>
                        {{ $users->mobile_number }}</a><br>
                        <b class="name pr-2">Delivery Address: </b>
                        <span class="info"><a target="_blank" href="http://maps.google.com/maps?z=12&amp;t=m&amp;q=loc:{{$order->lat}}+{{$order->long}}">{{$order->delivery_address}}</a></span></br>
                        
                     </div>
                     </span>
                  </div>
                  <div class="">
                     <div class="card">
                        <div class="card-body">
                           <h5 class="mb-3">
                              <span><i class="fa fa-home pr-2" aria-hidden="true"></i> Restaurant Information</span>
                           </h5>
                           <a class="media align-items-center deco-none resturant--information-single">
                              <div class="avatar avatar-circle">
                                 <img class="avatar-img pr-2 rounded" src="<?php echo asset('vendors/')?>/<?php echo $vendor->image;?>" alt="Image Description" width="80">
                              </div>
                              <div class="media-body">
                                 <span class="text-body text-hover-primary text-break"></span>
                                 <span class="fz--14px text--title font-semibold text-hover-primary d-block">
                                    {{ ucwords($vendor->name) }} &nbsp;
                                 </span>
                                 <span class="text--title">
                                    <i class="tio-call-talking-quiet"></i> ({{ $vendor->mobile }})
                                 </span>
                                 <span class="text--title">
                                 <i class="tio-poi"></i> <a target="_blank" href="http://maps.google.com/maps?z=12&amp;t=m&amp;q=loc:{{$vendor->lat}}+{{$vendor->long}}">{{ $vendor->address }}</a>
                                 </span>
                              </div>
                           </a>
                        </div>
                     </div>
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
   
function change_status(e,id){
  var status = $(e).val();
if(confirm('Are You Ready For status Update ?')){
  $.ajax({
      headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
       method:"POST",
       url:"{{ route('admin.status.update') }}",
       data:{status:status,id:id},
       success:function(){
        location.reload();
       }
     })
    }
}


   function reload_table() {
       table.DataTable().ajax.reload(null, false);
   }
   $('#status').change(function() {
   
   })
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