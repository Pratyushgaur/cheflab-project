@extends('vendor.restaurants-layout')
@section('main-content')
<style>
      .select2-selection__choice{
        background:#ff0018;
      }
      .select2-selection__choice__display{
        color:#fff;
      }
      .select2-container--default .select2-selection--multiple .select2-selection__choice{
        background-color:#ff0018;
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
    </style>
    <div class="ms-content-wrapper">
      <div class="row">

        <div class="col-md-12">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb pl-0">
              <li class="breadcrumb-item"><a href="#"><i class="material-icons">home</i> Home</a></li>
              <li class="breadcrumb-item"><a href="#">Offer</a></li>
              <li class="breadcrumb-item" aria-current="page"><a href="{{route('restaurant.menu.list')}}">Menu Catalogue</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit Offer</li>
              

            </ol>
          </nav>
        </div>
        <div class="col-xl-12 col-md-12">
          <div class="ms-panel ms-panel-fh">
            <div class="ms-panel-header">
              <h6>Edit Offer</h6>
            </div>
            <div class="ms-panel-body">
              <form class=" clearfix " id="coupon-form" action="{{route('restaurant.offer.update',$VendorOffers->id)}}"  method="post" enctype="multipart/form-data">
              @csrf
              
              @if ($errors->any())
                  @foreach ($errors->all() as $error)
                      <div class="alert alert-danger">{{$error}}</div>
                  @endforeach
              @endif
                <div class="form-row">
                    <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">Offer Persentage</label>
                        <div class="input-group">
                          <input type="text" value="{{$VendorOffers->offer_persentage}}" name="offer_persentage" class="form-control"  id="exampleInputEmail1" placeholder="Offer %">
                        
                        </div>
                        <span class="name_error text-danger"></span>
                     </div>
                    
                    
                     
                    
                    
                      
                    
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">From</label>
                        <div class="input-group">
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                              <input type="date" value="{{$VendorOffers->from_date}}" name="from_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                        </div>
                        <span class="from_error text-danger"></span>
                        </div>
                           
                     </div>
                     <div class="col-xl-3 col-md-12 mb-3">
                      <label for="validationCustom10">To</label>
                        <div class="input-group">
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <input type="date" value="{{$VendorOffers->to_date}}" name="end_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            
                        </div>
                        <span class="to_error text-danger"></span>
                        </div>
                           
                     </div>
                     
                   
                    


                  </div>
                
                <button class="btn btn-primary float-right" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  
@endsection

@section('page-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
<script type="text/javascript">
     $("#coupon-form").validate({
      rules: {
              offer_persentage: {
                  required: true,
              },
              from_date: {
                required: true,
              },
              from_date: {
                required: true,
              }
        },
        errorPlacement: function (error, element) {
              var name = $(element).attr("name");
             
              error.appendTo($("." + name + "_error"));
          }, 
    });
    $('#file-input').change( function(event) {
          $("img.icon").attr('src',URL.createObjectURL(event.target.files[0]));
          $("img.icon").parents('.upload-icon').addClass('has-img');
      });
    $('#row_dim').hide(); 
    $('#type').change(function(){
        if($('#type').val() == 'product') {
            $('#row_dim').show(); 
        } else {
            $('#row_dim').hide(); 
        } 
    });
    $('#reservationdate').datetimepicker({
          format: 'L'
      });
      $('#reservationdate1').datetimepicker({
          format: 'L'
      });
</script>
<script>
  (function($) {
    
  })(jQuery);
</script>
@endsection