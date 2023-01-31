@extends('admin.layouts.layoute')
@section('content')


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Delivery Boy Details</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Delivery Boy</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <div class="mb-4">
    <div class="">

      <ul class="nav nav-tabs page-header-tabs mt-0">
        <li class="nav-item">
          <a type="button" class="nav-link active click_tab click_tab_1" onclick="tabData('{{ $rider_id }}','info')" aria-disabled="true">Information</a>
        </li>
        <li class="nav-item">
          <a type="button" class="nav-link click_tab click_tab_2" onclick="tabData('{{ $rider_id }}','tran')" aria-disabled="true">Transaction</a>
        </li>
        <li class="nav-item">
          <a type="button" class="nav-link click_tab click_tab_3" onclick="tabData('{{ $rider_id }}','time')" aria-disabled="true">Time Logs</a>
        </li>
        <li class="nav-item">
          <a type="button" class="nav-link click_tab click_tab_4" onclick="tabData('{{ $rider_id }}','conv')" aria-disabled="true">Conversations</a>
        </li>
      </ul>

    </div>
  </div>
<input type="hidden" id="riderId" value="{{ $rider_id }}">
  <section class="content table-all-data">
   
  </section>
  <!-- /.content -->
</div>
@endsection


@section('js_section')
<script>
  $("input[data-bootstrap-switch]").each(function() {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  })
</script>

<script type="text/javascript">
 
  var rider_id_ref = $("#riderId").val();
  var type_ref = "info";
  tabData(rider_id_ref, type_ref);

  function tabData(rider_id, type) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      url: "{{ route('admin.delivery_boy.transaction') }}",
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        "_token": "{{ csrf_token() }}",
        "rider_id": rider_id,
        "type": type
      },
      success: function(response) {
        if (response.type == 'info') {
          $(".click_tab").removeClass('active');
          $(".click_tab_1").addClass('active');
        } else if (type == 'tran') {
          $(".click_tab").removeClass('active');
          $(".click_tab_2").addClass('active');
        } else if (type == 'time') {
          $(".click_tab").removeClass('active');
          $(".click_tab_3").addClass('active');
        } else if (type == 'conv') {
          $(".click_tab").removeClass('active');
          $(".click_tab_4").addClass('active');
        }
        $('.table-all-data').html('');
        $('.table-all-data').html(response.view);
       
      }
    });
  }
</script>
@endsection