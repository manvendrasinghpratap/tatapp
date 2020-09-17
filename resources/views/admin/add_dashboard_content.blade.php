@extends('layout.backened.header')
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif Video</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="">{{_i('Starter Plan')}}</a></li>
        <li class="active">@if(@$data->_id){{'Update'}} @else {{'Add'}} @endif {{_i('Video')}}</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {

      $('#add-video').click(function (event) {
        for (var i in CKEDITOR.instances) {
              CKEDITOR.instances[i].updateElement();
          }

          $("#starter-form").submit();
      });
         
      $('#cms-form').validate({
            ignore: ".ignore",
            rules: {
                video_title_en:'required',
                video_title_fr: "required",
                video_url_fr: "required",
                video_url_en: "required",
                description_en :"required",
                description_en : "required"
            },
            // Specify validation error messages
            messages: {
              
                video_title_en: "Please enter title.",
                video_title_fr: "Please enter title.",
                video_url_fr: "Please enter video url.",
                video_url_en: "Please enter video url.",
                description_en :"Please enter long description.",
                description_fr : "Please enter long description."
            },
        });
    });
  
</script>


   
    <section class="content">
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
            <form class="form-horizontal" id="cms-form" action="{{route('admin-save-homepage')}}" method="POST" enctype="multipart/form-data">
             {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
                <div class="form-group @if($errors->first('video_title_en')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label"> Video Title (en){{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="video_title_en" id="video_title_en" class="form-control" placeholder="Video Title (en)" value="{{old('name',@$data->video_title_en)}}">
                    <?php if(@$errors->first('video_title_en')) { ?><span class="help-block">{{@$errors->first('video_title_en')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group @if($errors->first('video_title_fr')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Video Title (fr){{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="video_title_fr" id="video_title_fr" class="form-control" placeholder="Video Title (fr)" value="{{old('name',@$data->video_title_fr)}}">
                    <?php if(@$errors->first('video_title_fr')) { ?><span class="help-block">{{@$errors->first('video_title_fr')}}</span> <?php } ?>
                  </div>
                </div>

                 <div class="form-group @if($errors->first('video_url_en')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Video URL (en){{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="video_url_en" id="video_url_en" class="form-control" placeholder="Video Embedded URL" value="{{old('name',@$data->video_url_en)}}">
                    <?php if(@$errors->first('video_url_en')) { ?><span class="help-block">{{@$errors->first('video_url_en')}}</span> <?php } ?>
                  </div>
                </div>


                 <div class="form-group @if($errors->first('video_url_fr')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Video URL (fr){{redstar()}}</label>
                  <div class="col-sm-10">
                      <input type="text" name="video_url_fr" id="video_url_fr" class="form-control" placeholder="Video Embedded URL" value="{{old('name',@$data->video_url_fr)}}">
                    <?php if(@$errors->first('video_url_fr')) { ?><span class="help-block">{{@$errors->first('video_url_fr')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group @if($errors->first('description_en')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Description (en){{redstar()}}</label>
                  <div class="col-sm-10">
                     <textarea name="description_en" class="ckeditor" id="description_en" rows="5" cols="15" value="{{old('name',@$data->description_en)}}">{{@$data->description_en}}</textarea>
                    <?php if(@$errors->first('description_en')) { ?><span class="help-block">{{@$errors->first('description_en')}}</span> <?php } ?>
                  </div>
                </div>

                <div class="form-group @if($errors->first('description_fr')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-2 control-label">Description (fr){{redstar()}}</label>
                  <div class="col-sm-10">
                      <textarea name="description_fr" class="ckeditor" id="description_fr" rows="5" cols="15" value="{{old('name',@$data->description_fr)}}">{{@$data->description_fr}}</textarea>
                    <?php if(@$errors->first('description_fr')) { ?><span class="help-block">{{@$errors->first('description_fr')}}</span> <?php } ?>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-home-cms')}}" class="btn btn-default">Cancel</a>
                <input  id="add-video" type="submit" value="Submit" class="btn btn-info">
              </div>
              <!-- /.box-footer -->
            </form>
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
 
</script>
  @endsection