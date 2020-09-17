@extends('layout.backened.header')
@section('content')


<?php 
//echo $data['caseList']->account_id;
//dd($data); 
//dd($data['sectorListByAccount']);

 //dd($data['getAllSectorByCaseId']);
$linkedtype='case';                    
?> 
<!-- START Datatable -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<!-- END Datatable -->
<link rel="stylesheet" href="{{asset('css/popupModal.css')}}">

<!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- <script src="js/jquery.js"></script> -->
<!-- Start Datatable -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/amstockchart/3.13.0/exporting/rgbcolor.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/canvg/1.5/canvg.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script> 
<!-- End Datatable -->
<!-- <script src="js/bootstrap.min.js"></script> -->


<!-- Trigger the modal with a button -->
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>


<!-- Modal HTML -->
<div class="modal" id="add-sector" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add New Sector</h4>
      </div>
      <form role="form" name="addSectorForm" id="addSectorForm" method="post">
        <div class="modal-body">
          <div class="form-group">
            Sector Name: 
            <input id="sector_name" name="sector_name" type="text">
            <input type="hidden" name="account_id" value="<?php echo $data['caseList']->account_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $data['caseList']->user_id; ?>">
            <input type="hidden" name="case_id" id="modalCaseId" value="<?php echo $data['caseList']->id; ?>">
            <!-- <p class="help-block">Files up to 5Mb only.</p> -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveSector">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="sectorDetails">

</div>
<div id="descriptionDetails">

</div>

<div id="galleryDetails">

</div>
<div id="factorgalleryDetails">

</div>

<div class="clearfix"></div>
<div class="section" id="printcontent">
	<div class="container">



    <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;}</style> 

     <div class="clearfix targetwrap" style="text-align:center">

             <?php

             $rank_sum = 0; 
             $total_rank_data = count($data['getAllSectorByCaseId']);
             $avg_rank = 0;
             if($total_rank_data>0){

              foreach($data['getAllSectorByCaseId'] as $row) {
                $rank_sum = $rank_sum+ $row->rank_id;
              }  
            }
            if($total_rank_data>0){
              $avg_rank = $rank_sum / $total_rank_data;
            }

            ?>
            <h2>Summary Rank : <?php echo number_format($avg_rank,2); ?>/10</h2></div>  
    <div class="row">

      <div class="col-sm-12 btns-grp">

      <form class="" id="add-case-form" action="@if(@$data['caseList']->id) {{route('admin-editCase',['id'=>@$data['caseList']->id])}} @else  {{route('admin-addCase')}} @endif" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}   
          <input type="hidden" name="description" id="description" class="form-control" placeholder="Description" value="{{old('name',@$data['caseDetails']->description)}}">
  
        <div class="spacer7"></div>               
        <div class="row">
          <div class="col-sm-2">
            <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif "">
              
              <label for="inputError" class="control-label"> Title {{redstar()}}</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{old('name',@$data['caseDetails']->title)}}">

              <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group @if($errors->first('status')) {{' has-error has-feedback'}} @endif">
              <label for="inputError" class="control-label"> Status{{redstar()}}</label>
              <select name="status" class="form-control" id="status" >
                <option value="">Select</option>
                <option @if(@$data['caseDetails']->status=='new') {{'selected'}} @endif value="new">{{_i('New')}}</option>
                <option @if(@$data['caseDetails']->status=='active') {{'selected'}} @endif value="active">{{_i('Active')}}</option>
                <option @if(@$data['caseDetails']->status=='closed') {{'selected'}} @endif value="closed">{{_i('Closed')}}</option>
                <option @if(@$data['caseDetails']->status=='archived') {{'selected'}} @endif value="archived">{{_i('Archived')}}</option>
              </select>
              <?php if(@$errors->first('status')) { ?><span class="help-block">{{@$errors->first('status')}}</span> <?php } ?>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group @if($errors->first('urgency')) {{' has-error has-feedback'}} @endif ">
              <label for="inputError" class="control-label">Urgency {{redstar()}}</label>
              <select name="urgency" class="form-control" id="urgency" >              
              <option value="">Select</option>
              <?php for($i=1;$i<6;$i++){ ?>
                <option @if(@$data['caseDetails']->urgency==$i) {{'selected'}} @endif value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php } ?>

            </select>
          </div>
          </div>
              @if(in_array($request->session()->get('user_role_id'), array(1,2,3)) ) 
                  <div class="col-sm-2">
               <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif ">
                     <label for="inputError" class="control-label"> Group{{redstar()}}</label>
                      <select name="group" class="form-control" id="group">
                            <option value="">Select</option>
                            @if(count($group)>0)
                            @foreach($group as $row) 
                            <?php 
                              $selectedClass = (isset($data['caseList']->caseGroup->group_id) && $data['caseList']->caseGroup->group_id==$row->id)?'selected':'';
                            ?>  
                            <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?> > <?php echo $row->name ?></option>
                          @endforeach
                           

                          @endif
                      </select>
                       
                    <?php if(@$errors->first('group')) { ?><span class="help-block">{{@$errors->first('group')}}</span> <?php } ?>
                </div>
                  </div>
               @else  
                    <input type="hidden" name="group" value="<?php echo (isset($data['caseList']->caseGroup->group_id))? $data['caseList']->caseGroup->group_id:''?>">   
                    @if(isset($data->caseGroup))        
                        <!-- <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif "> -->
                          <label for="inputError" class="control-label"> Group{{redstar()}}</label>
                          <div class="col-sm-7">
                             {{ $data->caseGroup->group->name}} 
                          </div>
                        <!-- </div> -->
                    @endif 
                 
               @endif

       <!--  <div class="col-sm-4">
          <div class="form-group">
            <div class="clearfix targetwrap" style="text-align:center">

             <?php

             $rank_sum = 0; 
             $total_rank_data = count($data['getAllSectorByCaseId']);
             $avg_rank = 0;
             if($total_rank_data>0){

              foreach($data['getAllSectorByCaseId'] as $row) {
                $rank_sum = $rank_sum+ $row->rank_id;
              }  
            }
            if($total_rank_data>0){
              $avg_rank = $rank_sum / $total_rank_data;
            }

            ?>
            <h2>Summary Rank : <?php echo number_format($avg_rank,2); ?>/10</h2></div>
          </div>
        </div>
 -->
        <div class="col-sm-2">
          <div class="form-group @if($errors->first('case_owner_id')) {{' has-error has-feedback'}} @endif">
            <label for="inputError" class="control-label">Owner List{{redstar()}}</label>
            <select name="case_owner_id1" class="form-control" id="case_owner_id1" >
              <option value="">Select</option>

              @if(count($data['userList'])>0)
              @foreach($data['userList'] as $row) 
              <?php 
              $selectedClass = (isset($data['caseDetails']->case_owner_id) && $data['caseDetails']->case_owner_id==$row->id)?'selected':'';
              ?>  
              <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->first_name.' '.$row->last_name; ?></option>
              @endforeach
              @else

              @endif

            </select> 
            <?php if(@$errors->first('case_owner_id')) { ?><span class="help-block">{{@$errors->first('case_owner_id')}}</span> <?php } ?>
          </div>
        </div>

      <input type="submit" id="add-button" value="Submit" class="btn btn-info checkimagesize" style="margin-top: 22px;">
      </div>
      <input type="hidden" name="defaultSpace" id="defaultSpace" value="{{$defaultSpace}}">
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3 col-sm-3">
      <div class="gravitor">
        <figure>
          <div class="edit">
            <?php 
            $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
            $user_role_name = Session::get('user_role_name');
            if (in_array($user_role_name, $allowRolesList))
            {
              ?>
              <a href="#" onclick="open_gallery_modal_to_update_case_image(<?php echo $data['caseList']->id; ?>, '{{route('admin-ajaxShowGallery')}}');">
                <i class="fa fa-pencil fa-lg"></i>
              <?php } else{
                ?>
                <a href="#">
                <?php } ?>
                @if(@$data['caseList']->default_pic!='')
                <img src="{{get_image_url(@$data['caseList']->default_pic,'package')}}"  class="img-responsive case_pic" >
                @else
                <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor" class="img-responsive case_pic">
                @endif
              </a></div>

            </figure>
          </div>
          </div><?php 
          $allowRolesList = array("agencySuperAdmin", "agencyAdmin", "agencyUser");
          $user_role_name = Session::get('user_role_name');
          if (in_array($user_role_name, $allowRolesList))
          {
            ?>
            <div class="col-md-9 col-sm-6" style="margin-top:44px;">
              <!--<div id="container"></div>-->
              <figcaption>  <div class="profile-image-buttons" >
               <div class="profile-image-inner-button">
                <?php if(count($data['subjectDetails'])>0){
                  $subjectId = $data['subjectDetails'][0]->id;
                  $case_id = $data['subjectDetails'][0]->case_id;

                  ?>
                  <button class="btn btn-default" style="width:100%;" onclick="open_subject_modal(<?php echo $subjectId; ?>, <?php echo $case_id; ?>, '{{route('admin-ajaxGetSubjectDetails')}}', '{{route('admin-ajaxAssignSubjectDetails')}}');">View Subject</button>
                  <?php 
                }else{
                  ?>
                  <button class="btn btn-default" id="addSubject"  data-link1="{{route('admin-ajaxGetSubjectDetails')}}" data-link2="{{route('admin-ajaxAssignSubjectDetails')}}" style="width:100%;">Subject</button>
                  <?php
                } ?>

              </div> 
              <div class="profile-image-inner-button-right">




               <?php if(count($data['targetDetails'])>0){
                $targetId = $data['targetDetails'][0]->id;
                $case_id = $data['targetDetails'][0]->case_id;
                ?>
                <button class="btn btn-default" style="width:100%" onclick="open_target_modal(<?php echo $targetId; ?>, <?php echo $case_id; ?>, '{{route('admin-ajaxGetTargetDetails')}}', '{{route('admin-ajaxAssignTargetDetails')}}');">View Target</button> 
                <?php 
              }else{
                ?>
                <button class="btn btn-default" id="addTarget"  style="width:100%" data-link1="{{route('admin-ajaxGetTargetDetails')}}" data-link2="{{route('admin-ajaxAssignTargetDetails')}}">Target</button>


                <?php
              } ?>
            </div>
          </div>
        </figcaption>
        <figcaption>
         <div class="profile-image-buttons" >
           <div class="profile-image-inner-button">
            <?php if(count($data['fileDetails'])>0){
              $fileId = $data['fileDetails'][0]->id;
              $case_id = $data['fileDetails'][0]->case_id;

              ?>
              <button class="btn btn-default" style="width:100%" onclick="open_file_modal(<?php echo $fileId; ?>, <?php echo $case_id; ?>, '{{route('admin-ajaxGetFileDetails')}}', '{{route('admin-ajaxAssignFileDetails')}}');">Files</button>
              <?php 
            }else{
              ?>
              <button class="btn btn-default" style="width:100%" id="addFile"  data-link1="{{route('admin-ajaxGetFileDetails')}}" data-link2="{{route('admin-ajaxAssignFileDetails')}}">Files</button>
              <?php
            } ?></div>
            <div class="profile-image-inner-button-right">
             <a href="{{route('admin-download-case-pdf-caseList',['id'=>@$data['caseList']->id])}}" class="btn btn-default" style="width:100%">Generate PDF</a>
           </div>
         </div>
       </figcaption>
       <figcaption>
        <div class="profile-image-buttons" >
         <div class="profile-image-inner-button" style="margin-bottom:5px;"><button class="btn btn-warning addTask" style="width:100%;" >Add Task</button></div> <div class="profile-image-inner-button-right"><button class="btn btn-info" style="width:100%"  id="addBt">Add Factor</button></div>
       </div>
     </figcaption>

 <figcaption>
      <div class="profile-image-buttons" >
         <div class="profile-image-inner-button" style="margin-bottom:5px;">
          <button class="btn btn-default" id="addDescription"  data-link1="{{route('admin-ajaxGetDescriptionDetails')}}"  style="width:100%;">Description</button>
         </div>
     </div>
   </figcaption>
 </div>  
<?php }?>
</div>

<div class="row" style="margin-top:20px;">

  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading"> Target Chart </div>
      <div class="panel-body">
       <div id="container"></div>
     </div>
   </div> 
 </div>
</div>
<div class="row" id="target-chart">

  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">Time Line Chart </div>
      <div class="panel-body">
        <div class="panelDiv">
          Chart Type:
          <select id="chart_type">
            <option value="">Please Select</option>
            <option value="scatter">Polar Scatter</option>
            <option value="area">Area</option>
            <option value="line">Line</option>
          </select>
        </div>
        <div id="timeLineContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      </div>
    </div> 

  </div>

</div>
<?php 
$user_role_name = Session::get('user_role_name');
?>
<div class="draggable"> 
  <div class="sortableList">
    <div class="panel panel-default">
      <div class="panel-heading">Tasks</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-12" id="ajaxresp">
            <div class="table-responsive">
              <table id="taskList" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>{{_i('Title')}}</th>
                    <th>Assign To</th>
                    <th>{{_i('Due Date')}}</th>
                    <th>Status</th> 
                    <th>{{_i('Created Date')}}</th>                                
                    <th>{{_i('Action')}}</th> 
                  </tr>
                </thead>
                <tbody>
                  @if( !empty($data['caseDetails']->task) && (count($data['caseDetails']->task)>0))                          
                  @foreach($data['caseDetails']->task as $k=>$row)
                  @if(!empty($row->task->id))
                  <tr>
                    <td >{{$k+1}}</td>
                    <td><a href="javascript:open_change_status_task_modal({{$row->task->id}}, {{$data['caseDetails']->id}}, '{{route('admin-ajaxGetTaskDetailsChangeStatus')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="add-tasks" Title="Update Task Status">{{wordwrap($row->task->title, 20, "\n", true)}}</a>
                    </td>
                    <td>{{ @$row->task['user']['first_name'] }} &nbsp; {{ @$row->task['user']['last_name'] }}</td> 
                    <td>{{date("F j, Y", strtotime($row->task->due_date))}}</td> 
                    <td><?php echo getStatusTitle($row->task->status); ?></td>
                    <td>{{date("F j, Y", strtotime($row->task->created_at))}}</td>
                    <td><form class="form-horizontal" id="frm_{{$row->id}}" action="{{route('admin-linkcaseToTaskAction')}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" value="{{$data['caseDetails']->id}}" name="casetaskid">
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
              </tbody>
            </table>

            <div class=" pull-left">
             <a href="{{route('admin-addnewTaskCase',['id'=>@$data['caseList']->id])}}" class="btn btn-primary addTask" title="Add Task"><i class="fa fa-plus"></i> Add New Task</a>
           </div>

         </div>
       </div>
     </div>
   </div>
 </div>
 <div class="panel panel-default">
    <div class="panel-heading">Notes</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12" id="ajaxresp">
                <div class="table-responsive">
                    <div id="note_add">
                      <form action="javascript:void(0);" method="post" id="add_note_frm">
                          <div class="note_add_input_content">
                            <input type="text" placeholder="Add Note" name="add_note" class="note_add_input">
                            <input type="hidden" name="case_id" value="<?php echo $data['caseList']->id; ?>">
                          </div>
                          <div class="note_add_button">
                            <button type="submit" class="btn btn-info btn-xs action-btn">Add</button>
                          </div>
                      </form>
                    </div>
                    @if(count($data['add_note'])>0)
                    <div class="note_add_content"> 
                        <div class="note_add_message_content">  
                          @foreach($data['add_note'] as $row)  
                          <div class="note_add_message"> 
                            <div class="note_add_img">
                              @if(@$data['caseList']->default_pic!='')
                              <img src="{{get_image_url(@$data['caseList']->default_pic,'package')}}" >
                              @else
                              <img src="{{asset('images/gravitor.jpg')}}" alt="gravitor">
                              @endif
                            </div>
                            <div class="note_add_message_text"><div style=""><?php echo $row->add_note; ?></div>
                            <div class="note_add_message_text_content"><span class="note_add_case_account">Case Account: <?php echo $data['caseList']->title; ?></span><span class="note_add_note_add">Add Note.</span><span class="note_add_note_add">time: <?php if(!empty($row->modified_time)){echo date("d M, Y",strtotime($row->modified_time));} ?></span><span class="note_add_note_add">by <a href="#"><?php echo $data['userList'][0]->first_name; ?> <?php echo $data['userList'][0]->last_name; ?></a> </span></div></div></div>					
                            @endforeach
                      </div>
                    <div class="note_add_message_previous"> 
                      <div class="note_add_message_previous_content">
                          <div class="note_add_previous">
                            <a href="javascript:void(0);" id="view_previous_add_note">View previous Note</a> 
                            <a href="javascript:void(0);" id="view_previous_add_note_show" style="display:none;">Hide previous Note</a>
                          </div>
                         <?php $rowscnt=count($data['add_note']);?>
                          <div class="note_add_out">2 out of <?php echo $rowscnt;?></div>
                        </div>
                      </div>
                    </div>
              @else
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Incident</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-12" id="ajaxresp">
            <div class="table-responsive">
              <table id="incidentList" class="table table-striped table-bordered" style="width:100%">
                <thead>
                 <tr>
                  <th width="25%">{{_i('Title')}}</th>
                  <th>{{_i('Date/Time')}}</th>
                  <th>{{_i('Created TimeStamp')}}</th>
                  <th width="25%">{{_i('Incident Type')}}</th>
                  <th width="15%">{{_i('Unlink')}} </th>
                </tr>
              </thead>
              <tbody>
                @if(count($data['incidentDetails'])>0)
                @foreach($data['incidentDetails'] as $key=>$row) 
                <?php $trstyle='';	$linkchecked=''; 
                if($row->id==$row->incident_id){
                  $trstyle='btn-success';
                  $linkchecked="checked=checked";
                } 
                ?>  
                <tr>
                  <td><a target="_blank" title="view incident" href="{{route('admin-editIncident',['id'=>$row->id])}}"><?php echo $row->title; ?></a></td>

                  <td>  {{date("F j, Y H:i", strtotime($row->incident_datetime))}}</td>
                  <td> {{date("F j, Y H:i", strtotime($row->created_at))}}  </td>
                  <td> {{$row->type}}  </td>
                  <td>
                    <form class="form-horizontal"  action="{{route('admin-incident-linkto-report')}}" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}		
                      <input type="hidden" value="{{$data['caseList']->id}}" name="reportid">
                      <input type="hidden" value="case" name="linkedtype">
                      <input type="hidden" value="{{$row->id}}" name="linktoreport[]">
                      <input type="hidden"  value="{{$row->linkedid}}" name="linktoreportid[]">
                      <input type="submit" name="incidentunlink" id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected incident to {{$linkedtype}}?')">
                    </form>
                  </td>
                </tr>
                @endforeach
                @else
                @endif
              </tbody>
            </table>
            <div class=" pull-left">
              <a href="{{route('admin-ajaxAddNewIncident',['id'=>@$data['caseList']->id])}}" class="btn  btn-primary add-tasks" Title="Add New Incident"> <i class="fa fa-plus"></i> Add New Incident</a> 
              <a id="addrow" href="{{route('admin-linkreportToIncident',['id'=>@$data['caseList']->id,'type'=>'case'])}}" class="btn btn-primary " title="Add Incident">Link</a>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div> 

<!----------------------- -->


<!---------------------------- -->

<div class="panel panel-default">
  <div class="panel-heading">Factor</div>
  <div class="panel-body">
   <div class="row" id="factor-list">
    <div class="col-sm-12" id="ajaxresp">
      <div class="table-responsive">
        <table id="sectortbl" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Factor</th>
              <th>Sector</th>
              <th>Rank</th>
              <th>Target Chart Visibility</th>
              <th>Timeline Chart Visibility</th>
              <th>Occurance Date</th>
              <?php 
              if ($user_role_name!="superAdmin")
              {
                ?>
                <th style="width:15%;">Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>

            @if(count($data['getAllSectorByCaseId'])>0)
            @foreach($data['getAllSectorByCaseId'] as $row)   

            <tr>

              <td><?php echo $row->title; ?></td>
              <td><?php echo $row->sector_name; ?></td>
              <td><?php echo $row->rank_id; ?></td>
              <td><?php echo $row->target_chart_visibility; ?></td>
              <td><?php echo $row->timeline_chart_visibility; ?></td>
              <td><?php echo date("F j, Y", strtotime($row->occurance_date)); ?></td>


              <?php 
              if ($user_role_name!="superAdmin")
              {
                ?>

                <td>
                  <a href="javascript:open_factor_modal(<?php echo $row->id; ?>, <?php echo $row->case_id; ?>);" class="btn btn-info btn-xs action-btn" title ="Edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                  <a href="#" class="btn btn-danger btn-xs action-btn" onclick="delete_factor(<?php echo $row->id; ?>);" title ="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </td>
              <?php } ?>


            </tr>
            @endforeach
            @else
            @endif


          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>
</div>

</div>
</div>
</div>
<style>
.error{
  color:red;
}
</style>
<?php   $username = Session::get('first_name')." ".Session::get('last_name'); ?>
<script src="{{asset('js/tasklist.js')}}"></script> 
<script>
 var tokenval = $('meta[name="csrf-token"]').attr('content');
 $('#token').val(tokenval);


 $(document).ready(function() {

  $('#sectortbl').DataTable( {
    "order": [[ 0, "desc" ]]
  } );

  $('#taskList').DataTable( {
    "order": [[ 0, "desc" ]]
  } );
  $('#incidentList').DataTable( {
    "order": [[ 0, "desc" ]]
  } );
  


} );



 var AddDbclk = 0;
</script>

<script src="{{asset('js/script.js')}}"></script>
<script src="{{asset('js/subject.js')}}"></script>
<script src="{{asset('js/target.js')}}"></script>
<script src="{{asset('js/files.js')}}"></script>
<script src="{{asset('js/description.js')}}"></script>
<script> 
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
  return false;
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {

  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}


function set_sector(id, sector_name){

  $('#sector_id').val(id);
  $('.dropbtn').html(sector_name);


}

/* New code By Subhendu 15-05-2018 */
$(document).ready(function(){

  $('#myModal').on('hidden.bs.modal', function () {
   location.reload();
 })



  $('.addTask').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();

    open_task_modal(0, case_id);

    $('#deleteTask').hide();

  }); 

  $('#addTask').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();

    open_task_modal(0, case_id);

    $('#deleteTask').hide();

  });
  $('#view_previous_add_note').click(function(){

   $('.note_add_message_content').css('overflow','auto');
   $('#view_previous_add_note').hide();
   $('#view_previous_add_note_show').show();
 });
  $('#view_previous_add_note_show').click(function(){

   $('.note_add_message_content').css('overflow','hidden');
   $('#view_previous_add_note').show();
   $('#view_previous_add_note_show').hide();
 });


  $('#addBt').on('click', function(){

    AddDbclk = 0;
    var case_id = $('#modalCaseId').val();
                    //formatModal();
                    open_factor_modal(0, case_id);
                    $('#rank_id').val(10);
                    //$('#SectorDiv').hide();
                    $('#deleteFactor').hide();

                  });
});
</script>
<?php
$visibleSector = $data['getAllVisibleSectorByCaseId'];
$visibleFactor = $data['getAllVisibleFactorByCaseId'];

$myJsonString = json_encode($visibleFactor);
$myJsonString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonString);

 //print_r($myJsonString);


$visibleTimeLineDataList = $data['getAllVisibleTimeLineDataByCaseId'];


$myJsonStringForTimeLine = json_encode($visibleTimeLineDataList);
$myJsonStringForTimeLine = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $myJsonStringForTimeLine);

/*echo "<pre>";
print_r($visibleFactor);
echo "</pre>";*/
?>
<svg aria-hidden="true" focusable="false" style="width:0;height:0;position:absolute;">
  <linearGradient id="gradient-horizontal">
    <stop offset="0%" stop-color="var(--color-stop-1)" />
    <stop offset="50%" stop-color="var(--color-stop-2)" />
    <stop offset="100%" stop-color="var(--color-stop-3)" />
  </linearGradient>
  <linearGradient id="gradient-vertical" x2="0" y2="1">
    <stop offset="0%" stop-color="var(--color-stop-1)" />
    <stop offset="50%" stop-color="var(--color-stop-2)" />
    <stop offset="100%" stop-color="var(--color-stop-3)" />
  </linearGradient>
</svg>
<style>
.draggable {
  cursor: move; /* fallback if grab cursor is unsupported */
  cursor: grab;
  cursor: -moz-grab;
  cursor: -webkit-grab;
}

/* (Optional) Apply a "closed-hand" cursor during drag operation. --color-stop-1: #a770ef;  --color-stop-3: #fdb99b;  --color-stop-2: #cf8bf3;*/
.draggable:active { 
  cursor: grabbing;
  cursor: -moz-grabbing;
  cursor: -webkit-grabbing;
}
#gradient-horizontal {
 --color-stop-1: #aba3b3;
 --color-stop-2: #d9d4de;
 --color-stop-3: #5c5861;
 
}
#note_add{
  padding:10px;background-color: #f4f7fb;width:100%;float:left;
}
.note_add_button{
  width:6%;float:left;
}
.note_add_button button{
  width:100%;vertical-align:middle;height:41px;
}
.note_add_input_content{
  width:90%;float:left;margin-right:2%;
}
.note_add_input_content .error{
  margin-top:5px;padding-left:10px;
}
.note_add_input{
  width:100%;height:41px;padding:10px;vertical-align:middle;
}
.note_add_content{
  width:100%;float:left;
}
.note_add_message_previous{
  width:100%;float:left;background-color: #f4f7fb;
}
.note_add_message{
  margin:10px;width:99%;float:left;border-bottom:1px solid #eee;
}
.note_add_message_previous_content{
  margin:10px;float:left;width: 96%;
}
.note_add_img{
  float:left;
}
.note_add_img img{
  width:30px;height:30px;border-radius:15px;
}
.note_add_message_text_content{
  color:#999;
}
.note_add_message_content{
  height:120px;
  overflow: hidden;
}
.note_add_message_text{
  float:left;padding-left:10px;font-weight:normal;width:80%;
}
.note_add_case_account{
  font-weight:normal;font-size:11px
}
.note_add_note_add{
  padding-left:10px;font-weight:normal;font-size:11px
}
.note_add_previous{
  width:128px;float:left;font-size:11px
}
.note_add_out{
  float:right;font-weight:normal;font-size:11px
}
#gradient-vertical {
  --color-stop-1: #00c3ff;
  --color-stop-2: #77e190;
  --color-stop-3: #ffff1c;
}
/*g.highcharts-yaxis-grid path {
   fill: url(#gradient-horizontal);
    stroke: darkgray;
}
g.highcharts-xaxis-grid path{
	 fill: url(#gradient-vertical);
    stroke: darkgray;
    }*/
    .profile-image-buttons{
      width:50%;float:left;
      margin-top:5px;
    }
    figcaption{
      width:100%;float:left;margin:4px 0;
    }
    .profile-image-inner-button{
      width:48%;float:left;
    }
    .profile-image-inner-button-right{
      width:48%;float:right;
      margin-top:0px;
    }
    @media (max-width: 768px) {
      .note_add_message_previous{
        width:100%;
      }
      .note_add_button{
        width:14%
      }
      .note_add_input_content{
        width:80%;
        padding-left: 1px;
      }
      .profile-image-inner-button,.profile-image-inner-button-right{
        width:100%;float:left
      }
      .profile-image-inner-button-right{
        margin-top:5px;
      }
      .profile-image-buttons{
        width:100%;float:left;
        margin-top:5px;
      }
    }
  </style>
  <script type="text/javascript">

    function topschart(){
      Highcharts.chart('container', {
        mapNavigation: {
          enabled: false
        },
        chart: {
          polar: true,
          height: '100%',  

        },
        title: {
          text: ''
        },
        credits: {
          enabled: false
        },
        legend: {
          enabled: false
        },

        pane: {
         startAngle: 45,

         background: [{
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
            [0, '#aba3b3'],
            [1, '#d9d4de']
            ]
          },
          borderWidth: 1,
          outerRadius: '100%'
        }, {
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
            stops: [
            [0, '#aba3b3'],
            [1, '#d9d4de']


            ]
          },
          borderWidth: 10,
          outerRadius: '107%'
        }, {
          backgroundColor: {
            linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
            stops: [
            [0, '#aba3b3'],
            [1, '#d9d4de'],



            ]
          },
            // default background
          }, {
            backgroundColor: '#d9d4de',
            borderWidth: 2,
            outerRadius: '10%',
            innerRadius: '10%'
          }]
        },


        xAxis: {
          minRange: 1,
          min: 0,
          max: <?php echo count($visibleSector); ?>,
          lineColor: '#000080',
          gridLineColor: '#3c8dbc',
          gridLineWidth: 1.5,
          labels: {
            style: {
              color: '#000000',
              fontWeight: 'bold'
            }
          },
          categories: <?php echo json_encode($visibleSector); ?>
        },
        yAxis: {
          minRange: 1,
          min: 1,
          max: 11,
          tickInterval: 1,
          gridLineColor: '#d9d4de',
          reversed: true,
          labels: {
            x: 0,
            y: -10,
            style: {
              color: '#2f4f4f',
              fontWeight: 'bold'
            }
          },
          plotBands: [{

            from: 1,
            to: 10,

            color: {
              linearGradient: {
                x1: 0,
                x2: 0,
                y1: 0,
                y2: 1
              },
              stops: [
              [0, 'rgba(204,0,0,0.2)'],
              [0.5, 'rgba(0,204,0,0.2)'],
              [1, 'rgba(0,0,204,0.2)'],
              ]
            },



          }


          ]
        },
        plotOptions: {
          scatter: {
            marker: {
              symbol: "url({{asset('images/blue_star_20.png')}})",
              radius: 1,
              states: {
                hover: {
                  enabled: true,
                  lineColor: 'rgb(100,100,100)'
                }
              }
            },
            tooltip: {
              useHTML: true,
              borderRadius: 0,
              borderWidth: 1,
              borderColor: '#5CD0CD',
              shadow: false,
                    shape: 'square', // default is callout
                    style: {
                      padding: 8
                    },
                    headerFormat: '',
                    pointFormatter: function() {
        //console.log(this);
        if(this.y>8){
         var output = '<div class="area-tooltip">';
         output += '   <div class="area-tooltip-header">';
         output +=  'Multiple Factor lies on the same location.<br>';
         output +=  'Total Cluster Data: ' +this.totalClusterData + '<br>';
         output +=  '<a href="javascript:open_factor_modal('+this.factor_id+','+ this.case_id+');">Click on the  icon</a> for view details.<br>';
         output += '</div>';
         output += '</div>';
       }
       else{
        var output = '<div class="area-tooltip">';
        output += '   <div class="area-tooltip-header">';
        output +=  this.name+'</a></b> <br>Sector Name: ' +this.sector_name+'<br>Rank Id: ' + this.y + '<br>';
        output += '</div>';
        output += '</div>';
      }


      return output;
    }


  },
  states: {
    hover: {
      marker: {
        enabled: false
      }
    }
  },
  point: {
    events: {
      click: function(e) {
       ondbclick(e, this);
     }
   }
 }
}

},
series: [{
  type: 'scatter',
  data: <?php echo $myJsonString; ?>
}]
});
}
</script>
<?php //echo json_encode($visibleTimeLineDataList); ?>
<script type="text/javascript">
  $(function() {

    var settings = {
      gridLineColor: '#eee',
      lineColor: '#5CD0CD',
      lineWidth: 1,
      gradientEndColor: '#D1F3F2'
    };
    var data = <?php echo $myJsonStringForTimeLine; ?>;


    var series_type = 'area';
    $('#chart_type').on('change', function(){
      var series_type = $(this).val(), i;
      if(series_type!=""){
        drawTimeLineChart(series_type);    
      }

    }) 
    drawTimeLineChart(series_type);
    topschart();
    function drawTimeLineChart(series_type){
      Highcharts.chart('timeLineContainer', {
        chart: {
          zoomType: 'x'
        },
        title: {
          text: 'Time Line: Rank over time'
        },
        subtitle: {
          text: ''
        },
        xAxis: {
          type: 'datetime',
          labels: {
            useHTML: true,
            formatter: function() {

              return '<span class="area-xaxis-label">' + Highcharts.dateFormat('%m/%d/%Y', this.value) + '</span>';
            }
          }
        },
        yAxis: {
          title: {
            text: 'Rank'
          },
          tickInterval: 1,
          gridLineColor: settings.gridLineColor,
          labels: {
            useHTML: true,
            formatter: function() {
              return '<span class="area-yaxis-label">' + this.value + '</span>';
            }
          }
        },
        legend: {
          enabled: false
        },
        plotOptions: {
          series: {
            point: {
              events: {
                click: function(e) {
                  open_factor_modal(this.factor_id, this.case_id);

                }
              }
            }
          },
          area: {
            fillColor: {
              linearGradient: {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
              },
              stops: [
              [0, settings.gradientEndColor],
              [1, Highcharts.Color(settings.gradientEndColor).setOpacity(0).get('rgba')]
              ]
            },
            lineWidth: settings.lineWidth,
            lineColor: settings.lineColor,
            states: {
              hover: {
                lineWidth: settings.lineWidth
              }
            },
            threshold: null

          }
        },
        series: [{
          type: series_type,
          name: 'Engine LOAD',
          maxSize: 5,
          data: data,
          states: {
            hover: {
              halo: {
                size: 0
              }
            }
          }
        }],
        tooltip: {
          useHTML: true,
          borderRadius: 0,
          borderWidth: 1,
          borderColor: settings.lineColor,
          shadow: false,
    shape: 'square', // default is callout
    style: {
      padding: 8
    },
    headerFormat: '',
    pointFormatter: function() {
      //console.log(this);
      var output = '<div class="area-tooltip">';
      output += '   <div class="area-tooltip-header">';
      output += '   <span class="area-tooltip-unit">Title: ' + this.z + '</span><br>';
      output += '   <span class="area-tooltip-unit">Sector Name: ' + this.sector_name + '</span><br>';
      output += '   <span class="area-tooltip-text">Occurance Date:</span>';
      output += '   <span class="area-tooltip-date">' + this.occurance_date + '</span>';
      output += '   </div>';
      output += '   <div class="area-tooltip-footer">';
      output += '   <span class="area-tooltip-value">Rank :' + this.y + '</span>';


      output += '   </div>';
      output += '</div>';

      return output;
    }
  },
  navigation: {
    buttonOptions: {
      enabled: false
    }
  },
  credits: false



});
    }

    var replaceSVGwithCanvas = function(callback) {
  //find all svg elements in $container
  var $container = $('#container');
  //$container is the jQuery object of the div that you need to convert to image. This div may contain highcharts along with other child divs, etc
  var svgElements = $container.find('svg');
  svgElements.each(function() {
    var canvas, xml;
    canvas = document.createElement("canvas");
    canvas.className = "screenShotTempCanvas";
    //convert SVG into a XML string
    xml = (new XMLSerializer()).serializeToString(this);
    // Removing the name space as IE throws an error
    xml = xml.replace(/xmlns=\"http:\/\/www\.w3\.org\/2000\/svg\"/, '');
    //draw the SVG onto a canvas
    canvg(canvas, xml);
    $(canvas).insertAfter(this);
    $(this).hide();
  });
  callback(); //to be called after the process in finished
};
function startPrintProcess(canvasObj, fileName, callback) {
  var pdf = new jsPDF('l', 'pt', 'a4'),
  pdfConf = {
    pagesplit: false,
    background: '#fff'
  };
  document.body.appendChild(canvasObj); //appendChild is required for html to add page in pdf
  pdf.addHTML(canvasObj, 0, 0, pdfConf, function() {
    document.body.removeChild(canvasObj);
    pdf.addPage();
    pdf.save(fileName + '.pdf');
    callback();
  });
}

$("#genPDF").click(function(){ 
		/*replaceSVGwithCanvas(function onComplete() {
  html2canvas(document.getElementById('printcontent'), {
    onrendered: function(canvasObj) {
      startPrintProcess(canvasObj, 'printedPDF',function (){
        alert('PDF saved');
      });
      //save this object to the pdf
    }
  });
});*/
			/*var options = {
				background:"#ffffff",
				pagesplit: true,
				width: '1200',
				height: '1500'
				};
			var pdf = new jsPDF('p', 'pt', 'a4');
			var wih = $("#printcontent").width();
			 $("#printcontent").css('width','1200px');
			// loadCSS("{{ asset('/css_new/style2.css')}}");
			 pdf.setProperties({
				title: '<?php echo $data['caseList']->title; ?>',
				subject: '<?php echo $data['caseList']->title; ?>',
				author: '<?php echo $username; ?>',
				keywords: 'Case detail',
				creator: 'Threat Assessment'
			});
			pdf.addHTML($("#printcontent"),options, function() {
				pdf.output('save','Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
				//pdf.save('save','Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
			});*/
			// loadCSS("{{ asset('/css_new/style.css')}}");
			
			var element = document.getElementById('printcontent');

			var pdf = new jsPDF('p', 'pt', 'a4');
			pdf.internal.scaleFactor = 3.75;

			var w = element.clientWidth;
			var h = element.clientHeight;
			var newCanvas = document.createElement('canvas');
			newCanvas.width = w * 2; 
			newCanvas.height = h * 2;
			newCanvas.style.width = w + 'px';
			newCanvas.style.height = h + 'px';
			var context = newCanvas.getContext('2d');
			context.scale(2, 2);
      var elementHandler = {
        '#ignorePDF' : function(element, renderer) {
          return true;
        }
      };
			//var contanturl="<img src="+iimage('container')+">";
			//var timelinecontanturl="<img src="+iimage('timeLineContainer')+">";
			//$('#container').html(contanturl);
			//$('#timeLineContainer').html(timelinecontanturl);
      pdf.setProperties({
        title: '<?php echo $data['caseList']->title; ?>',
        subject: '<?php echo $data['caseList']->title; ?>',
        author: '<?php echo $username; ?>',
        keywords: 'Case detail',
        creator: '<?php echo $username; ?>'
      });
		//	pdf.fromHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler});
		/*pdf.addHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
				// var out = pdf.output('dataurlnewwindow'); // crashed if bigger file
				pdf.save('Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
			});*/
			var series_type = 'area';
			//drawTimeLineChart(series_type);
			//topschart();  /* 
			var msie = document.documentMode;

      if (!isNaN(msie) && msie < 12) {
  // code for IE < 12

  var tempSVG = $('#timeLineContainer').highcharts().container.innerHTML;
  var canvas11 = document.createElement('canvas');

  canvg(canvas11, tempSVG);
  var dataUrl = canvas11.toDataURL('image/JPEG');

  pdf.addImage(dataUrl, 'JPEG', 20, 300, 560, 350);

                /*var source2 = document.getElementById("container");
                pdf.fromHTML(source2, 15, 650, {
                    'width' : 560,
                    'elementHandlers' : elementHandler
                  });*/

                  setTimeout(function() {
                    pdf.fromHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
				// var out = pdf.output('dataurlnewwindow'); // crashed if bigger file
				//pdf.save('Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
			});
                  }, 2000);

                } else {

                  var svg = document.querySelector('#container svg');
                  var width = $('#container').find('svg').width();
                  var height = $('#container').find('svg').height();
                  var canvas = document.createElement('canvas');
                  var ctx = canvas.getContext('2d');
                  var DOMURL = window.URL || window.webkitURL || window;
                  var data = (new XMLSerializer()).serializeToString(svg);

                  var img = new Image();
                  var svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
                  var url = DOMURL.createObjectURL(svgBlob);

                  var svg2 = document.querySelector('#timeLineContainer svg');
                  var width2 = $('#timeLineContainer').find('svg').width();
                  var height2 = $('#timeLineContainer').find('svg').height();
                  var canvas2 = document.createElement('canvas');
                  var ctx2 = canvas2.getContext('2d');
                  var DOMURL2 = window.URL || window.webkitURL || window;
                  var data2 = (new XMLSerializer()).serializeToString(svg2);

                  var img2 = new Image();
                  var svgBlob2 = new Blob([data2], {type: 'image/svg+xml;charset=utf-8'});
                  var url2 = DOMURL2.createObjectURL(svgBlob2);

                  img.onload = function () {
                    ctx.canvas.width = width;
                    ctx.canvas.height = height;
                    ctx.drawImage(img, 0, 0, width, height);
                    DOMURL.revokeObjectURL(url);

                    var dataUrl = canvas.toDataURL('image/jpeg');
                    var contanturl="<img src="+dataUrl+">";
                    $('#container').html(contanturl);
                  };
                  img.src = url;
                  img2.onload = function () {
                    ctx2.canvas.width = width2;
                    ctx2.canvas.height = height2;
                    ctx2.drawImage(img2, 0, 0, width2, height2);
                    DOMURL2.revokeObjectURL(url2);

                    var dataUrl2 = canvas2.toDataURL('image/jpeg');
                    var timelinecontanturl="<img src="+dataUrl2+">";
                    $('#timeLineContainer').html(timelinecontanturl);
                    setTimeout(function() {
                     $("#printcontent").css('width','1200px');
                     $("#target-chart").css('margin-top','100px');
                     pdf.addHTML(element, {pagesplit: true, background:"#ffffff",canvas: newCanvas,'elementHandlers' : elementHandler}, function () {
				// var out = pdf.output('dataurlnewwindow'); // crashed if bigger file
				pdf.save('Case-Detail-<?php echo $data['caseList']->title; ?>.pdf');
				
				var series_type = 'area';
       drawTimeLineChart(series_type);
       topschart(); 
       $("#target-chart").css('margin-top','0px');
       $("#printcontent").css('width','auto');
     });
                   }, 2000);

                  };
                  img2.src = url2;
				  //pdf.addImage(dataUrl, 'JPEG', 20, 300, 560, 350);

					/*	var source2 = document.getElementById("container");
						pdf.fromHTML(source2, 15, 650, {
							'width' : 560,
							'elementHandlers' : elementHandler
						});*/

						


         }
				/* var doc = new jsPDF('portrait', 'pt', 'a4', true);
    var elementHandler = {
      '#ignorePDF': function(element, renderer) {
        return true;
      }
    };

    var source = document.getElementById("printcontent");
    doc.fromHTML(source, 15, 15, {
      'width': 560,
      'elementHandlers': elementHandler
    });

    var svg = document.querySelector('svg');
    var canvas = document.createElement('canvas');
    var canvasIE = document.createElement('canvas');
    var context = canvas.getContext('2d');
   
   
   
   
    var data = (new XMLSerializer()).serializeToString(svg);
    canvg(canvas, data);
    var svgBlob = new Blob([data], {
      type: 'image/svg+xml;charset=utf-8'
    });

    var url = DOMURL.createObjectURL(svgBlob);

    var img = new Image();
    img.onload = function() {
      context.canvas.width = $('#timeLineContainer').find('svg').width();;
      context.canvas.height = $('#timeLineContainer').find('svg').height();;
      context.drawImage(img, 0, 0);
      // freeing up the memory as image is drawn to canvas
      DOMURL.revokeObjectURL(url);
      
      var dataUrl;
						if (isIEBrowser()) { // Check of IE browser 
							var svg = $('#timeLineContainer').highcharts().container.innerHTML;
							canvg(canvasIE, svg);
							dataUrl = canvasIE.toDataURL('image/JPEG');
						}
						else{
							dataUrl = canvas.toDataURL('image/jpeg');
						}
      doc.addImage(dataUrl, 'JPEG', 20, 300, 560, 350);

      var bottomContent = document.getElementById("printcontent");
      doc.fromHTML(bottomContent, 15, 650, {
        'width': 560,
        'elementHandlers': elementHandler
      });

      setTimeout(function() {
        doc.save('TestChart.pdf');
      }, 2000);
    };
    img.src = url;*/
  });
loadCSS = function(href) {
  var cssLink = $("<link rel='stylesheet' type='text/css' href='"+href+"'>");
  $("head").append(cssLink); 
};

});


</script>

<script type="text/javascript">
     // the actual callback for a double-click event
     var ondbclick = function(e, point) {

		//alert(point.factor_id+'-----------'+point.case_id);
    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetFactorDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:point.factor_id,case_id:point.case_id 
                    },
                    beforeSend: function() {
						// setting a timeout
						
					},
          success: function (data) {


            $('#sectorDetails').html(data);
            $('#modalBt').trigger('click');

                    //editSectorDetails(point.factor_id);

                  }
                });

    function editSectorDetails(factor_id){


      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxAssignFactorDetails')}}",
        dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:factor_id
                    },
                    success: function (data) {

                    // Parse the data as json
                    var obj = JSON.parse(data)

                    
                    $('#title').val(obj.title);
                    $('#description').val(obj.description);
                    $('#source').val(obj.source);
                    $('#occurance_date').val(obj.occurance_date);
                    $('#rank_id').val(obj.rank_id);
                    $('#sector_id').val(obj.sector_id);
                    $('.factorClass').val(obj.factor_id);
                    $('.dropbtn').html(obj.sector_name);
                    

                    if(obj.target_chart_visibility=="y"){
                      $('#target_chart_visibility').prop( "checked", true);
                    }
                    else{
                      $('#target_chart_visibility').prop( "checked", false);
                    }

                    if(obj.timeline_chart_visibility=="y"){
                      $('#timeline_chart_visibility').prop( "checked", true);
                    }
                    else{
                      $('#timeline_chart_visibility').prop( "checked", false);
                    }

                  }
                });

    }

  };



  function open_task_modal(task_id, case_id){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id,case_id:case_id 
                    },
                    success: function (data) {


                      $('#sectorDetails').html(data);
                      $('#modalBt').trigger('click');

                      editTaskDetails(task_id);


                    }
                  });

  }



  function add_note(case_id, add_note){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      add_note:add_note,case_id:case_id 
                    },
                    success: function (data) {


                      $('#sectorDetails').html(data);
                      $('#modalBt').trigger('click');


                    }
                  });

  }

  $('#add_note_frm').validate({
    ignore: ".ignore",
    rules: {

      add_note:'required'
    },
            // Specify validation error messages
            messages: {


              add_note: "Please enter Note."
            },
            // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      var sdata = new FormData(form);
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxSaveAddNote')}}",
                   // dataType: 'html',
                   data:sdata,
                   success: function (response) {
                    //result=html.split('#');
                    $('#ajaxresp').html(response);
                    $('#myModal').modal('hide');
                    location.reload();

                  },
                  cache: false,
                  contentType: false,
                  processData: false
                });

    }

  });

  function editTaskDetails(task_id){


    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxAssignTaskDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      task_id:task_id
                    },
                    success: function (data) {

                    // Parse the data as json
                    var obj = JSON.parse(data)

                    
                    $('#title').val(obj.title);
                    $('#description').val(obj.description);
                    $('#status').val(obj.status);
                    $('#task_assigned').val(obj.task_assigned);
                    $('#due_date').val(obj.due_date);
                    $('#task_id').val(task_id);
                    

                  }
                });

  }


  function open_factor_modal(factor_id, case_id){

    $.ajax({
      type: "POST",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{route('admin-ajaxGetFactorDetails')}}",
      dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      factor_id:factor_id,case_id:case_id 
                    },
                    success: function (data) {

                      $('#sectorDetails').html(data);
                      $('.modal-backdrop').remove();
                      $('#modalBt').trigger('click');
                       // editSectorDetails(factor_id);

                     }
                   });

  }


  function delete_factor(factor_id){

    var r = confirm("Are you sure you want to delete ?");
    if (r == true) {
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxDeleteFactor')}}",
        dataType: 'html',
        data: {
          token : $('meta[name="csrf-token"]').attr('content'), 
          factor_id:factor_id},
          success: function (html) {
            $('#myModal').modal('hide');
            location.reload();
          }
        });
    }
  }


  function delete_task(task_id){

    var r = confirm("Are you sure you want to delete ?");
    if (r == true) {
      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{route('admin-ajaxDeleteTask')}}",
        dataType: 'html',
        data: {
          token : $('meta[name="csrf-token"]').attr('content'), 
          task_id:task_id},
          success: function (html) {
            $('#myModal').modal('hide');
            location.reload();
          }
        });
    }
  }




</script>
<script>



 var open_gallery_modal_to_update_case_image = function(case_id, link1) {
  $('#operation_type').val("change_case_image");
  $.ajax({
    type: "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: link1,
    dataType: 'html',
                    data: {// change data to this object
                      token : $('meta[name="csrf-token"]').attr('content'), 
                      case_id:case_id 
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