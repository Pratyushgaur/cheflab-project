<div class="form-row">
    <div class="col-md-3 mb-4">
        <h6>Day</h6>
        <div class="input-group">
            <span> Sun </span>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <h6>Opening times</h6>
        <div class="input-group">
            <input type="time" class=" start_time form-control" name="start_time[0]" id='start_time_0' data-item-id="0"
                <?= isset($VendorOrderTime[0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[0]['start_time'])) . '"' : '' ?>>
            <span class="start_time_0_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <h6>Closing times</h6>
        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[0]" id="end_time_0" data-item-id="0"
                <?= isset($VendorOrderTime[0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <h6>available</h6>
        <div class="input-group">
            <select class="form-control" id="available_0" name="available[0]" data-item-id="0">
                <option value="1" @if (@$VendorOrderTime[0]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
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
            <input type="time" class="start_time form-control" name="start_time[1]" data-item-id='1'
                id="start_time_1"
                <?= isset($VendorOrderTime[1]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[1]['start_time'] )). '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[1]" data-item-id='1' id="end_time_1"
                <?= isset($VendorOrderTime[1]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[1]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_1" name="available[1]" data-item-id="1">
                <option value="1" @if (@$VendorOrderTime[1]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[1]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
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
            <input type="time" class="start_time form-control" name="start_time[2]" data-item-id='2'
                id="start_time_2"
                <?= isset($VendorOrderTime[2]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[2]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[2]" data-item-id='2' id="end_time_2"
                <?= isset($VendorOrderTime[2]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[2]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_2" name="available[2]" data-item-id="2">
                <option value="1" @if (@$VendorOrderTime[2]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[2]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
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
            <input type="time" class="start_time form-control" name="start_time[3]" data-item-id='3'
                id="start_time_3"
                <?= isset($VendorOrderTime[3]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[3]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[3]" data-item-id='3' id="end_time_3"
                <?= isset($VendorOrderTime[3]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[3]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_3" name="available[3]" data-item-id="3">
                <option value="1" @if (@$VendorOrderTime[3]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[3]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
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
            <input type="time" class="start_time form-control" name="start_time[4]" data-item-id='4'
                id="start_time_4"
                <?= isset($VendorOrderTime[4]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[4]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[4]" data-item-id='4' id="end_time_4"
                <?= isset($VendorOrderTime[4]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[4]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_4" name="available[4]" data-item-id="4">
                <option value="1" @if (@$VendorOrderTime[4]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[4]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
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
            <input type="time" class="start_time form-control" name="start_time[5]" data-item-id='5'
                id="start_time_5"
                <?= isset($VendorOrderTime[5]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[5]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[5]" data-item-id='5' id="end_time_5"
                <?= isset($VendorOrderTime[5]['end_time']) ? 'value="' .date('H:i', strtotime($VendorOrderTime[5]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_5" name="available[5]" data-item-id="5">
                <option value="1" @if (@$VendorOrderTime[5]['available'] == '1') {{ 'selected' }} @endif>
                    Available</option>
                <option value="0" @if (@$VendorOrderTime[5]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
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
            <input type="time" class="start_time form-control" name="start_time[6]" data-item-id='6'
                id="start_time_6"
                <?= isset($VendorOrderTime[6]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[6]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group">
            <input type="time" class="end_time form-control" name="end_time[6]" data-item-id='6' id="end_time_6"
                <?= isset($VendorOrderTime[6]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[6]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_6" name="available[6]" data-item-id="6">
                <option value="1" @if (@$VendorOrderTime[6]['available'] == '1') {{ 'selected' }} @endif>
                    Available</option>
                <option value="0" @if (@$VendorOrderTime[6]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.6'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.6') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

    <script>
        (function($) {
            $("select").change(function() {

                if ($(this).val() == 0) {

                    $("#start_time_" + $(this).attr('data-item-id')).val(null);
                    $("#end_time_" + $(this).attr('data-item-id')).val(null);
                    $('#start_time_'+ $(this).attr('data-item-id')).prop('required', false);
                    $('#end_time_'+ $(this).attr('data-item-id')).prop('required', false);
                }else
                {
                    $('#start_time_'+ $(this).attr('data-item-id')).prop('required', true);
                    $('#end_time_'+ $(this).attr('data-item-id')).prop('required', true);
                }
            });

            $(".start_time").focusout(function() {
                var v = $(this).val();

                $(".start_time").each(function() {
                    if ($(this).val() == '' && $("#available_" + $(this).attr('data-item-id')).val() ==
                        1) {
                        $(this).val(v);
                    }

                });
            });
            $(".end_time").focusout(function() {
                var v = $(this).val();
                $(".end_time").each(function() {
                    if ($(this).val() == '' && $("#available_" + $(this).attr('data-item-id')).val() ==
                        1) {
                        $(this).val(v);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
