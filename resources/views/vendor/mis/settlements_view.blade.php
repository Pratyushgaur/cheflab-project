 <!-- Modal Header -->
 <div class="modal-header">
          <h4 class="modal-title text-center">Your Settlements</h4>
          <button type="button" class="close text-dark" data-dismiss="modal"><small>&times;</small></button>
        </div>
        
        <!-- Modal body -->
        

<link href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">

      <!-- Content Wrapper. Contains page content -->
      <!-- <div class="content-wrapper"> -->
          <!-- Content Header (Page header) -->
         

          <!-- Main content -->
          <!-- <section class="content"> -->
            <!-- <div class="container-fluid"> -->
           
              <div class="row">
                <div class="col-md-12"> 
                  <div class="card card-primary card-outline">
                    
                    <div class="card-header card-header d-flex justify-content-between clear-both">
                    
                      <!-- <a href="javascript:void(0);" id="ExportReporttoExcel" class=" me-2 btn btn-info text-white rounded-0 px-4 py-2">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>              
                        My new button
                      </a> -->
                    </div>
                    <div class="card-body pad table-responsive">
                        <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                            <thead>
                                  <tr role="row">
                                    <th>From date Settlement</th>
                                    <th>To date Settlement</th>
                                    <th>Amount</th>
                                    <th>Deduction</th>
                                    <th>Bank UTRs</th>
                                    <th>Pay Date Settlement</th>
                                    <th>Download Recipt</th>
                                  </tr>
                            </thead>
                            <tbody>
                              <?php foreach($settlements_list as $list){ ?>
                                <tr>
                                  <td class="border-bottom">{{date('d m Y',strtotime($list->start_date))}}</td>
                                  <td class="border-bottom">{{date('d m Y',strtotime($list->end_date))}}</td>
                                  <td class="border-bottom">{{$list->amount}}</td>
                                  <td class="border-bottom">{{$list->vendor_cancel_deduction}}</td>
                                  <td class="border-bottom">{{$list->bank_utr}}</td>
                                  <td class="border-bottom">{{date('d m Y',strtotime($list->created_at))}}</td>
                                  <td class="border-bottom"><a href="{{route('restaurant.mis.payout.download_recipt',$list->id)}}" class="">Download</a></td>


                                </tr> 
                              <?php } ?>
                                
                            </tbody>
                            
                        </table>
                    </div>
                  </div>

                </div>
                
              </div>
            <!-- </div> -->

          
          <!-- </section> -->
          <!-- /.content -->
        <!-- </div> -->
        <div class="modal-footer mt-2 border-0">
          <button type="button" class="btn btn-danger btn-sm py-2" data-dismiss="modal">Close</button>
        </div>
        <!-- /.content-wrapper -->

        <!-- /.content-wrapper -->

<!-- /.row -->


<script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script>
  $("input[data-bootstrap-switch]").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
</script>

<script type="text/javascript">


  // $(function () {
    let table = $('#example').dataTable({        
       
        dom: 'Bfrtip',
        buttons: [
          { extend: 'excel', className: 'btn-info',title: 'Settlement-list' }
        ],
        processing: true,
        serverSide: true,
        // buttons: true,
        ajax:{
            url:"{{ route('restaurant.mis.renvenue.settlements.list') }}",
            data: function (d) {
             
            }
        },
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'bank_utr', name: 'bank_utr'},
            {data: 'amount', name: 'amount'},
           
        ]
    });
   
    
  ;


 </script>
 <style>
  th {
    white-space: nowrap;
}


 </style>

