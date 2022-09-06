@extends('vendor.restaurants-layout')
@section('main-content')
<!-- Body Content Wrapper -->
<div class="ms-content-wrapper">
      <div class="row">
        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Globle Setting</a></li>
              <li class="breadcrumb-item"><a href="#">Order Time</a></li>
            </ol>
          </nav>
        </div>
        <div class="col-md-12">
          <div class="ms-panel">
            <div class="ms-panel-header">
              <h6>Order Time Setting</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="menu-form" action="{{route('restaurant.ordertime.store')}}"  method="post">
                    @csrf
                    
                    @if ($errors->any())
                        @foreach  ($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                    @endif  
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <label>Day</label>
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="0" name="day_no1"><i class="ms-checkbox-check"></i>
                        </label> <span> Sun </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <label>Starting Time</label>
                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[]" >
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <label>End Time</label>
                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <label>available</label>
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="1" name="day_no[]"><i class="ms-checkbox-check"></i>
                        </label> <span> Mon </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input  type="time" class="form-control" name="start_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input type="time" class="form-control" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control"  name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="2" name="day_no[]"><i class="ms-checkbox-check"></i>
                        </label> <span> Tus </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input  type="time" class="form-control" placeholder="Last name" name="start_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input type="time" class="form-control" placeholder="Last name" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="3" name="day_no[]"><i class="ms-checkbox-check"></i>
                        </label> <span> Wed </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input  type="time" class="form-control" placeholder="Last name" name="start_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input type="time" class="form-control" placeholder="Last name" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="4" name="day_no[]"><i class="ms-checkbox-check"></i>
                        </label> <span> Thus </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input  type="time" class="form-control" placeholder="Last name" name="start_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input type="time" class="form-control" placeholder="Last name" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="5" name="day_no[]"><i class="ms-checkbox-check"></i>
                        </label> <span> Fri </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input  type="time" class="form-control" placeholder="Last name" name="start_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input type="time" class="form-control" placeholder="Last name" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <label class="ms-checkbox-wrap">
                        <input type="checkbox" value="6" name="day_no[]"><i class="ms-checkbox-check"></i>
                        </label> <span> Sat </span>
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input  type="time" class="form-control" placeholder="Last name" name="start_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                      <div class="input-group">
                        <input type="time" class="form-control" placeholder="Last name" name="end_time[]">
                      </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="input-group">
                            <select class="form-control" id="validationCustom16" name="available[]">
                                <option value="0">Not available</option>
                                <option value="1">available</option>
                            </select>
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