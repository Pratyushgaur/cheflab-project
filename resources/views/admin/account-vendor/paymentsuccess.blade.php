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
                        <h3 class="card-title">Pay Out</h3>
                    </div>
                    <div class="card-body pad table-responsive">
                      <form id="restaurant-form" action="{{route('admin.account.vendor.payVendor')}}" method="post">
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
                          <div class="col-6"> 
                            <div class="form-group">
                              <input type="submit" value="save" class="btn btn-success btn-sm">
                            </div> 
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                      <h3 class="card-title">Bank Details</h3>
                  </div>
                  <div class="card-body pad table-responsive">
                    <table id="example1" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%">
                      <thead>
                        <tr role="row">
                            
                            <th>Bank Name</th>
                            <th>A/c</th>
                            <th>IFSC</th>
                            
                            <th>Holder Name</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($bank as $key =>$value)
                          <tr>
                            <td>{{$value->bank_name}}</td>
                            <td>{{$value->account_no}}</td>
                            <td>{{$value->ifsc}}</td>
                            <td>{{$value->holder_name}}</td>
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
