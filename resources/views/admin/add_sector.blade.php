@extends('layout.backened.header')
@section('content')
  <div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3 class="paddingbottom10px">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif Sector</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> Home</a></li>
        <li><a href="">{{_i('Sector')}}</a></li>
        <li class="active">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif {{_i('Sector')}}</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {

      $('#sector-form').validate({
            ignore: ".ignore",
            rules: {
                sector_name:'required',
                isActive: "required"
                
            },
            // Specify validation error messages
            messages: {
              
                sector_name: "Please enter title.",
                isActive: "Please enter title."
                
            },
        });
    });
  
</script>


   
  
      <div class="row">
        <div class="col-md-12">
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
            <form class="" id="sector-form" action="{{route('admin-add-sector')}}" method="POST" enctype="multipart/form-data">
             {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">

              
                <div class="form-group row @if($errors->first('sector_name')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Sector Name{{redstar()}}</label>
                  <div class="col-sm-7">
                      <input type="text" name="sector_name" id="sector_name" class="form-control" placeholder="Title" value="{{old('name',@$data->sector_name)}}">
                      <input type="hidden" name="module_id" value="{{@$module_id}}">
                    <?php if(@$errors->first('sector_name')) { ?><span class="help-block">{{@$errors->first('sector_name')}}</span> <?php } ?>
                  </div>
                </div>


                <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Description</label>
                  <div class="col-sm-7">
                      <input type="text" name="description" id="description" class="form-control" placeholder="Description" value="{{old('name',@$data->description)}}">
                      <input type="hidden" name="module_id" value="{{@$module_id}}">
                    <?php if(@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                  </div>
                </div>



                    <div class="form-group row @if($errors->first('isActive')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> isActive{{redstar()}}</label>
                  <div class="col-sm-7">
                    
                      <select name="isActive" class="form-control" id="isActive">
                                            <option value="">Select</option>
                                            <option @if(@$data->isActive=='y') {{'selected'}} @endif value="y">{{_i('Active')}}</option>
                                            <option @if(@$data->isActive=='n') {{'selected'}} @endif value="n">{{_i('In Active')}}</option>
                                           
                                        </select>
                    <?php if(@$errors->first('isActive')) { ?><span class="help-block">{{@$errors->first('isActive')}}</span> <?php } ?>
                  </div>
                </div>

             
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-sector-list')}}" class="btn btn-default">Cancel</a>
                <input  id="add-video" type="submit" value="Submit" class="btn btn-info">
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
 
</script>
  @endsection