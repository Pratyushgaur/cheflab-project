<?php
// echo '<pre>'; print_r($VendorOrderTime);die;
?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <h6>Day</h6>
        <div class="input-group">
            <span> Sun </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <h6>Available</h6>
        <div class="input-group">
            <select class="form-control" id="available_0" name="available[0]" data-item-id="0" data-day="sun" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[0][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[0][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>
            @if ($errors->has('available.0'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.0') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <h6>Opening times</h6>
        <div class="input-group hidepart_sun">
            <input type="time" class="start_time form-control" name="start_time[0][]" id='start_time_0' data-item-id="0"
                <?= isset($VendorOrderTime[0][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[0][0]['start_time'])) . '"' : '' ?>>
            <span class="start_time_0_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <h6>Closing times</h6>
        <div class="input-group hidepart_sun">
            <input type="time" class="end_time form-control" name="end_time[0][]" id="end_time_0" data-item-id="0"
                <?= isset($VendorOrderTime[0][0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[0][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>
   
    <div class="col-md-2 mb-4">
        <div class="input-group pt-4">
            <span> <button type="button" data-item-id='0' data-day="sun" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
        </div>
    </div>
</div>
<?php
if(isset($VendorOrderTime[0])){ 
foreach($VendorOrderTime[0] as $times){ 
    if($times['row_keys'] != 0){ ?>
    <div class="form-row hidepart_sun">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[0][]" data-item-id id="start_time_1" value="{{ $times['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[0][]" data-item-id id="end_time_1" value="{{ $times['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <div class="input-group">
            <span> Mon </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_1" name="available[1]" data-item-id="1" data-day="mon" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[1][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[1][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.1'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.1') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4 ">

        <div class="input-group hidepart_mon">
            <input type="time" class="start_time form-control" name="start_time[1][]" data-item-id='1'
                id="start_time_1"
                <?= isset($VendorOrderTime[1][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[1][0]['start_time'] )). '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_mon">
            <input type="time" class="end_time form-control" name="end_time[1][]" data-item-id='1' id="end_time_1"
                <?= isset($VendorOrderTime[1][0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[1][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

    
    <div class="col-md-2 mb-4">
        <div class="input-group">
            <span> <button type="button" data-item-id='1' data-day="mon" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
        </div>
    </div>
</div>

<?php
if(isset($VendorOrderTime[1])){ 
foreach($VendorOrderTime[1] as $times1){ 
    if($times1['row_keys'] != 0){ ?>
    <div class="form-row hidepart_mon">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[1][]" data-item-id id="start_time_1" value="{{ $times1['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[1][]" data-item-id id="end_time_1" value="{{ $times1['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times1['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <div class="input-group">
            <span> Tus </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_2" name="available[2]" data-item-id="2" data-day="tus" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[2][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[2][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.2'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.2') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_tus">
            <input type="time" class="start_time form-control" name="start_time[2][]" data-item-id='2'
                id="start_time_2"
                <?= isset($VendorOrderTime[2][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[2][0]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_tus">
            <input type="time" class="end_time form-control" name="end_time[2][]" data-item-id='2' id="end_time_2"
                <?= isset($VendorOrderTime[2][0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[2][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

   
    <div class="col-md-2 mb-4">
        <div class="input-group">
            <span> <button type="button" data-item-id='2' data-day="tus" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
        </div>
    </div>
</div>

<?php
if(isset($VendorOrderTime[2])){ 
foreach($VendorOrderTime[2] as $times2){ 
    if($times2['row_keys'] != 0){ ?>
    <div class="form-row hidepart_tus">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[2][]" data-item-id id="start_time_1" value="{{ $times2['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[2][]" data-item-id id="end_time_1" value="{{ $times2['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times2['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <div class="input-group">
            <span> Wed </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_3" name="available[3]" data-item-id="3" data-day="wed" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[3][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[3][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.3'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.3') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_wed">
            <input type="time" class="start_time form-control" name="start_time[3][]" data-item-id='3'
                id="start_time_3"
                <?= isset($VendorOrderTime[3][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[3][0]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_wed">
            <input type="time" class="end_time form-control" name="end_time[3][]" data-item-id='3' id="end_time_3"
                <?= isset($VendorOrderTime[3][0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[3][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

   
    <div class="col-md-2 mb-4">
        <div class="input-group">
            <span> <button type="button" data-item-id='3' data-day="wed" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
        </div>
    </div>
</div>

<?php
if(isset($VendorOrderTime[3])){ 
foreach($VendorOrderTime[3] as $times3){ 
    if($times3['row_keys'] != 0){ ?>
    <div class="form-row hidepart_wed">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[3][]" data-item-id id="start_time_1" value="{{ $times3['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[3][]" data-item-id id="end_time_1" value="{{ $times3['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times3['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <div class="input-group">
            <span> Thus </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_4" name="available[4]" data-item-id="4" data-day="thus" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[4][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available
                </option>
                <option value="0" @if (@$VendorOrderTime[4][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.4'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.4') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_thus">
            <input type="time" class="start_time form-control" name="start_time[4][]" data-item-id='4'
                id="start_time_4"
                <?= isset($VendorOrderTime[4][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[4][0]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_thus">
            <input type="time" class="end_time form-control" name="end_time[4][]" data-item-id='4' id="end_time_4"
                <?= isset($VendorOrderTime[4][0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[4][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

   
    <div class="col-md-2 mb-4">
        <div class="input-group">
            <span> <button type="button" data-item-id='4' data-day="thus" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
        </div>
    </div>
</div>

<?php
if(isset($VendorOrderTime[4])){ 
foreach($VendorOrderTime[4] as $times4){ 
    if($times4['row_keys'] != 0){ ?>
    <div class="form-row hidepart_thus">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[4][]" data-item-id id="start_time_1" value="{{ $times4['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[4][]" data-item-id id="end_time_1" value="{{ $times4['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times4['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <div class="input-group">
            <span> Fri </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_5" name="available[5]" data-item-id="5" data-day="fri" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[5][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available</option>
                <option value="0" @if (@$VendorOrderTime[5][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.5'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.5') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_fri">
            <input type="time" class="start_time form-control" name="start_time[5][]" data-item-id='5'
                id="start_time_5"
                <?= isset($VendorOrderTime[5][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[5][0]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_fri">
            <input type="time" class="end_time form-control" name="end_time[5][]" data-item-id='5' id="end_time_5"
                <?= isset($VendorOrderTime[5][0]['end_time']) ? 'value="' .date('H:i', strtotime($VendorOrderTime[5][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

 
    <div class="col-md-2 mb-4">
        <div class="input-group">
            <span> <button type="button" data-item-id='5' data-day="fri" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
        </div>
    </div>
</div>

<?php
if(isset($VendorOrderTime[5])){ 
foreach($VendorOrderTime[5] as $times5){ 
    if($times5['row_keys'] != 0){ ?>
    <div class="form-row hidepart_fri">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[5][]" data-item-id id="start_time_1" value="{{ $times5['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[5][]" data-item-id id="end_time_1" value="{{ $times5['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times5['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>
<div class="form-row tr_clone">
    <div class="col-md-1 mb-4">
        <div class="input-group">
            <span> Sat </span>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="input-group">
            <select class="form-control" id="available_6" name="available[6]" data-item-id="6" data-day="sat" onchange="get_available(this)">
                <option value="1" @if (@$VendorOrderTime[6][0]['available'] == '1') {{ 'selected' }} @endif>
                    Available</option>
                <option value="0" @if (@$VendorOrderTime[6][0]['available'] == '0') {{ 'selected' }} @endif>Not
                    available</option>
            </select>

            @if ($errors->has('available.6'))
                <span class="ms-text-danger">
                    <strong>{{ $errors->first('available.6') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_sat">
            <input type="time" class="start_time form-control" name="start_time[6][]" data-item-id='6'
                id="start_time_6"
                <?= isset($VendorOrderTime[6][0]['start_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[6][0]['start_time'])) . '"' : '' ?>>
        </div>
    </div>
    <div class="col-md-3 mb-4">

        <div class="input-group hidepart_sat">
            <input type="time" class="end_time form-control" name="end_time[6][]" data-item-id='6' id="end_time_6"
                <?= isset($VendorOrderTime[6][0]['end_time']) ? 'value="' . date('H:i', strtotime($VendorOrderTime[6][0]['end_time'])) . '"' : '' ?>>
        </div>
    </div>

   
    <div class="col-md-2 mb-4">
        <div class="input-group">
            <span> <button type="button"  data-item-id='6'  data-day="sat" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button></span>
        </div>
    </div>
</div>

<?php
if(isset($VendorOrderTime[6])){ 
foreach($VendorOrderTime[6] as $times6){ 
    if($times6['row_keys'] != 0){ ?>
    <div class="form-row hidepart_sat">
        <div class="col-md-5 mb-4">
            <div class="input-group"> 
                <input type="time" class="start_time form-control" name="start_time[6][]" data-item-id id="start_time_1" value="{{ $times6['start_time'] }}"> 
            </div>
        </div>
        <div class="col-md-5 mb-4">
             <div class="input-group">
                <input type="time" class="end_time form-control" name="end_time[6][]" data-item-id id="end_time_1" value="{{ $times6['end_time'] }}"> 
            </div> 
            </div>
            <div class="col-md-1 mb-4">
                <div class="input-group " >
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times6['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <i class="fa fa-trash" aria-hidden="true"></i>
                    </a> 
                </div>
            </div>
        </div>
   <?php } } } ?>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

    <script>

        // $("input.tr_clone_add").on('click', function() {
        // var $tr = $(this).closest('.tr_clone');
        // var $clone = $tr.clone();
        // $clone.find(':text').val('');
        // $tr.after($clone);
        // });


        function get_available(e){
            var available =  $(e).val();
            var day =  $(e).attr('data-day');
          
            if(available == 1){
                $('.hidepart_'+day).show();
                $('.tr_clone_add[data-day='+day+']').show();
            }else{
                $('.hidepart_'+day).hide();
                $('.tr_clone_add[data-day='+day+']').hide();
            }
        }

        function addrow(e){
            var day = $(e).attr('data-day');
            var name = $(e).attr('data-item-id');
            
           $(e).closest('.tr_clone').after('<div class="form-row hidepart_'+day+'"><div class="col-md-5 mb-4"><div class="input-group"> <input type="time" class="start_time form-control" name="start_time['+name+'][]" data-item-id id="start_time_1"> </div></div><div class="col-md-5 mb-4"> <div class="input-group"><input type="time" class="end_time form-control" name="end_time['+name+'][]" data-item-id id="end_time_1"> </div> </div><div class="col-md-1 mb-4"><div class="input-group " > <button type="button"  onclick="clone_remove(this)" class="tr_clone_remove"><i class="fa fa-minus" aria-hidden="true"></i></button> </div></div></div>')

        }

function clone_remove(e){
    $(e).parent().parent().parent().remove();
}


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

        function delete_remove(id){
            alert(id);
        }
    </script>
@endpush
<style>
    .tr_clone_add {
    background: #00c4ff;
    border: none;
    color: #fff;
    padding: 6px 10px;
}
.tr_clone_remove {
    background: #F44336;
    border: none;
    color: #fff;
    padding: 6px 10px;
}
</style>