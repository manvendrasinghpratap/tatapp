@extends('layout.backened.header')
@section('content')
<?php //dd($data); ?>
 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Files</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Files</li>
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
               title: {
                  required: true,                    
                },
                description: {
                  required: true,                    
                },
                 default_pic:{
                  required:true,
                 // extension: "png|jpg|jpeg",filesize:500000000000,
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
<div id="galleryDetails">
    
</div>
 
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
           
            <form class="" id="add-files-form" action="@if(@$data->id) {{route('admin-editFile',['id'=>@$data->id])}} @else  {{route('admin-addfiles')}} @endif" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
              <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Title {{redstar()}}</label>
                  <div class="col-sm-7">
                      <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{old('name',@$data->title)}}">
                    <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                  </div>
                </div>

                 <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Description {{redstar()}}</label>
                  <div class="col-sm-7">
                      <input type="text" name="description" id="description" class="form-control" placeholder="Description" value="{{old('name',@$data->description)}}">
                    <?php if(@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                  </div>
                </div>
                    <div class="form-group row @if($errors->first('default_pic')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Add Files')}}</label>
                   
                    <div class="col-sm-7">
                      <?php if(!empty($data->newfilename))
                                    { 
                                        $ext = explode('.',$data->newfilename); 
                                        $fileExt = end($ext);
                                        if(in_array($fileExt,$extArray)){
                                            ?><img src="{{get_image_url(@$data->newfilename,'files')}}" style="height:100px"><?php 
                                        }else{
                                           echo  @$data->originalfilename;
                                        } 
                                  }   
                                  ?> 
                       <div class="padding_bottom"></div>            
                     @if($type !='view') <input type="file" id="default_pic"  name="default_pic" data-buttonName="btn-primary"> @endif
                      <?php if(@$errors->first('default_pic')) { ?><span class="help-block">{{@$errors->first('default_pic')}}</span> <?php } ?>
                    </div>
                  </div>
                  @if($type =='view')
                  <div class="form-group row ">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Cases')}}</label>
                   
                    <div class="col-sm-7">
                  <?php  $casesfilesArray  = array();
                                if(!empty( $data->casesfiles) ){
                                    $casesName = $data->casesfiles;
                                    foreach ($casesName as $key => $value) {
                                        $casesfilesArray[] = $value->cases->title;
                                    }
                                    echo implode(',<br>',array_unique($casesfilesArray));                                    
                                }
                               ?>	 
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Incident')}}</label>                   
                    <div class="col-sm-7">
                    <?php $incidentArray  = array(); if(!empty( $data->incidentfiles) ){
                                    $incidentName = $data->incidentfiles;
                                    foreach ($incidentName as $key => $value) {
                                        $incidentArray[] = $value->incident->title;
                                    }
                                    echo implode(',<br>',array_unique($incidentArray));
                                }
                               ?>	 
                    </div>
                  </div>
                  @endif
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
<script>
     var open_gallery_modal = function(link1) {
          $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: link1,
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'), 
                    data:1 
                    },
                    success: function (data) {                      
                        $('#galleryDetails').html(data);
                        $('#modalBt').trigger('click');
                       }
                    });
   
    };
</script>

  @endsection