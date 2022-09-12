@extends('vendor.restaurants-layout')
@section('main-content')
<!-- Body Content Wrapper -->
<div class="ms-content-wrapper">
      <div class="row">
        

        <div class="col-md-1"></div>

        <div class="col-md-9">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Order Time Setting</h6>
            </div>
            <div class="ms-panel-body">
              <form class="validation-fill clearfix " id="menu-form" action="{{route('restaurant.ordertime.store')}}"  method="post">
                    @csrf

                    @include('vendor.restaurant.alertMsg')
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <h6>Day</h6>
                      <div class="input-group">
                         <span> Sun </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                      <h6>Starting Time</h6>
                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[0]" <?=(isset($VendorOrderTime[0]['start_time'])) ?  'value="'.$VendorOrderTime[0]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <h6>End Time</h6>
                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[0]" <?=(isset($VendorOrderTime[0]['end_time'])) ?  'value="'.$VendorOrderTime[0]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <h6>available</h6>
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[0]">
                              <option value="1" @if (@$VendorOrderTime[0]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[0]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>
                            @if ($errors->has('available.0'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.0') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <span> Mon </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[1]" <?=(isset($VendorOrderTime[1]['start_time'])) ?  'value="'.$VendorOrderTime[1]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[1]" <?=(isset($VendorOrderTime[1]['end_time'])) ?  'value="'.$VendorOrderTime[1]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[1]">
                              <option value="1" @if (@$VendorOrderTime[1]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[1]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>

                            @if ($errors->has('available.1'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.1') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <span> Tus </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[2]" <?=(isset($VendorOrderTime[2]['start_time'])) ?  'value="'.$VendorOrderTime[2]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[2]" <?=(isset($VendorOrderTime[2]['end_time'])) ?  'value="'.$VendorOrderTime[2]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[2]">
                              <option value="1" @if (@$VendorOrderTime[2]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[2]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>

                            @if ($errors->has('available.2'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.2') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <span> Wed </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[3]" <?=(isset($VendorOrderTime[3]['start_time'])) ?  'value="'.$VendorOrderTime[3]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[3]" <?=(isset($VendorOrderTime[3]['end_time'])) ?  'value="'.$VendorOrderTime[3]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[3]">
                              <option value="1" @if (@$VendorOrderTime[3]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[3]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>

                            @if ($errors->has('available.3'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.3') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                         <span> Thus </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[4]" <?=(isset($VendorOrderTime[4]['start_time'])) ?  'value="'.$VendorOrderTime[4]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[4]" <?=(isset($VendorOrderTime[4]['end_time'])) ?  'value="'.$VendorOrderTime[4]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[4]">
                              <option value="1" @if (@$VendorOrderTime[4]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[4]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>

                            @if ($errors->has('available.4'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.4') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                         <span> Fri </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[5]" <?=(isset($VendorOrderTime[5]['start_time'])) ?  'value="'.$VendorOrderTime[5]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[5]" <?=(isset($VendorOrderTime[5]['end_time'])) ?  'value="'.$VendorOrderTime[5]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[5]">
                              <option value="1" @if (@$VendorOrderTime[5]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[5]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>

                            @if ($errors->has('available.5'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.5') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                         <span> Sat </span>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[6]" <?=(isset($VendorOrderTime[6]['start_time'])) ?  'value="'.$VendorOrderTime[6]['start_time'].'"' : ''?>>
                     </div>
                    </div>
                    <div class="col-md-3 mb-4">

                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[6]" <?=(isset($VendorOrderTime[6]['end_time'])) ?  'value="'.$VendorOrderTime[6]['end_time'].'"' : ''?>>
                      </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[6]">
                              <option value="1" @if (@$VendorOrderTime[6]['available'] == "1") {{ 'selected' }} @endif>Available</option>
                              <option value="0" @if (@$VendorOrderTime[6]['available'] == "0") {{ 'selected' }} @endif>Not available</option>
                            </select>

                            @if ($errors->has('available.6'))
                            <span class="ms-text-danger">
                                <strong>{{ $errors->first('available.6') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                  <button class="btn btn-primary" type="submit">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>




      </div>
    </div>



@endsection

@section('page-js')
<script>
  (function($) {
    let table = $('#order').dataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('order.datatable') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'order_status', name: 'order_status'},
            {data: 'order_total_price', name: 'order_total_price'},
            {data: 'pyment_type', name: 'pyment_type'},
            {data: 'order_time', name: 'order_time'},
            {data: 'created_at', name: 'created_at'},
           {data: 'action-js', name: 'action-js', orderable: false, searchable: false},
        ]
    });
  })(jQuery);
</script>
@endsection
