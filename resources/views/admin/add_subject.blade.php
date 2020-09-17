@extends('layout.backened.header')
@section('content')
<?php //dd($data['subjectDetails']->case->title ); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="classnameheading">{{$data['CaseList']->title}}</div>
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Assign Case to Task '}} @else {{'Manage Subject'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$request->id){{'Assign Case to Task'}} @else {{'Add Subject'}} @endif </li>
      </ol>
        <div style="float:right;">
        <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn edit" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn view" title ="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
            @if(!empty(@$data['subjectDetails']->id))
         <a href="{{route('admin-delete-subject',[$caseId,@$data['subjectDetails']->id])}}" class="btn btn-info btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
            @endif
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
        $('#addsubject').validate({
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
            </div>
            <!-- /.box-header -->   
            <!-- form start -->   
            
             <div id="showdescriptiondiv" style="padding-top:30px;margin-left: 40px;">
              <div class="box-body">
                  <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> Name </label>
                      <div class="col-sm-7">   
                          {{ @$data['subjectDetails']->name}}
                      </div>
                    </div>
                  <hr>
                   <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> Phone Number </label>
                      <div class="col-sm-7">   
                          {{ @$data['subjectDetails']->phone_number}}
                      </div>
                    </div>
                  <hr>
                   <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> Cell Phone </label>
                      <div class="col-sm-7">   {{ @$data['subjectDetails']->cell_phone}}
                      </div>
                    </div>
                  <hr>
                   <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> Address </label>
                      <div class="col-sm-7">  {{ @$data['subjectDetails']->address}}
                      </div>
                    </div>
                  <hr>
                    <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> City </label>
                      <div class="col-sm-7">   
                      {{ @$data['subjectDetails']->city}}
                      </div>
                    </div>
                  <hr>
                   <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> State</label>
                      <div class="col-sm-7">   {{ @$data['subjectDetails']->state}}
                      </div>
                    </div>
                  <hr>
                   
                   <div class="form-group row  ">
                      <label for="inputError" class="col-sm-3 control-label"> Zip Code </label>
                      <div class="col-sm-7">   
                          {{ @$data['subjectDetails']->zip_code}}
                      </div>
                    </div>
                    @if(@$data['subjectDetails']->profile_pic!='')
                    <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Image</label>
                      <div class="col-sm-7"><img src="{{get_image_url(@$data['subjectDetails']->profile_pic,'subject')}}"  class="img-responsive case_pic width30per" ></div>
                    </div>
                    @endif
                </div>
            </div>
            <div id="formdiv" style="padding-top:30px;margin-left: 40px;">
                <form class="" id="addsubject" action=""  method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                    <input type="hidden" name="caseId" id="caseId" value="{{ $caseId}}">
                   <input type="hidden" name="subject_id" id="subject_id" value="{{ @$data['subjectDetails']->id}}">
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
                  <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Image {{redstar()}}</label>
                      <div class="col-sm-7">
                        <span>  
                          @if(@$data['subjectDetails']->profile_pic!='')
                              <img src="{{get_image_url(@$data['subjectDetails']->profile_pic,'subject')}}"  class="img-responsive case_pic width30per" style="padding-bottom: 15px;">
                          @endif  </span> 
                          <a href="#" class="btn btn-default" id="galleryBox" onclick="open_gallery_modal(<?php echo $caseId; ?>, '{{route('admin-ajaxShowGallery')}}');">Select from Gallery</a>                    
                        <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                      </div>
                    </div>
                </div>
              <!-- /.box-body -->
              
              <div class="box-footer">
                <a href="{{route('admin-managesubject',[$caseId])}}" class="btn btn-default" id='cancel'>Cancel</a>
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
    var subject_id  = $('#subject_id').val();         
    $.ajax({
        type: "POST",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: link1,
        dataType: 'html',
        data: {// change data to this object
        token : $('meta[name="csrf-token"]').attr('content'), 
        case_id:case_id,subject_id:subject_id 
        },
        success: function (data) {                      
            $('#galleryDetails').html(data);
            //$('#modalBt').trigger('click');
            $('#myModal2').modal('show');  
           }
        });    
    };
    
</script>
  @endsection
