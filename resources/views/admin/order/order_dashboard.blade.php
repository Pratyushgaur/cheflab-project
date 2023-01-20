@extends('admin.layouts.layoute')
@section('content')

        <style>
            .active{
                background:#3865cb;
                color:#fff !important;
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

  
@endif

<script type="text/javascript">
 var url = "{{$url}}";
 $(document).ready(function(){
  
  reloadTable();
    setInterval(function() {
      reloadTable();
    }, 7000);
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