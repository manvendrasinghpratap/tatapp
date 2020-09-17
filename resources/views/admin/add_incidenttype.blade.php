@extends('layout.backened.header')
@section('content')
<?php //dd($data); ?>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Incident Type</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Incident Type</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  



      <div class="row">
        <div class="col-md-9">
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
           
            <form class="" id="addIncidentTypeForm" action="@if(@$data->id) {{route('admin-editIncidentType',['id'=>@$data->id])}} @else  {{route('admin-addIncidentType')}} @endif" method="POST" enctype="multipart/form-data" name="addIncidentTypeForm" >
            {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
                <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Title {{redstar()}}</label>
                  <div class="col-sm-9">
                      <input type="text" name="type" id="type" class="form-control" placeholder="Title" value="{{old('name',@$data->type)}}">
                    <?php if(@$errors->first('type')) { ?><span class="help-block">{{@$errors->first('type')}}</span> <?php } ?>
                  </div>
                </div>

                 <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Description {{redstar()}}</label>
                  <div class="col-sm-9">
                      <input type="text" name="description" id="description" class="form-control" placeholder="Description" value="{{old('name',@$data->description)}}">
                    <?php if(@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                  </div>
                </div>
				
                <?php 
                
                ?>                  
                

                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-incidenttypeList')}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info">
              </div>
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

<script>
$(document).ready(function() {

$(document).ready(function() {
	
	 $("form[name='addIncidentTypeForm']").validate({
            ignore: ".ignore",
            rules: {
                 
				 type: "required",
				 description: "required"
               
            },
            // Specify validation error messages
            messages: {
              
               
            }
        });
	
	

});



});


</script>

  @endsection
  
  
  