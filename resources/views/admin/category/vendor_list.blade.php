@extends('admin.layouts.layoute')
@section('content')
@section('page-style')
<style>
    
        label.error {
            color: #dc3545;
            font-size: 14px;
        }
        .image-upload{
            display:inline-block;
            margin-right:15px;
            position:relative;
        }
        .image-upload > input
        {
            display: none;
        }
        .upload-icon{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        .upload-icon img{
          width: 100px;
          height: 100px;
          margin:19px;
          cursor: pointer;
        }
        
        
        .upload-icon.has-img {
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon.has-img img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
        /*  */
        .upload-icon2{
          width: 150px;
          height: 150px;
          border: 2px solid #000;
          border-style: dotted;
          border-radius: 18px;
        }
        
        .upload-icon2 img{
            width: 100px;
            height: 100px;
            margin:19px;
            cursor: pointer;
        }
        
        .upload-icon2.has-img2{
            width: 150px;
            height: 150px;
            border: none;
        }
        
        .upload-icon2.has-img2 img {
            /*width: 100%;
            height: auto;*/
            width: 150px;
            height: 150px;
            border-radius: 18px;
            margin:0px;
        }
      </style>
@endsection
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">List of Vendor</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			
            <div class="col-md-12">
          
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">List of Vendor Belongs From "{{$category->name}}" Category </h3>

                  <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                  </div>
                </div>
                <div class="card-body">
                  <table id="example" class="table table-bordered table-hover dtr-inline datatable" aria-describedby="example2_info" width="100%"> 
                      <thead>
                        <tr role="row">
                            <th class="text-center">Sr No.</th>
                            <th>Vendor name / Owner name</th>
                            <th>Email/Mobile</th>
                            <th> Status</th>
                            <th> Image</th>
                            <!-- <th>Wallet</th>
                            <th>Delivered Orders</th>
                            <th>Received Orders</th>
                             -->
                            <th>created at</th>
                            <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($vendors as $key =>$value)
                            <tr>
                                <td>1</td>
                                <td>{{$value->name}}<br>{{$value->owner_name}}</td>
                                <td>{{$value->email}}<br>{{$value->mobile}}</td>
                                <td><?php echo  (!empty($value->status)) && ($value->status == 1) ? '<button class="btn btn-xs btn-success inactiveVendor" data-url="'.route('admin.vendors.inactive',Crypt::encryptString($value->id)).'" >Active</button>' : '<button class="btn btn-xs btn-danger inactiveVendor" data-url="'.route('admin.vendors.active',Crypt::encryptString($value->id)).'">In active</button>'; ?></td>
                                <td><?php echo  "<img src=" . asset('vendors') . '/' . $value->image . "  style='width: 50px;' />";; ?></td>
                                <td><?php echo  date('d M Y h:i A', strtotime($value->created_at)); ?></td>
                            </tr>
                        @endforeach
                      </tbody>
                      
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              
            
            
		    </div>

        
                  
        </div>
    </section>
        <!-- /.content -->
  </div>
    <!-- /.content-wrapper -->

    <!-- /.content-wrapper -->

    <!-- /.row -->
@endsection

