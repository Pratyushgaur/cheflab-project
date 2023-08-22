@extends('admin.layouts.layoute')
@section('content')

        <style>
            .active{
                background:#3865cb;
                color:#fff !important;
            }
            .loader {
              border: 16px solid #f3f3f3; /* Light grey */
              border-top: 16px solid #3498db; /* Blue */
              border-radius: 50%;
              width: 120px;
              height: 120px;
              animation: spin 2s linear infinite;
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
        </style>
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
                          <div class="row">
                            <div class="col-md-12">
                                @include('admin.order.order_dash_menu')
                            </div>
                            
                          </div>
                          
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header">
                      <h3 class="card-title">Orders  </h3>
                      
                      
                    </div>
                    @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                    @endif
                    <div class="card-body pad table-responsive">
                    

                                
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
<div id="myModal" class="modal fade model-lg" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12 md-container" >
            
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection


@section('js_section')
<script>
  
</script>
@if($active=='pending')
  <?php $url = route("admin.order.dashboard.pending"); ?>
@elseif($active=='delay_restaurant')
  <?php $url = route("admin.order.dashboard.delay_restaurant"); ?>
@elseif($active=='delay_rider')
  <?php $url = route("admin.order.dashboard.delay_rider"); ?>
@elseif($active=='preparing')
<?php $url = route("admin.order.dashboard.prepairing"); ?>
@elseif($active=='not_pickup_rider')
<?php $url = route("admin.order.dashboard.PickedUpRider"); ?>
@elseif($active=='out_of_dellivery')
<?php $url = route("admin.order.dashboard.out_of_delivery"); ?>
@elseif($active=='no_rider_assign')
<?php $url = route("admin.order.dashboard.no_rider_assign"); ?>
@elseif($active=='fail_order_generate')
<?php $url = route("admin.order.dashboard.fail_order_generate"); ?>

  
@endif

<script type="text/javascript">
 var url = "{{$url}}";
 $(document).ready(function(){
  
  reloadTable();
    setInterval(function() {
      reloadTable();
    }, 7000);

    $(document).on('click','.find-rider',function(){
      $('.md-container').html('<div class="loader" style="margin:auto !important"></div>');
      var lat = $(this).attr('data-vendorlat');
      var lng = $(this).attr('data-vendorlong');
      var orderid = $(this).attr('data-order_id');
      var url = "{{route('admin.order.dashboard.nearbyRiderData')}}";
      $('#myModal').modal('show');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "POST",
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { "_token": "{{ csrf_token() }}","lat":lat,"lng":lng,"orderid":orderid },
        success: function(response){
          if(response.length > 0){
            var html = '<table id="users" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">';
            html += '<thead><tr><th>Name</th><th>Distance</th><th>Mobile</th><th>Assign</th></tr></thead>';
            html += '<tbody>';
            for(i=0;i<response.length;i++){
              html+= '<tr><td>'+response[i].name+'</td><td>'+response[i].distance+' KM</td><td>'+response[i].mobile+'</td><td><a href="{{route("admin.order.dashboard.assignOrder")}}?id='+response[i].id+'&order_id='+orderid+'&distance='+response[i].distance+'" class="btn btn-xs btn-success ">Assign Order</a></td></tr>';
            }
            html += '</tbody>';
            html += '</table>';
            $('.md-container').html(html);
          }else{
            $('.md-container').html('<h3>No Rider Found</h3>');
          }
        }
      }); 
    });
    $(document).on('click','.find-rider-2',function(){
      $('.md-container').html('<div class="loader" style="margin:auto !important"></div>');
      var lat = $(this).attr('data-vendorlat');
      var lng = $(this).attr('data-vendorlong');
      var orderid = $(this).attr('data-order_id');
      var url = "{{route('admin.order.dashboard.nearbyMultiRiderData')}}";
      $('#myModal').modal('show');
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "POST",
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { "_token": "{{ csrf_token() }}","lat":lat,"lng":lng,"orderid":orderid },
        success: function(response){
          console.log(response);
          if(response.length > 0){
            var html = '<table id="users" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">';
            html += '<thead><tr><th>Name</th><th>Distance</th><th>Mobile</th><th>Running</th><th>Assign</th></tr></thead>';
            html += '<tbody>';
            for(i=0;i<response.length;i++){
              html+= '<tr><td>'+response[i].name+'</td><td>'+response[i].distance+' KM</td><td>'+response[i].mobile+'</td><td>'+response[i].running_order+'</td><td><a href="{{route("admin.order.dashboard.assignOrder.multiple")}}?id='+response[i].id+'&order_id='+orderid+'&distance='+response[i].distance+'" class="btn btn-xs btn-success ">Assign Order</a></td></tr>';
            }
            html += '</tbody>';
            html += '</table>';
            $('.md-container').html(html);
          }else{
            $('.md-container').html('<h3>No Rider Found</h3>');
          }
        }
      }); 
    });

    $(document).on('click','.generateOrder',function(){
      var id  =$(this).attr('data-id');
      var url = "{{route('admin.order.dashboard.generateSuccessPaymentOrder')}}";
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "POST",
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { "_token": "{{ csrf_token() }}","id":id},
        success: function(response){
          console.log(response.status);
          if(response.status == false ){
            $(document).Toasts('create', {
              class: 'bg-danger',
              title: response.error,
              subtitle: '',
              //body: response.error
            })
          }else if(response.status == true){
            $(document).Toasts('create', {
              class: 'bg-success',
              title: 'Order Created Successfully',
              subtitle: '',
              //body: 'Order Created Successfully'
            });
          }else{
            $(document).Toasts('create', {
              class: 'bg-danger',
              title: 'Something went wrong',
              subtitle: '',
              //body: ''
            });
          }
        }
      });
    })
 })

 function reloadTable(){
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        type: "POST",
        url: url, // This is what I have updated
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: { "_token": "{{ csrf_token() }}" },
        success: function(response){
          $('.table-responsive').html(response);
        }
      }); 
 }
        
 </script>
@endsection