@extends('admin.layouts.layoute')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .mainpart p{
   font-size: 18px;
   }
   .initial-38-1 {
    max-width: 400px;
    margin: 0 auto;
    padding-right: 4px;
}
.initial-38-1 * {
    font-family: roboto mono,monospace!important;
    font-weight: 500;
    color: #000;
}
.initial-38-4 {
    font-size: 16px;
    font-weight: lighter;
}
.initial-38-1 h5 {
    font-size: 16px;
    font-weight: revert;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Main content -->
   <center class="pt-4">
 <input type="button" class="btn btn-success non-printable" onclick="printDiv('printableArea')" value="Proceed, If thermal printer is ready.">
<a href="{{ route('admin.order.view',Crypt::encryptString($order->order_id)) }}" class="btn btn-danger non-printable">Back</a>
</center>
   <section class="content" >
      <div class="container-fluid">
      <div class="initial-38-1" style="width: 400px;"  id="printableArea">
         <div class="pt-3" style="text-align:center;">
         <img src="https://stackfood-admin.6amtech.com/public/assets/admin/img/restaurant-invoice.png" class="initial-38-2" alt="" width="80px">
         </div>
         <div class="text-center pt-2 mb-3">
         <h2 class="initial-38-3"> {{ ucwords($vendor->name) }}</h2>
         <h5 class="text-break initial-38-4">
         {{ $vendor->address }}
         </h5>
         <h5 class="initial-38-4 initial-38-3">
         Phone : {{ $vendor->mobile }}
         </h5>
         </div>
         <span class="initial-38-5" style="border-bottom: 2px dashed #838383;"></span>
         <div class="row mt-3">
         <div class="col-6">
         <h5>Order ID :
         <span class="font-light"> {{ $order->order_id }} </span>
         </h5>
         </div>
         <div class="col-6">
         <span class="font-light">
         {{ date('d M Y H:s',strtotime($order->created_at)) }}

         </span></div>
         <div class="col-12">
         <h5>
         Customer Name :
         <span class="font-light">
         {{ $users->name }}
         </span>
         </h5>
         <h5>
         Phone :
         <span class="font-light">
         {{ $users->mobile_number }}
         </span>
         </h5>
         
         </div>
         </div>
         <h5 class="text-uppercase"></h5>
         <span class="initial-38-5" style="border-bottom: 2px dashed #838383;"></span>
         <table class="table table-bordered mt-1 mb-1">
         <thead>
         <tr>
         <th class="initial-38-6">QTY</th>
         <th class="initial-38-7">DESC</th>
         <th class="initial-38-7">Price</th>
         </tr>
         </thead>
         <tbody>
            <?php foreach($product as $val){?>
         <tr>
         <td class="">
         1
         </td>
         <td class="">
         {{$val['product_name']}} <br>
         <div class="font-size-sm text-body">
         <span>Price : </span>
         <span class="font-weight-bold">{{ $val['product_price'] }}</span>
         </div>
         </td>
         <td class="w-28p">
         {{ $val['product_price'] }}
         </td>
         </tr>
         <?php } ?>
         </tbody>
         </table>
         <span class="initial-38-5" style="border-bottom: 2px dashed #838383;"></span>
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
         <div class="d-flex flex-row justify-content-between border-top pt-3">
         <span class="text-capitalize">Paid by: cash on delivery</span>
         </div>
         <span class="initial-38-7" style="border-bottom: 2px dashed #838383;"> </span>
         <h4 class="text-center pt-1">
         <span class="d-block">"""THANK YOU"""</span>
         </h4>
         <span class="initial-38-7" style="border-bottom: 2px dashed #838383;"></span>
         <span class="d-block text-center">© 2022 Chelab. All rights reserved.</span>
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
        // location.reload();
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
   
   
   function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    
</script>
@endsection