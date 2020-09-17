@extends('layout.backened.header')
@section('content')
<?php //dd($data); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$request->id){{'Link Files to Incidents '}} @else {{'Add'}} @endif </h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$request->id){{'Link Files to Incidents'}} @else {{'Add'}} @endif </li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {         
      $('#add-button').click(function (event) {
        for (var i in CKEDITOR.instances) {
              CKEDITOR.instances[i].updateElement();
          }

          $("#add-files-form").submit();
      });
         
        $('#add-files-form').validate({
            ignore: ".ignore",
            rules: {
               incidentid: {
                  required: true,                    
                },               		
            },
            // Specify validation error messages
            messages: {
             
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
           
            <form class="" id="add-files-form" action="@if(@$request->id) {{route('admin-incidentAndFilesMapped',['id'=>@$request->id])}} @else  {{route('admin-incidentAndFilesMapped')}} @endif" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$request->id)}}">
              <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Incidents {{redstar()}}</label>
                  <div class="col-sm-7">
                  <?php 
                    $incidentArray  = array();
                    if(!empty( $data->incidentfiles) ){
                        $incidentName = $data->incidentfiles;
                        foreach ($incidentName as $key => $value) {
                            $incidentArray[] = $value->incident->id;
                        }
                    }
                   ?>    
                    <input type="hidden" name="existingIncidentId"  value="<?php echo implode(',', $incidentArray);?>"> 
                    <select class="form-control incidentid"  name="incidentid[]" id='incidentid' multiple="true">
                      <option value="">--Select Incident</option>
                      @if( !empty($incidentListArray) )
                        @foreach($incidentListArray as $key=>$value)
                          <option <?php if( !empty($incidentArray) && in_array($key,$incidentArray) ) { echo 'selected = selected';} ?> value="{{ $key}}">{{ $value}}</option>
                        @endforeach  
                      @endif
                    </select>
                    <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                  </div>
                </div>
                </div>
              <!-- /.box-body -->
              @if($type !='view')
              <div class="box-footer">
                <a href="{{route('admin-filelist')}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" >
              </div>
              @endif
              <!-- /.box-footer -->
            </form>
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

  @endsection