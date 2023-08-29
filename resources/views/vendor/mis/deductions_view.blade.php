 <!-- Modal Header -->
 <div class="modal-header">
          <h4 class="modal-title text-center">Deductions </h4>
          <button type="button" class="close text-dark" data-dismiss="modal"><small>&times;</small></button>
        </div>
        
        <!-- Modal body -->
        <form action="javascript:void();" method="post">
        <div class="modal-body">
          <div class="heading"> 
                  <h5>Deductions</h5>
                </div>
                <div class="deductions_box my-3">
                  <table class="table  table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <table class="table  table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Admin Commission</td>
                                            <td class="text-right"><b>₹{{ number_format($admin_commision,2) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Convenience fee</td>
                                            <td class="text-right"><b>₹{{ number_format($total_convenience_fee,2) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            
                        </tr> 
                        <tr>
                            <td>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Tax </td>
                                            <td class="text-right"><b>₹{{ number_format($tax_on_commission,2) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        
                            <td>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Order Cancellation Charges</td>
                                            <td class="text-right"><b>₹{{ number_format($cancel_by_vendor, 2) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                             <td>Net Amount</td>                                           
                             <td class="text-right"><b>₹{{ number_format($total, 2)}}</b></td>                                       
                        </tr>
                    </tbody>
                  </table>
                </div>
        <!-- Modal footer -->
        <div class="modal-footer mt-2 border-0">
          <button type="button" class="btn btn-danger btn-sm py-2" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
