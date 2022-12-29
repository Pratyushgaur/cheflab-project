 <!-- Modal Header -->
 <div class="modal-header">
          <h4 class="modal-title text-center">Additions</h4>
          <button type="button" class="close text-dark" data-dismiss="modal"><small>&times;</small></button>
        </div>
        
        <!-- Modal body -->
        <form action="javascript:void();" method="post">
        <div class="modal-body">
          <div class="heading"> 
                  <h5>Additions</h5>
                </div>
              <div class="row border px-2 py-3 ml-1 mr-3 my-3">                 
                    <div class="col-5">
                      <div class="cancellation">
                        <p>Cancellation Refund</p>
                      </div>
                    </div>
                    <div class="col-7">
                      <div class="cancellation">
                         <b>₹{{ number_format($additions_count,2) }}</b>
                      </div>
                    </div>
                    </div>
                    <div class="row mt-4">      
                    <div class="col-md-6">
                        <div class="heading"> 
                          <h5>Net Amount</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="heading text-right"> 
                            <b>₹{{ number_format($additions_count,2) }}</b>
                        </div>
                    </div>
              </div>
            
        
        <!-- Modal footer -->
        <div class="modal-footer mt-2 border-0">
          <button type="button" class="btn btn-danger btn-sm py-2" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
