@extends('layout.backened.header')
@section('content')
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="classnameheading">{{@$data['caseList']->title}}</div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Manage Target '}} @else {{'Manage Target'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{ 'Home'}}</a></li>
        <li class="active">@if(@$request->id){{'Add Target'}} @else {{'Add Target'}} @endif </li>
      </ol>
        <div style="float:right;">
        <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn edit" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn view" title ="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
         <a href="{{route('admin-delete-target',[$caseId])}}" class="btn btn-info btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </div>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} .width30per{ width: 33%; }</style>   
  <script type="text/javascript">
    $( document ).ready(function() {
    
      $.validator.addMethod('filesize', function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      });
         
      $.validator.addMethod("alphanumspecial", function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/i.test(value);
      }, "Combination of alphabets,special characters & numeric values required.");
        $('#addtarget').validate({
            ignore: ".ignore",
            rules: {                
                name:'required',
                phone_number: {
                    minlength: 6,
                    maxlength: 15,
                    digits: true,
                    required:true,
                },
                 cell_phone: {
                    minlength: 6,
                    maxlength: 15,
                    digits: true,
                     required:true,
                },
                address: {
                    minlength: 4,
                    maxlength: 250,
                    required:true,
                },
                state: {
                    minlength: 2,
                    maxlength: 200,
                    required:true,
                },
                city: {
                    minlength: 3,
                    maxlength: 200,
                    required:true,
                },
                zip_code: {
                    minlength: 3,
                    maxlength: 15,
                    required:true,
                },
            },
            // Specify validation error messages
            messages: {
                name: "Please enter name.",
            },
        });
    });
  
</script>
<!-- Trigger the modal with a button -->
        <button id="modalBt" type="button" class="btn btn-info btn-lg hidden" data-toggle="modal" data-target="#myModal">Open Modal</button>
        <div id="galleryDetails"></div>
 
      <div class="row">
        <div class="col-md-10">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @if(Session::has('add_message'))
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                 {!! session('add_message') !!} 
                </div>
                @endif
            </div>
            <!-- /.box-header -->   
            <!-- form start -->
              <div id="showdescriptiondiv" style="padding-top:30px;margin-left: 40px;">
              <div class="box-body">                    
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Name</label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->name}}</div>
                    </div>
                  <hr>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Phone Number</label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->phone_number}}</div>
                    </div>
                  <hr>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Cell Phone</label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->cell_phone}}</div>
                    </div>
                  <hr>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Address</label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->address}}</div>
                    </div>
                  <hr>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> City </label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->city}}</div>
                    </div>
                  <hr>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> State</label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->state}}</div>
                    </div>
                  <hr>
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Zip Code</label>
                      <div class="col-sm-7">{{ @$data['targetDetailsArray']->zip_code}}</div>
                    </div>
                    @if(@$data['targetDetailsArray']->profile_pic!='')
                    <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Image</label>
                      <div class="col-sm-7"><img src="{{get_image_url(@$data['targetDetailsArray']->profile_pic,'target')}}"  class="img-responsive case_pic width30per" ></div>
                    </div>
                    @endif
                </div>
          </div>
              
              <div id="formdiv" style="padding-top:30px;margin-left: 40px;">
            <form class="" id="addtarget" action=""  method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                    <input type="hidden" name="caseId" id="caseId" value="{{ $caseId }}">
                    <input type="hidden" name="target_id" id="target_id" value="{{ @$data['targetDetailsArray']->id}}">
                  <div class="form-group row @if($errors->first('name')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Name   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="name" name="name" value="{{ @$data['targetDetailsArray']->name}}" placeholder="Name"  class="form-control"/>                    
                        <?php if(@$errors->first('name')) { ?><span class="help-block">{{@$errors->first('name')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('phone_number')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Phone Number   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="phone_number" name="phone_number" value="{{ @$data['targetDetailsArray']->phone_number}}" placeholder="Phone Number"  class="form-control"/>                    
                        <?php if(@$errors->first('phone_number')) { ?><span class="help-block">{{@$errors->first('phone_number')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('cell_phone')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Cell Phone   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="cell_phone" name="cell_phone" value="{{ @$data['targetDetailsArray']->cell_phone}}" placeholder="Cell Phone"  class="form-control"/>                    
                        <?php if(@$errors->first('cell_phone')) { ?><span class="help-block">{{@$errors->first('cell_phone')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('address')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Address   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="address" name="address" value="{{ @$data['targetDetailsArray']->address}}" placeholder="Address"  class="form-control"/>                    
                        <?php if(@$errors->first('address')) { ?><span class="help-block">{{@$errors->first('address')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('city')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> City   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="city" name="city" value="{{ @$data['targetDetailsArray']->city}}" placeholder="City"  class="form-control"/>                    
                        <?php if(@$errors->first('city')) { ?><span class="help-block">{{@$errors->first('city')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('state')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> State   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="state" name="state" value="{{ @$data['targetDetailsArray']->state}}" placeholder="State"  class="form-control"/>                    
                        <?php if(@$errors->first('state')) { ?><span class="help-block">{{@$errors->first('state')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('zip_code')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Zip Code   </label>
                      <div class="col-sm-7">   
                          <input type="text" id="zip_code" name="zip_code" value="{{ @$data['targetDetailsArray']->zip_code}}" placeholder="Zip Code"  class="form-control"/>                    
                        <?php if(@$errors->first('zip_code')) { ?><span class="help-block">{{@$errors->first('zip_code')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif imagediv">
                      <label for="inputError" class="col-sm-3 control-label"> Image   </label>
                      <div class="col-sm-7">
                         <span>  
                          @if(@$data['targetDetailsArray']->profile_pic!='')
                              <img src="{{get_image_url(@$data['targetDetailsArray']->profile_pic,'target')}}"  class="img-responsive case_pic width30per" style="padding-bottom: 15px;">
                          @endif  </span>                
                           <a style="float: left;" href="javascript:void(0)" class="btn btn-default" id="galleryBox" onclick="open_gallery_modal(<?php echo $caseId; ?>, '{{route('admin-ajaxShowGallery')}}');">Select from Gallery</a>
                      </div>
                    </div>
                    
                </div>
              <!-- /.box-body -->
              @if(@$type !='view')
              <div class="box-footer">
                <a href="{{route('admin-viewCase',[$caseId])}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" >
              </div>
              @endif
              <!-- /.box-footer -->
            </form>
          </div>
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       </div> 
      </div>
    <style>
        .error{
            color:red;
        }
    </style>
<script>
     $(document).ready(function(){
        $("#formdiv").hide();
        $(".view").hide();
        $(".edit").on("click", function(){
            $("#formdiv").show(); //
            $(".edit").hide();
            $(".view").show();
            $("#showdescriptiondiv").hide();
       });
        $(".view").on("click", function(){
            $("#formdiv").hide();
            $(".view").hide();
            $("#showdescriptiondiv").show();
            $(".edit").show();
      });
    });
     var open_gallery_modal = function(case_id, link1) {   
         var target_id  = $('#target_id').val();    
          $.ajax({
            type: "POST",
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: link1,
            dataType: 'html',
            data: {// change data to this object
            token : $('meta[name="csrf-token"]').attr('content'), 
            case_id:case_id,target_id:target_id, 
            },
            success: function (data) {                      
                $('#galleryDetails').html(data);
                $('#myModal2').modal('show');  
               }
            });    
        };
</script>
  @endsection
