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
                                            <td>Commission</td>
                                            <td class="text-right"><b>₹{{ $admin_amount }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Tax On Commission</td>
                                            <td class="text-right"><b>₹{{ $tax_amount }}</b></td>
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
                                            <td>Convenience fee</td>
                                            <td class="text-right"><b>₹{{ $convenience_amount }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        
                            <td>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Order canceled Deduction</td>
                                            <td class="text-right"><b>₹{{ $calceled_order }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                             <td>Net Amount</td>                                           
                             <td class="text-right"><b>₹{{ $net_amount }}</b></td>                                       
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
