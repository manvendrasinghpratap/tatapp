@extends('layout.backened.header')
@section('content')
<?php //dd($data['subjectDetails']->case->title ); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="classnameheading"></div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Assign Case to Task '}} @else {{'Manage Target'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li class="active">@if(@$request->id){{'Assign Case to Task'}} @else {{'Add Target'}} @endif </li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
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
                caseId:'required',
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
            </div>
            <!-- /.box-header -->   
            <!-- form start -->   
            <div id="formdiv" style="padding-top:30px;margin-left: 40px;">
                <form class="" id="addtarget" action=""  method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="box-body">                  
                   <div class="form-group row @if($errors->first('caseId')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Case {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <select class="form-control" name="caseId" id="caseId">
                              <option value="" >--Select Case--</option>                              
                              @if(!empty($data['caseListArray']) && (count($data['caseListArray'])>0 ))
                                   @foreach($data['caseListArray'] as $innerKey=>$innerCase)
                                        <option value="{{$innerKey}}">{{$innerCase}}</option>
                                   @endforeach
                              @endif
                          </select>                  
                        <?php if(@$errors->first('caseId')) { ?><span class="help-block">{{@$errors->first('caseId')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('name')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Name {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="name" name="name" value="{{ @$data['subjectDetails']->name}}" placeholder="Name"  class="form-control"/>                    
                        <?php if(@$errors->first('name')) { ?><span class="help-block">{{@$errors->first('name')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('phone_number')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Phone Number {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="phone_number" name="phone_number" value="{{ @$data['subjectDetails']->phone_number}}" placeholder="Phone Number"  class="form-control"/>                    
                        <?php if(@$errors->first('phone_number')) { ?><span class="help-block">{{@$errors->first('phone_number')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('cell_phone')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Cell Phone {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="cell_phone" name="cell_phone" value="{{ @$data['subjectDetails']->cell_phone}}" placeholder="Cell Phone"  class="form-control"/>                    
                        <?php if(@$errors->first('cell_phone')) { ?><span class="help-block">{{@$errors->first('cell_phone')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('address')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Address {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="address" name="address" value="{{ @$data['subjectDetails']->address}}" placeholder="Address"  class="form-control"/>                    
                        <?php if(@$errors->first('address')) { ?><span class="help-block">{{@$errors->first('address')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('city')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> City {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="city" name="city" value="{{ @$data['subjectDetails']->city}}" placeholder="City"  class="form-control"/>                    
                        <?php if(@$errors->first('city')) { ?><span class="help-block">{{@$errors->first('city')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('state')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> State {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="state" name="state" value="{{ @$data['subjectDetails']->state}}" placeholder="State"  class="form-control"/>                    
                        <?php if(@$errors->first('state')) { ?><span class="help-block">{{@$errors->first('state')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('zip_code')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Zip Code {{redstar()}}</label>
                      <div class="col-sm-7">   
                          <input type="text" id="zip_code" name="zip_code" value="{{ @$data['subjectDetails']->zip_code}}" placeholder="Zip Code"  class="form-control"/>                    
                        <?php if(@$errors->first('zip_code')) { ?><span class="help-block">{{@$errors->first('zip_code')}}</span> <?php } ?>
                      </div>
                    </div>
                  <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif " style="display:none;">
                      <label for="inputError" class="col-sm-3 control-label"> Image {{redstar()}}</label>
                      <div class="col-sm-7">
                          <a href="#" class="btn btn-default" id="galleryBox" onclick="open_gallery_modal(<?php echo $caseId; ?>, '{{route('admin-ajaxShowGallery')}}');">Select from Gallery</a>                    
                        <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                      </div>
                    </div>
                </div>
              <!-- /.box-body -->
              
              <div class="box-footer">
                <a href="{{route('admin-subjectList')}}" class="btn btn-default" id='cancel'>Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" >
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
          </div>
          
        </div>
        <!--/.col (right) -->
        </div>
       </div> 
    <style>
        .error{
            color:red;
        }
    </style>

  @endsection
