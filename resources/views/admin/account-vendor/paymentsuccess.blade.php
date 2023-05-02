@extends('admin.layouts.layoute')
@section('content')
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
          <div class="modal-header">
          <h4 class="modal-title">Pay</h4>
          
        </div>
        
        
        <form id="restaurant-form" action="{{route('admin.account.vendor.payVendor')}}" method="post" >
       
        <div class="modal-body">
        
          <input type="hidden" value=" {{ csrf_token() }}" name="_token">
          <input type="hidden" value=" {{ $id }}" name="id">
          <input type="hidden" value=" {{ $data->vendor_id }}" name="vendor_id">
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
                      <input type="number" class="form-control" value = "{{ $data->paid_amount - $data->vendor_cancel_deduction }}" id="amounUtr" name="amount" readonly>
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
