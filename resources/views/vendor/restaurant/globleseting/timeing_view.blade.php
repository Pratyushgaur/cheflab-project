 <!-- Modal Header -->
 <div class="modal-header">
          <h4 class="modal-title">{{ ucwords($request->day) }}day Timeing</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form action="javascript:void();" method="post" onsubmit="submit_times(this);">
        <div class="modal-body">
          <input type="hidden" id="end_time_old" value="{{ $request->end_time }}" name="end_time_old">
          <input type="hidden" id="no_day" value="{{ $request->name }}" name="no_day">
          <input type="hidden" value=" {{ csrf_token() }}" name="_token">
              <div class="row"> 
                <div class="col-6"> 
                  <div class="">
                  <div class="form-group">
                      <label for="usr">Open Time:</label>
                      <input type="time" class="form-control" id="usr" name="start_time" onchange="cheaktime(this);return false;">
                    </div> 
                    
                     
                      <!-- <select class="form-control" name="start_time" onchange="cheaktime(this);return false;">
                          <//?php
                            $hour = 0;
                            
                            while($hour++ < 24)
                            {
                              $timetoprint = date('H:i',mktime($hour,0,0,1,1,2011));
                             
                                if($request->end_time > $timetoprint){
                                  echo "";  
                                }else{
                                  echo "<option value=".$timetoprint.">".$timetoprint."</option>";                              

                                }
                               
                            }

                        ?>
                          <option value=""></option>
                      </select> -->
                  </div>
                </div>
                <div class="col-6"> 
                  <div class="">
                  <div class="form-group">
                      <label for="usr">Close Time:</label>
                      <input type="time" class="form-control" id="usr" name="end_time" onchange="cheaktime(this);return false;">
                    </div> 
                  <!-- <label class="d-block pr-2">Close Time</label> -->
                      <!-- <select class="form-control "  onchange="cheaktime(this);return false;" name="end_time">
                           <//?php
                            $hour = 0;
                            while($hour++ < 24)
                            {
                                $timetoprint = date('H:i',mktime($hour,0,0,1,1,2011));
                                echo "<option>".$timetoprint."</option>";                              
                            } 

                        ?> 
                          <option value=""></option>
                      </select> -->
                  </div>
                </div>
              </div>
            
        
        <!-- Modal footer -->
        <div class="modal-footer mt-2 border-0">
          <button type="button" class="btn btn-danger btn-sm py-2" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm py-2">Submit</button>
        </div>
        </form>
        </div>

        <script>
$(document).ready(function(){
  cheaktime();
});
          function cheaktime(e){
            var time = $(e).val();
           var  end_time_old = $('#end_time_old').val();
            if(end_time_old){
              if(time <= end_time_old){ //alert('a')
                $('button[type="submit"]').hide()
                setInterval( toastr.error('Add time beyond the time you added last time','Error'),1000);
                toastr.hide();
              }else if(end_time_old >= time){ 
               
                $('button[type="submit"]').hide()
                setInterval( toastr.error('Add time beyond the time you added last time','Error'),1000);
                toastr.hide();
              }else{
                $('button[type="submit"]').show()
              }
            }

          }




          function submit_times(e){

            var day = $('#no_day').val();
            $(e).find('.st_loader').show();
            $.ajax({ 
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }, 
              url :"{{ route('restaurant.time.save') }}",  
              method:"POST",  
              dataType:"json",  
              data:$(e).serialize(),
                success: function(data){ 
                        // alert(data.str);return false;
                        if(data.success==1){
                          toastr.success(data.message,'Success');
                          $(e).find('.st_loader').hide();
                          $(e)[0].reset();
                        $('#Timeing').modal('hide');
                        $('#Timeing .modal-content').html('');
                          
                        $('.tr_clone_'+day).append(data.str)
                      
                        }else if(data.success==0){
                          toastr.error(data.message,'Error');
                          $(e).find('.st_loader').hide();
                        }
                      },
                      error: function(data){ 
                        if(typeof data.responseJSON.status !== 'undefined'){
                          toastr.error(data.responseJSON.error,'Error');
                        }else{
                          $.each(data.responseJSON.errors, function( key, value ) {
                              toastr.error(value,'Error');
                          });
                        }
                        $(e).find('.st_loader').hide();
                      } 
            }); 
            }
          
        </script>