@extends('admin.layouts.layoute')
@section('content')
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
          <div class="modal-header">
          <h4 class="modal-title">Pay</h4>
          
        </div>
        
        <!-- Modal body -->
        <form id="restaurant-form" action="javascript:void();" method="post" onsubmit="payVendor(this);">
       
        <div class="modal-body">
        
          <input type="hidden" value=" {{ csrf_token() }}" name="_token">
          <input type="hidden" value=" {{ $id }}" name="id">
              <div class="row"> 
               
                <div class="col-6"> 
                  <div class="">
                  <div class="form-group">
                      <label for="bankUtr">Bank UTRs</label>
                      <input type="text" class="form-control" id="bankUtr" name="bank_utr">
                    </div> 
                  </div>
                </div>
                <div class="col-6"> 
                  <div class="">
                  <div class="form-group">
                      <label for="bankUtr">Amount</label>
                      <input type="number" class="form-control" id="amounUtr" name="amount">
                    </div> 
                  </div>
                </div>
              </div>
            
        
        <!-- Modal footer -->
        <div class="modal-footer mt-2 border-0">
         
          <button type="submit" class="btn btn-success btn-sm py-2">Submit</button>
        </div>
        </form>
        </div>
          </section>
          <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- /.content-wrapper -->

<!-- /.row -->
@endsection


@section('js_section')


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

<script>
  function payVendor(e){
    
            $.ajax({    
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url :"{{ route('admin.account.vendor.payVendor') }}",  
                method:"POST",  
                dataType:"json",  
                data:$(e).serialize(),
                success: function(data){ 
                  if(data.success==1){
                  toastr.success(data.message,'Success');
                  }
                    var surl = "{{ route('admin.account.vendor.list') }}";
                    $(location).attr('href',surl)
                },
            }); 
        }
        

        $("#restaurant-form").validate({
          rules: {
            bank_utr: {
                  required: true,
              },
              amount: {
                  required: true,
              }
          },
          messages: {
            bank_utr: {
                  required: "Please Enter Bank UTR",
              },
              amount: {
                  required: "Please Enter Amount",
              }
          }
      });
</script>


@endsection
