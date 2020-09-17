@extends('layout.backened.header')
@section('content')
<?php //dd($data['caseDetails']->title); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="classnameheading">{{$data['caseDetails']->title}}</div>        
        <div class="paddingbottom10px"><h3>@if(@$request->id){{'Manage Description '}} @else {{'Manage Description'}} @endif </h3></div>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$request->id){{'Add Description'}} @else {{'Add Subject'}} @endif </li>
      </ol>
        <div style="float:right;">
        <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn edit" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
            <a href="javascript:void(0)" class="btn btn-info btn-xs action-btn view" title ="View"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
         <a href="{{route('admin-delete-description',[$caseId])}}" class="btn btn-info btn-xs action-btn" onclick="return confirm('Are you sure you want to delete ?');" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </div>
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
                    minlength: 3,
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
            {{ csrf_field() }}
              <div class="box-body">
                  <div class="form-group row ">
                      <label for="inputError" class="col-sm-3 control-label"> Description </label>
                      <div class="col-sm-9">   
                          {{ @$data['caseDetails']->description }} 
                      </div>
                    </div>
                </div>
              <!-- /.box-footer -->
          </div>      
        <div id="formdiv" style="padding-top:30px;margin-left: 40px;">
            <form class="" id="addsubject_" action=""  method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
                    <input type="hidden" name="caseId" id="caseId" value="{{ $caseId}}">
                  <div class="form-group row @if($errors->first('name')) {{' has-error has-feedback'}} @endif ">
                      <label for="inputError" class="col-sm-3 control-label"> Description {{redstar()}}</label>
                      <div class="col-sm-9">   
                          <textarea rows="10" cols="100" name="description" class="form-control">{{ @$data['caseDetails']->description }}</textarea>                   
                        <?php if(@$errors->first('name')) { ?><span class="help-block">{{@$errors->first('name')}}</span> <?php } ?>
                      </div>
                    </div>
                </div>
              <!-- /.box-body -->
              @if(@$type !='view')
              <div class="box-footer">
                <a href="{{route('admin-viewCase',[$caseId])}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info " >
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
</script>
  @endsection
