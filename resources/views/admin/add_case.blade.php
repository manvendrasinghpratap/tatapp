@extends('layout.backened.header')
@section('content')
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
    <div id="sectorDetails"></div>

 <div class="clearfix"></div>
 <div class="section" > 
    <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Case</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-dashboard"></i> {{_i('Home')}}</a></li>
        <li class="active">@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Case</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style>   
  <script type="text/javascript">
    $( document ).ready(function() {         
      $('#add-button').click(function (event) {
        for (var i in CKEDITOR.instances) {
              CKEDITOR.instances[i].updateElement();
          }

          $("#add-case-form").submit();
      });
         
        $('#add-case-form').validate({
            ignore: ".ignore",
            rules: {
                 title: {
                  required: true,                    
                },
                description: {
                  required: true,                    
                },
                status: "required",
                urgency: "required",
                case_owner_id1: "required",
                group: "required",
		          default_pic:{extension: "png|jpg|jpeg",filesize:500000000000}				
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
           
            <form class="" id="add-case-form" action="@if(@$data->id) {{route('admin-editCase',['id'=>@$data->id])}} @else  {{route('admin-addCase')}} @endif" method="POST" enctype="multipart/form-data">
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

                 <div class="form-group row @if($errors->first('status')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Status{{redstar()}}</label>
                  <div class="col-sm-7">
                      <select name="status" class="form-control" id="status">
                                            <option value="">Select</option>
                                            <option @if(@$data->status=='new') {{'selected'}} @endif value="new">{{_i('New')}}</option>
                                            <option @if(@$data->status=='active') {{'selected'}} @endif value="active">{{_i('Active')}}</option>
                                            <option @if(@$data->status=='closed') {{'selected'}} @endif value="closed">{{_i('Closed')}}</option>
                                            <option @if(@$data->status=='archived') {{'selected'}} @endif value="archived">{{_i('Archived')}}</option>
                                        </select>
                    <?php if(@$errors->first('status')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php } ?>
                  </div>
                </div>
               @if(in_array($request->session()->get('user_role_id'), array(1,2,3)) )
               
               <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Group{{redstar()}}</label>
                  <div class="col-sm-7">
                     
                      <select name="group" class="form-control" id="group">
                            <option value="">Select</option>
                            @if(count($group)>0)
                            @foreach($group as $row) 
                            <?php 
$selectedClass = (isset($data->caseGroup->group_id) && $data->caseGroup->group_id==$row->id)?'selected':'';
                            ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                          @endforeach
                           

                          @endif
                          </select>
                       
                    <?php if(@$errors->first('group')) { ?><span class="help-block">{{@$errors->first('group')}}</span> <?php } ?>
                  </div>
                </div>
               @else  
                    <input type="hidden" name="group" value="<?php echo (isset($data->caseGroup->group_id))? $data->caseGroup->group_id:''?>">   
                    @if(isset($data->caseGroup))        
                        <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif ">
                          <label for="inputError" class="col-sm-3 control-label"> Group{{redstar()}}</label>
                          <div class="col-sm-7">
                             {{ $data->caseGroup->group->name}} 
                          </div>
                        </div>
                    @endif 
                 
               @endif

                 <div class="form-group row @if($errors->first('urgency')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">Urgency {{redstar()}}</label>
                    <div class="col-sm-7">
                       <select name="urgency" class="form-control" id="urgency">
                                            <option value="">Select</option>
                                            <?php for($i=1;$i<6;$i++){ ?>
                                            <option @if(@$data->urgency==$i) {{'selected'}} @endif value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php } ?>
                                            
                                        </select>
                        <?php if(@$errors->first('urgency')) { ?><span class="help-block">{{@$errors->first('urgency')}}</span> <?php } ?>
                    </div>
                  </div>
                  @if(Session::get('user_role_id')<4)
                  <div class="form-group row @if($errors->first('case_owner_id')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">Owner List{{redstar()}}</label>
                    <div class="col-sm-7">
                          <select name="case_owner_id1" class="form-control" id="case_owner_id1">
                            <option value="">Select</option>
                            @if(count($userList)>0)
                            @foreach($userList as $row) 
                            <?php $selectedClass = (isset($data->case_owner_id) && $data->case_owner_id==$row->id)?'selected':''; ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->first_name.' '.$row->last_name; ?></option>
                          @endforeach
                          @else

                          @endif

                          </select>
                        <?php if(@$errors->first('case_owner_id')) { ?><span class="help-block">{{@$errors->first('case_owner_id')}}</span> <?php } ?>
                    </div>
                  </div>
                  @endif

                 
                  
                  

                <?php 
                if(isset($data->id) && $data->id>0) { 
                  ?>
            <div class="alert alert-info" role="alert">
            <strong>IMPORTANT NOTE:</strong>To change Case Image please go to the <a class= "removehref" href="{{route('admin-viewCase',['id'=>$data->id])}}">View case Details</a> page by clicking the link and then again click on CASE image to change case Image. 
            </div>
			
			
                  <div class="form-group row ">
                     <label for="inputError" class="col-sm-3 control-label">Image</label>
                     <div class="col-sm-7">
						 @if(@$data->default_pic!='')
                         <img src="{{get_image_url(@$data->default_pic,'package')}}" style="height:100px">
						@else
							<img src="{{asset('images/user-male-silhouette.jpg')}}" style="height:100px">
						 @endif
                      </div>
                  </div>
			
				
			
          
			
                  <?php

                } 
                else  {
                  ?>
                    <div class="form-group row @if($errors->first('default_pic')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">{{_i('Case Image')}}</label>
                   
                    <div class="col-sm-7">
                      <input type="file" id="default_pic"  name="default_pic" data-buttonName="btn-primary">
                      <?php if(@$errors->first('default_pic')) { ?><span class="help-block">{{@$errors->first('default_pic')}}</span> <?php } ?>
                      <div id="sizestatuserror"></div>
                    </div>
                  </div>
                  <?php

                } 
				
                ?>                  
                

                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{route('admin-caseList')}}" class="btn btn-default removehref ">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" >
                <input type="hidden" name="defaultSpace" id="defaultSpace" value="{{$defaultSpace}}">
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          
        </div>
        <!--/.col (right) -->

        </div>

      </div>
      @if(!@empty($data->id))
      <?php  //echo '<pre>'; print_r($data->task[0]->task); echo '</pre>'; ?>
       <div class="panel panel-default margin15 margintop5per">
        <div class="panel-heading">Linked Task</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12" id="ajaxresp">
                          <div class="table-responsive">
                                <table class="table" id="printTable">
                                      <tr>
                                        <th>S.No</th>
                                        <th>{{_i('Title')}}</th>
                                        <th>Assign To</th>
                                        <th>{{_i('Due Date')}}</th>
                                        <th>Status</th> 
                                        <th>{{_i('Created Date')}}</th>                                
                                        <th>{{_i('Action')}}</th>                                
                                      </tr>
                                      @if( !empty($data->task) && (count($data->task)>0))                          
                                          @foreach($data->task as $k=>$row)
                                           @if(!empty($row->task->id))
                                              <tr>
                                                <td scope="row">{{$k+1}}</td>
                                                <td><a href="javascript:open_change_status_task_modal({{$row->task->id}}, {{$data->id}}, '{{route('admin-ajaxGetTaskDetailsChangeStatus')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="add-tasks" Title="Update Task Status">{{wordwrap($row->task->title, 20, "\n", true)}}</a>
                                                  </td>
                                                <td>{{ @$row->task['user']['first_name'] }} &nbsp; {{ @$row->task['user']['last_name'] }}</td> 
                                                <td>{{date("F j, Y", strtotime($row->task->due_date))}}</td> 
                                                <td><?php echo getStatusTitle($row->task->status); ?></td>
                                                <td>{{date("F j, Y", strtotime($row->task->created_at))}}</td>
                                                <td>
                                                  <form class="form-horizontal" id="frm_{{$row->id}}" action="{{route('admin-linkcaseToTaskAction')}}" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" value="{{$data->id}}" name="casetaskid">
                                                <input type="hidden" value="{{$row->task->id}}" name="taskid">
                                                <input type="submit" name="taskunlink"id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected Task to Case ?')">
                                                </form>
                                                </td>
                                              </tr>   
                                              @endif                         
                                           @endforeach
                                        @else
                                        <tr class="bg-info">
                                            <td colspan="8">Record(s) not found.</td>
                                        </tr>
                                        @endif
                                        <tr>
                                          <td colspan="7">    
                                        <a href="{{route('admin-addnewTaskCase',['id'=>@$data->id])}}" class="btn  btn-primary add-tasks removehref" Title="Add Task"> <span class="glyphicon glyphicon-plus"></span> Add New Task</a>             
                                          </td>
                                        </tr>
                                  </table>
                          </div>
                    </div>
                </div>
            </div>
      </div>

      <div class="panel panel-default margin15 margintop5per">
        <div class="panel-heading">Linked Incident</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12" id="ajaxresp">
                          <div class="table-responsive">
                                <table class="table" id="printTable">
                                      <tr>
                                        <th>{{_i('Title')}}</th>
                                        <th>Description</th>
                                        <th>Date & Time</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                      </tr>
                                      @if( !empty($data->reportIncident) && (count($data->reportIncident)>0))                         
                                          @foreach($data->reportIncident as $k=>$row)
                                              <tr>
                                                <td>{{ wordwrap($row->incident->title, 20, "\n", true)}}</td>
                                                <td>{{wordwrap($row->incident->description, 20, "\n", true)}}</td>
                                                <td>{{date("F j, Y", strtotime($row->incident->incident_datetime))}}</td>
                                                <td>{{$row->incident->incidentType->type}}</td>
                                                <td><form class="form-horizontal" id="frm_{{$row->incident->id}}" action="{{route('admin-linkincidentToCaseAction')}}" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden"  value="{{$row->incident->id}}" name="incidentid">
                                                <input type="hidden" value="{{$data->id}}" name="caseid[]">
                                                <input type="hidden" value="{{ 'admin-editCase' }}" name="returnUrl">

                                                <input type="submit" name="caseunlink"id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected Incident to Case ?')">
                                                </form>
                                                </td>
                                              </tr>                            
                                           @endforeach
                                        @else
                                        <tr class="bg-info">
                                            <td colspan="8">Record(s) not found.</td>
                                        </tr>
                                        @endif

                                         <td colspan="7">
                                          <a href="{{route('admin-ajaxAddNewIncident',['id'=>@$data->id])}}" class="btn  btn-primary add-tasks removehref" Title="Add New Incident"> <span class="glyphicon glyphicon-plus"></span> Add New Incident</a> 
                                          
                                          <!--<a href="javascript:case_link_incident_modal({{ $data->id}}, '{{route('admin-ajaxGetIncidentDetailsWithCase')}}');" class="btn  btn-primary add-tasks" Title="Link Incidents"> Link</a>-->
                                          <a id="addrow" href="{{route('admin-linkreportToIncident',['id'=>@$data->id,'type'=>'case'])}}" class="removehref btn btn-primary " title="Add Incident">Link</a></td>
                                        </tr>
                                  </table>
                          </div>
                    </div>
                </div>
            </div>
      </div>

     
  @endif


       </div> 
      </div>
<style>
    .error{
        color:red;
    }
</style>
<script src="{{asset('js/tasklist.js')}}"></script>
<!-- @if(Session::get('user_role_id')<=4)
<script>
  $("input").prop("disabled", true);
  $(".removehref").attr("disabled","disabled").removeAttr('href');;
  $("select").attr("disabled","disabled");
 </script> 
 @endif -->
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


    $(".checkimagesize").click(function(){
      var defaultSpace  = $('#defaultSpace').val();
      //alert(defaultSpace);
        var fileUpload = document.getElementById("default_pic");
        if (typeof (fileUpload.files) != "undefined") {
            var size = parseFloat(fileUpload.files[0].size / 1024000).toFixed(3);
            //alert(size + " MB.");
          
          if(parseFloat(defaultSpace) >= size)
          {
            return true;
          }else{
            $('#sizestatuserror').html('<span class="error">You don`t have too much storage space in your account to upload this file.</span>');
            return false;            
          }
        } else {
            alert("This browser does not support HTML5.");
        }
    });
</script>
  @endsection