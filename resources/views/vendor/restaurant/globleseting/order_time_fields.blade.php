
<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <h6>Day</h6>
      <div class="input-group">
         <span> Sun </span>
      </div>
   </div>
   <div class="col-md-10">
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
   
   <?php
      if(isset($VendorOrderTime[0])){
         if(count($VendorOrderTime[0]) < 3){?>
              <div class="col-md-1">
      <div class="input-group mb-0">
         <span> <button type="button" data-item-id='0' data-day="sun" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group mb-0">
         <span> <button type="button" data-item-id='0' data-day="sun" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>


</div>

<?php
   if(isset($VendorOrderTime[0])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_sun ordertime_0 text-center" data-day="sun">
         <tbody>
            <tr>
               <th>Update Opening times</th>
               <th>Update Closing times</th>
               <th>Action</th>
            </tr>
          <?php  foreach($VendorOrderTime[0] as $times){ 
               if($times){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="CloseTime">{{ $times['start_time'] }}</spna>
                        <input type="hidden" class="start_time_0 form-control" name="start_time[0][]" data-item-id id="start_time_0" value="{{ $times['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times['end_time'] }}</spna>
                     <input type="hidden" class="end_time_0 form-control" name="end_time[0][]" data-item-id id="end_time_0" value="{{ $times['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='0' data-day="sun"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove">
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                     
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>
<div class="tr_clone_0">

</div>
<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <div class="input-group">
         <span> Mon </span>
      </div>
   </div>
   <div class="col-md-10">
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
   <?php
      if(isset($VendorOrderTime[1])){
         if(count($VendorOrderTime[1]) < 3){?>
              <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='1' data-day="mon" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='1' data-day="mon" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>
  
</div>

<?php
   if(isset($VendorOrderTime[1])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_mon ordertime_1 text-center" data-day="mon">
         <tbody>
            <tr>
               <th>Update Opening times</th>
               <th>Update Closing times</th>
               <th>Action</th>
            </tr>
          <?php  foreach($VendorOrderTime[1] as $times1){ 
          
               if($times1){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="CloseTime">{{ $times1['start_time'] }}</spna>
                        <input type="hidden" class="start_time_1 form-control" name="start_time[1][]" data-item-id id="start_time_1" value="{{ $times1['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times1['end_time'] }}</spna>
                     <input type="hidden" class="end_time_1 form-control" name="end_time[1][]" data-item-id id="end_time_1" value="{{ $times1['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                  <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times1['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='1' data-day="mon"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times1['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>
<div class="tr_clone_1">

</div>

<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <div class="input-group">
         <span> Tus </span>
      </div>
   </div>
   <div class="col-md-10">
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
   
   <?php
      if(isset($VendorOrderTime[2])){
         if(count($VendorOrderTime[2]) < 3){?>
              <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='2' data-day="tus" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='2' data-day="tus" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>
   
</div>


<?php
   if(isset($VendorOrderTime[2])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_tus ordertime_2 text-center" data-day="tus">
         <tbody>
            <tr>
               <th>Update Opening times</th>
               <th> Update Closing times</th>
               <th>Action</th>
            </tr>
          <?php  foreach($VendorOrderTime[2] as $times2){ 
             
               if($times2){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="CloseTime">{{ $times2['start_time'] }}</span>
                        <input type="hidden" class="start_time_2 form-control" name="start_time[2][]" data-item-id id="start_time_2" value="{{ $times2['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times2['end_time'] }}</span>
                     <input type="hidden" class="end_time_2 form-control" name="end_time[2][]" data-item-id id="end_time_2" value="{{ $times2['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                  <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times2['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='2' data-day="tus"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times2['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>

<div class="tr_clone_2">

</div>


<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <div class="input-group">
         <span> Wed </span>
      </div>
   </div>
   <div class="col-md-10">
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
   

   <?php
      if(isset($VendorOrderTime[3])){
         if(count($VendorOrderTime[3]) < 3){?>
              <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='3' data-day="wed" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='3' data-day="wed" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>

   
</div>

<?php
   if(isset($VendorOrderTime[3])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_wed ordertime_3 text-center" data-day="wed">
         <tbody>
            <tr>
               <th>Update Opening times</th>
               <th>Update Closing times</th>
               <th>Action</th>
            </tr>
          <?php  
         //  echo '<pre>'; print_r($VendorOrderTime[3]);
          foreach($VendorOrderTime[3] as $times3){ 
               if($times3){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="CloseTime">{{ $times3['start_time'] }}</span>
                        <input type="hidden" class="start_time_3 form-control" name="start_time[3][]" data-item-id id="start_time_3" value="{{ $times3['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times3['end_time'] }}</span>
                     <input type="hidden" class="end_time_3 form-control" name="end_time[3][]" data-item-id id="end_time_3" value="{{ $times3['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                  <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times3['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='3' data-day="wed"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times3['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>
<div class="tr_clone_3">

</div>

<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <div class="input-group">
         <span> Thus </span>
      </div>
   </div>
   <div class="col-md-10">
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
  


   <?php
      if(isset($VendorOrderTime[4])){
         if(count($VendorOrderTime[4]) < 3){?>
              <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='4' data-day="thus" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='4' data-day="thus" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>

   
</div>

<?php
   if(isset($VendorOrderTime[4])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_thus ordertime_4 text-center" data-day="thus">
         <tbody>
            <tr>
               <th>Update Opening times</th>
               <th>Update Closing times</th>
               <th>Action</th>
            </tr>
          <?php  foreach($VendorOrderTime[4] as $times4){ 
               if($times4){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="OpenTime">{{ $times4['start_time'] }}</span>
                        <input type="hidden" class="start_time_4 form-control" name="start_time[4][]" data-item-id id="start_time_4" value="{{ $times4['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times4['end_time'] }}</span>
                     <input type="hidden" class="end_time_4 form-control" name="end_time[4][]" data-item-id id="end_time_4" value="{{ $times4['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times4['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='4' data-day="thus"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times4['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>
<div class="tr_clone_4">

</div>
<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <div class="input-group">
         <span> Fri </span>
      </div>
   </div>
   <div class="col-md-10">
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



   <?php
      if(isset($VendorOrderTime[5])){
         if(count($VendorOrderTime[5]) < 3){?>
              <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='5' data-day="fri" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='5' data-day="fri" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>

   
</div>
 
<?php
   if(isset($VendorOrderTime[5])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_fri ordertime_5 text-center">
         <!-- <caption>Update Data</caption> -->
         <tbody>
            <tr>
               <th>Update Opening times</th>
               <th>Update Closing times</th>
               <th>Action</th>
            </tr>
          <?php  foreach($VendorOrderTime[5] as $times5){ 
               if($times5){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="OpenTime">{{ $times5['start_time'] }}</span>
                        <input type="hidden" class="start_time_5 form-control" name="start_time[5][]" data-item-id id="start_time_5" value="{{ $times5['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times5['end_time'] }}</span>
                     <input type="hidden" class="end_time_5 form-control" name="end_time[5][]" data-item-id id="end_time_5" value="{{ $times5['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                  <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times5['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='4' data-day="fri"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times5['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>
<div class="tr_clone_5">

</div>

<div class="form-row tr_clone align-items-center">
   <div class="col-md-1">
      <div class="input-group">
         <span> Sat </span>
      </div>
   </div>
   <div class="col-md-10">
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

   

   <?php
      if(isset($VendorOrderTime[6])){
         if(count($VendorOrderTime[6]) < 3){?>
              <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='6' data-day="sat" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div>
       <?php  }
      }else{?>
         <div class="col-md-1">
      <div class="input-group">
         <span> <button type="button" data-item-id='6' data-day="sat" onclick="addrow(this);return false;" class="tr_clone_add"><i class="fa fa-plus" aria-hidden="true"></i></button> </span>
      </div>
   </div> 
    <?php }?>
  
</div>


    
<?php
   if(isset($VendorOrderTime[6])){ ?>   
       <table class="table table-reponsive table-bordered hidepart_sat ordertime_6 text-center" data-day="sat">
         <tbody>
            <tr>
               <th>Opening times</th>
               <th>Closing times</th>
               <th>Action</th>
            </tr>
          <?php  foreach($VendorOrderTime[6] as $times6){ 
               if($times6){ ?>
            <tr>
               <td>
                  <div class=""> 
                     <span class="OpenTime">{{ $times6['start_time'] }}</span>
                        <input type="hidden" class="start_time_6 form-control" name="start_time[6][]" data-item-id id="start_time_6" value="{{ $times6['start_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                     <span class="CloseTime">{{ $times6['end_time'] }}</span>
                     <input type="hidden" class="end_time_6 form-control" name="end_time[6][]" data-item-id id="end_time_6" value="{{ $times6['end_time'] }}"> 
                  </div>
               </td>
               <td>
                  <div class="">
                  <a href="javascript:void(0);"  onclick="edit_model(this,{{ $times6['id'] }})" class="tr_clone_remove bg-success text-white mx-2" data-item-id='6' data-day="sat"> <small><i class="fa fa-edit m-0" aria-hidden="true"></i></small>
                     </a>
                     <a href="{{route('restaurant.time.delete', ['id' => Crypt::encryptString($times6['id'])])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="tr_clone_remove" >
                     <small><i class="fa fa-trash m-0" aria-hidden="true"></i></small>
                     </a> 
                  </div>
               </td>
            </tr>
            <?php }  else{ ?>
                  <tr>
                     <td colspan="3" class="text-center">
                        No Data Found
                     </td>
                  </tr>
            <?php } }?>
         <tbody>
       </table>
<?php  } ?>
<div class="tr_clone_6">

</div>

<div class="modal" id="Timeing">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

      </div>
    </div>
</div>

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

   function removeRow(e){
    var day = $(e).attr('data-item-id');
   var hidepart = $('.ordertime_'+day).length;
   
   $(e).parent().parent().parent().parent().remove();
   if(hidepart > 2){
   $('.tr_clone_add[data-item-id='+day+']').show();
   }
   }

   
   
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
   
   function edit_model(e,id){

      var day = $(e).attr('data-day');
      var name = $(e).attr('data-item-id');
      $('#Timeing .modal-content').html('');
        $.ajax({  
            headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url :"{{ route('restaurant.time.edit') }}",  
            method:"POST",  
            data:{
                "_token": "{{ csrf_token() }}",
                 "id":id,
                 "day":day,
                 "name":name
            },
            success:function(res){  
               $('#Timeing .modal-content').html(res);
               $('#Timeing').modal('show');                    
            } 
         });
   }
   function addrow(e){
        var day = $(e).attr('data-day');
        var name = $(e).attr('data-item-id');
       
        var end_time = $('.ordertime_'+name+' .end_time_'+name+':last' ).val();
        
        // alert(start_time);
        
        $('#Timeing .modal-content').html('');
        $.ajax({  
            headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url :"{{ route('restaurant.time.model') }}",  
            method:"POST",  
            data:{
                "_token": "{{ csrf_token() }}",
                "day":day,
                "name":name,
                 "end_time":end_time
            },
            success:function(res){  
            $('#Timeing .modal-content').html(res);
            $('#Timeing').modal('show');
           
           
                    
            }  
        });
    
       var day = $(e).attr('data-day');
       var name = $(e).attr('data-item-id');
      
   
       var hidepart = $('.ordertime_'+name).length;
    //    alert(hidepart);
     if(hidepart == 2){
          
           $(e).hide();
     }else{
        $(e).show();
     }
   
   }
   
   function clone_remove(e){
   var day = $(e).attr('data-day');
   var hidepart = $('.ordertime_'+day).length;
   
   $(e).parent().parent().parent().remove();
   if(hidepart > 2){
   $('.tr_clone_add[data-day='+day+']').show();
   }
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
   .tr_clone_remove i {
    font-size: 11px;
}
</style>