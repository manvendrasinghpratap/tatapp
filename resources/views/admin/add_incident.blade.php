@extends('layout.backened.header')
@section('content')
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
<div id="sectorDetails"></div>
<div class="clearfix"></div>
 <div class="section" >
	<div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3 class="paddingbottom10px">@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Incident</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{_('Home')}}</a></li>
        <li class="active">@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Incident</li>
      </ol>
    </section>
  <style>.bootstrap-timepicker-widget.dropdown-menu.open {margin-left: 17%;} </style>   
  <script type="text/javascript"> 
    $( document ).ready(function() {
        $('#add-case-form').validate({
            ignore: ".ignore",
            rules: {
                 title: {
                  required: true,
                    
                },
                description: {
                  required: true,
                    
                },            
				incidentdatetimepicker:"required",
				date_of_report:"required",
				type:"required",
                group:"required"               
            },
            
        });
    });

  
</script>


 <!-- Modal HTML -->
     <!-- <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Add New Incident Type </h4>
                </div>
                <form class="form-horizontal" role="form" name="addIncidentTypeForm" id="addIncidentTypeForm" method="post">
                <div class="modal-body ">
				<div class="box-body">
					<div class="form-group">
						  <label for="inputError" class="col-sm-4 control-label"> Incident Type</label>
						  <div class="col-sm-6">
							  <input type="text" name="incident_type_name" id="incident_type_name" class="form-control" placeholder="Type of Incident" value="">
							
						  </div>
					</div>
					<div class="form-group">
						  <label for="inputError" class="col-sm-4 control-label"> Incident Description</label>
						  <div class="col-sm-6">
							  
							  <textarea class="form-control" id="incident_type_desc" name="incident_type_desc" placeholder="Incident Description"></textarea>
						  </div>
					</div>
				   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveIncidentType">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>  -->
 <!-- End of model popup -->
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
           
            <form class="" id="add-case-form" action="@if(@$data->id) {{route('admin-editIncident',['id'=>@$data->id])}} @else  {{route('admin-addIncident')}} @endif" method="POST" enctype="multipart/form-data" >
            {{ csrf_field() }}
         
              <div class="box-body">
              <input type="hidden" name="id" value="{{old('id',@$data->id)}}">
                <div class="form-group row @if($errors->first('title')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Title {{redstar()}}</label>
                  <div class="col-sm-9">
                      <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{old('name',@$data->title)}}">
                    <?php if(@$errors->first('title')) { ?><span class="help-block">{{@$errors->first('title')}}</span> <?php } ?>
                  </div>
                </div>

                 <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Description {{redstar()}}</label>
                  <div class="col-sm-9">
				  <textarea name="description" placeholder="Description" id="description" class="md-textarea form-control" rows="3" >{{old('name',@$data->description)}}</textarea>
                    <?php if(@$errors->first('description')) { ?><span class="help-block">{{@$errors->first('description')}}</span> <?php } ?>
                  </div>
                </div>
				
				 <div class="form-group row @if($errors->first('description')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Select Date/Time {{redstar()}}</label>
                  <div class="col-sm-6">
                    
						
						<div class="input-group date datetimepicker1" >
						
                <input type="text"  id="incidentdatetimepicker" name="incidentdatetimepicker" class="form-control datetimepicker1" style="" value="">
                <span class="input-group-addon " style=""><i class="fa fa-calendar "></i></span>
              </div>
						
					<?php
					$incdatetime='';
					if(@$data->incident_datetime){
						$incdatetime=date('m/d/Y H:i',strtotime(@$data->incident_datetime));
					}
					$date_of_report='';
					if(@$data->date_of_report){
						$date_of_report=date('m/d/Y H:i',strtotime(@$data->date_of_report));
					}
					
					?>
					<script type="text/javascript">
					var dd2 = "<?php if($incdatetime){
						echo date('m/d/Y H:i',strtotime(@$data->incident_datetime));
					}
					else{
						
						echo  date('m/d/Y H:i');
					}
					
					?>";
					var dd3 = "<?php if($date_of_report){
						echo date('m/d/Y H:i',strtotime(@$data->date_of_report));
					}
					else{
						
						echo  date('m/d/Y H:i');
					}
					
					?>";
						$(function () {
							$('.datetimepicker1').datetimepicker({
							 defaultDate:  new Date(dd2),
								 //else return new Date();
							useCurrent:false,
							});
							$('.datetimepicker2').datetimepicker({
							 defaultDate:  new Date(dd3),
								 //else return new Date();
							useCurrent:false,
							});
							
 $(".dyncDataTable .add_more_records").on("click", function () {
		
        var cols = '<div class="dyncDataTableRow"><input type="text" name="victim_name_and_contact_info[victim_name][]" id="victim_name" class="form-control add_more_text" placeholder="Victim Name" value="">';
		cols += '<textarea name="victim_name_and_contact_info[contact_info][]" placeholder="Contact Info" id="victim_name_and_contact_info" class="md-textarea form-control add_more_text" rows="3"></textarea>';
        cols += '<input type="button" style="width:9%" class="ibtnDelRow btn btn-md btn-danger"  value="-">';
		cols += '</div>';
		
       // newRow.append(cols);
        $(this).closest(".dyncDataTable").append(cols);
    });
 $(".dyncDataTable2 .add_more_records").on("click", function () {
		
        var cols = '<div class="dyncDataTableRow"><input type="text" name="persons_of_concern_name_and_contact_info[person_name][]" id="person_name" class="form-control add_more_text" placeholder="Person Name" value="">';
		cols +=  '<textarea name="persons_of_concern_name_and_contact_info[contact_info][]" placeholder="Contact Info" id="persons_of_concern_name_and_contact_info" class="md-textarea form-control add_more_text" rows="3"></textarea>';
        cols += '<input type="button" style="width:9%" class="ibtnDelRow btn btn-md btn-danger"  value="-">';
		cols += '</div>';
		
       // newRow.append(cols);
        $(this).closest(".dyncDataTable2").append(cols);
    });
 $(".dyncDataTable3 .add_more_records").on("click", function () {
		
        var cols = '<div class="dyncDataTableRow"><input type="text" name="witnesses_names_and_contact_info[witness_name][]" id="witness_name" class="form-control add_more_text" placeholder="Witness Name" value="">';
		cols += '<textarea name="witnesses_names_and_contact_info[contact_info][]" placeholder="Contact Info" id="witnesses_names_and_contact_info" class="md-textarea form-control add_more_text" rows="3"></textarea>';
		cols += '<input type="button" style="width:9%" class="ibtnDelRow btn btn-md btn-danger"  value="-">';
		cols += '</div>';
		
       // newRow.append(cols);
        $(this).closest(".dyncDataTable3").append(cols);
    });
	
	 $(".dyncDataTable").on("click", ".ibtnDelRow", function (event) {
        $(this).closest(".dyncDataTableRow").remove();  
    });
	 $(".dyncDataTable2").on("click", ".ibtnDelRow", function (event) {
        $(this).closest(".dyncDataTableRow").remove();  
    });
	 $(".dyncDataTable3").on("click", ".ibtnDelRow", function (event) {
        $(this).closest(".dyncDataTableRow").remove();  
    });
						});
					</script>
                  </div>
				  
				  
				 
                </div>
				
		

              

                 
                  <div class="form-group row @if($errors->first('type')) {{' has-error has-feedback'}} @endif ">
                    <label for="inputError" class="col-sm-3 control-label">Incident Type{{redstar()}}</label>
                        <div class="col-sm-9">
                          <select name="type" class="form-control" id="type">
                            <option value="">Select</option>
                                @if(count($incident_type)>0)
                                        @foreach($incident_type as $row) 
                                        <?php 
                                            $selectedClass = (isset($data->type) && $data->type==$row->id)?'selected':'';
                                        ?>  
                                        <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->type ?></option>
                                    @endforeach
                            @endif
                          </select>
                            <?php if(@$errors->first('type')) { ?><span class="help-block">{{@$errors->first('type')}}</span> <?php } ?>
						<br/>
							<!-- Trigger the modal with a button -->
      <!--  <button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add New Incident Type</button>-->
		
					    <h5 id="incidentTypeMsg"></h5>
                    </div>
				
                  </div>

                   @if(in_array($request->session()->get('user_role_id'), array(1,2,3,4)) )      
                  <div class="form-group row @if($errors->first('type')) {{' has-error has-feedback'}} @endif ">
                        <label for="inputError" class="col-sm-3 control-label">Group{{redstar()}}</label>
                        <div class="col-sm-9">
                          <select name="group" class="form-control" id="group">
                            <option value="">Select</option>
                                @if(count($group)>0)
                                      @php $selectedClass = ''; $ff = 0; @endphp
                                        @foreach($group as $row) 
                                      @php $selectedClass = '';@endphp
                                         <?php if(isset($data->incidentGroup) && ($data->incidentGroup->group_id == $row->id) && (empty($request->group_id))) {  $selectedClass = 'selected'; }?> 
                                         <?php if(isset($request->group_id) && ($request->group_id == $row->id) ) {  $selectedClass = 'selected'; }?> 
                                        <option data-longitude = '<?php echo $row->longitude; ?>' data-latitude = '<?php echo $row->latitude; ?>' value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->name ?></option>
                                    @endforeach
                            @endif
                          </select>
                            <?php if(@$errors->first('type')) { ?><span class="help-block">{{@$errors->first('type')}}</span> <?php } ?>
                    </div>				
                  </div>
                  @else  
                    <input type="hidden" name="group" value="<?php echo (isset($data->incidentGroup->group_id))? $data->incidentGroup->group_id:''?>">   
                    @if(isset($data->incidentGroup))        
                        <div class="form-group row @if($errors->first('group')) {{' has-error has-feedback'}} @endif ">
                          <label for="inputError" class="col-sm-3 control-label"> Group{{redstar()}}</label>
                          <div class="col-sm-7">
                             {{ $data->incidentGroup->group->name}} 
                          </div>
                        </div>
                    @endif 
                  @endif
				@if(@$data->id)
                 <div class="form-group row @if($errors->first('record_number')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Record Number {{redstar()}}</label>
                  <div class="col-sm-9">
                      <input type="text" name="record_number" id="record_number" class="form-control" readonly placeholder="Record Number" value="{{old('name',@$data->record_number)}}">
                    <?php if(@$errors->first('record_number')) { ?><span class="help-block">{{@$errors->first('record_number')}}</span> <?php } ?>
                  </div>
                </div>
				 @endif
				 <div class="form-group row @if($errors->first('reported_by')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Reported By {{redstar()}}</label>
                  <div class="col-sm-9">
                      <input type="text" name="reported_by" id="reported_by" class="form-control" placeholder="Reported By" value="{{old('name',@$data->title)}}">
                    <?php if(@$errors->first('reported_by')) { ?><span class="help-block">{{@$errors->first('reported_by')}}</span> <?php } ?>
                  </div>
                </div>
                   <div class="form-group row @if($errors->first('date_of_report')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Date of Report {{redstar()}}</label>
                   <div class="col-sm-3">
						<div class="input-group date datetimepicker1" >
                      <input type="text" name="date_of_report" id="date_of_report" class="form-control datetimepicker2" placeholder="Reported By" value="{{old('name',@$data->date_of_report)}}">
                <span class="input-group-addon " style=""><i class="fa fa-calendar "></i></span>
                    <?php if(@$errors->first('date_of_report')) { ?><span class="help-block">{{@$errors->first('date_of_report')}}</span> <?php } ?>
                  </div>
				  </div>
				  <div class="col-sm-3" style="margin-left: 22%; margin-top: 0%;">
                     <a href="javascript:void(0);" class="btn btn-primary btn-info-graph locationfromgraph" Title="Location from Graph">Open Map</a>  
					 </div>
                     <div id="map_canvas" style="position: absolute; width:250px; height:200px; float: left; right: 15px; margin-bottom:30px; "></div>
                </div>                  
                 <div class="form-group row @if($errors->first('location')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Location {{redstar()}}</label>
                  <div class="col-sm-5">
                  <input type="text" name="location" id="location"  readonly class="form-control" placeholder="Location with zipcode" value="{{old('name',@$data->location)}}">
                    <?php if(@$errors->first('location')) { ?><span class="help-block">{{@$errors->first('location')}}</span> <?php } ?>
                  </div> 
                </div>

                <div class="form-group row @if($errors->first('location')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Geo Co-ordinate {{redstar()}}</label> 
                      <?php if(isset($data->latitude)){ $lat = $data->latitude;}?>
                      <?php if(isset($request->latitude)){ $lat = $request->latitude;}?> 
                      <?php if(isset($data->longitude)){ $long = $data->longitude;}?>
                      <?php if(isset($request->longitude)){ $long = $request->longitude;}?>                     
                     <div class="col-sm-2">
                     <input type="text" name="latitude" id="latitude" readonly = "true" value="{{ @$long }}" readonly class="form-control small" placeholder="Latitude"><span><i>Latitude</i></span> 
                     </div>                 
                     <div class="col-sm-2">
                      
                     <input type="text" name="longitude" id="longitude" readonly = "true" value="{{ @$lat }}" readonly class="form-control" placeholder="Longitude"><span><i>Longitude</i></span>                   
                     <input type="hidden" name="place_id" id="place_id" value="{{old('name',@$data->location)}}" >   
                     </div> 
                     
                     <!-- Modal HTML -->
                     @php $lati =  '39.790725958712166'; $longi = '-104.96411679375'; $smalllocation = 'United States'; @endphp
                     @php if(!empty(@$data->latitude)) $lati = $data->latitude;  @endphp                     
                     @php if(!empty(@$data->longitude)) $longi = $data->longitude;  @endphp                     
                     @php if(!empty(@$data->location)) $smalllocation = $data->location;  @endphp                     
                     <?php $latLongArray = array('latitude'=>$lati,'longitude'=>$longi);?>
                      <!-- End of model popup -->               
                </div>
                <div style="height:530px;display:none; padding-top:76px;" class="mapdiv"> 
				<center><p class="error"><i><strong>Note:</strong> You will now be able to drag the marker to the correct position. This is done by placing your cursor over the red marker, left click and hold the mouse button down. This captures the marker and allows you to move it to the right position on the map. Once you are happy with its new position release the left button.  </i></p></center>
                    <div class="pac-card" id="pac-card">
                        <div>
                            <div id="titlemap"> Autocomplete search <span><input type="submit" id="add-button-map" value="Submit" class="btn btn-info submitmap-but"><button type="button" class="close btn btn-info" data-dismiss="modal" title="Click to Close Map" aria-hidden="true">&times;</button></span></div>
                            <div id="type-selector" class="pac-controls" style="display:none;">
                                <input type="radio" name="type1 " class="form-control" id="changetype-all" checked="checked">
                            </div>
                        </div>
                      <div id="pac-container"><input id="pac-input" type="text" class="form-control" placeholder="Enter a location" value="{{old('name',@$data->location)}}"> </div>
                    </div>
                    <div id="map"></div>
                    <div id="infowindow-content">
                      <img src="" width="16" height="16" id="place-icon">
                      <span id="place-name"  class="title"></span><br>
                      <span id="place-address"></span>                      
                    </div>
            </div>
              <div class="form-group row @if($errors->first('law_enforcement_contacted')) {{' has-error has-feedback'}} @endif ">
                <label for="inputError" class="col-sm-3 control-label"> Law Enforcement Contacted? {{redstar()}}</label>
                <div class="col-sm-9">
                    <input type="checkbox" name="law_enforcement_contacted" id="law_enforcement_contacted" placeholder="Law Enforcement Contacted"  <?php if(!empty($data->law_enforcement_contacted)){echo "checked";}?> value="1">
                  <?php if(@$errors->first('law_enforcement_contacted')) { ?><span class="help-block">{{@$errors->first('law_enforcement_contacted')}}</span> <?php } ?>
                </div>
              </div>	

				  <div class="form-group row @if($errors->first('medical_assistance_required')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Medical Assistance Required? {{redstar()}}</label>
                  <div class="col-sm-9">
                      <input type="checkbox" name="medical_assistance_required" id="medical_assistance_required" placeholder="Medical Assistance Required" <?php if(!empty($data->medical_assistance_required)){echo "checked";}?> value="1">
                    <?php if(@$errors->first('medical_assistance_required')) { ?><span class="help-block">{{@$errors->first('medical_assistance_required')}}</span> <?php } ?>
                  </div>
                </div>
				
				 <div class="form-group row @if($errors->first('follow_up_actions')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Follow up Actions {{redstar()}}</label>
                  <div class="col-sm-9">
                      <textarea name="follow_up_actions" placeholder="Follow up Actions" id="follow_up_actions" class="md-textarea form-control" rows="3" >{{old('name',@$data->follow_up_actions)}}</textarea>
                    <?php if(@$errors->first('follow_up_actions')) { ?><span class="help-block">{{@$errors->first('follow_up_actions')}}</span> <?php } ?>
                  </div>
                </div>
				
				 <div class="form-group row @if($errors->first('follow_up_actions')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Victim Name And Contact Info {{redstar()}}</label>
                  
                   <div class="col-sm-9">
				  <div class="input-group" >
                        <div class="dyncDataTable ">
				 <?php 
				 $victim_name_and_contact_info="";
				  $victim_name_and_contact_info_name="";
				 if(!empty(@$data->victim_name_and_contact_info)) { 
				 $victim_name_and_contact_info=@unserialize($data->victim_name_and_contact_info);
				 if(!empty($victim_name_and_contact_info)&& count($victim_name_and_contact_info)>0) { 
					$victim_name_and_contact_info_name=$victim_name_and_contact_info['victim_name'];
				 }
				 }
				 $count=0;
				 if(!empty($victim_name_and_contact_info_name)&& count($victim_name_and_contact_info_name)>0) { 
				 foreach($victim_name_and_contact_info_name as $value){
				 $victim_name_and_contact_info_value="";
				 if(!empty($victim_name_and_contact_info)){
					$victim_name_and_contact_info_value=$victim_name_and_contact_info;
					 if(!empty($victim_name_and_contact_info_value)&&count($victim_name_and_contact_info_value)>0){
						$victim_name_and_contact_info_victim_name=$victim_name_and_contact_info_value['victim_name'][$count];
						$victim_name_and_contact_info_contact_info=$victim_name_and_contact_info_value['contact_info'][$count];
					 }
				}
				 ?><div class="dyncDataTableRow">
				 <input type="text" name="victim_name_and_contact_info[victim_name][]" id="victim_name" class="form-control add_more_text" placeholder="Victim Name" value="{{old('name',@$victim_name_and_contact_info_victim_name)}}">
				   <textarea name="victim_name_and_contact_info[contact_info][]" placeholder="Contact Info" id="victim_name_and_contact_info" class="md-textarea form-control add_more_text" rows="3">{{old('name',@$victim_name_and_contact_info_contact_info)}}</textarea>
				   <?php if($count==0){?>
					<input type="button"  value="+" style="width:9%" class="btn btn-primary btn-info add_more_records">
					<?php }else{?>
					<input type="button" style="width:9%" class="ibtnDelRow btn btn-md btn-danger"  value="-">
					<?php }?>
                    <?php if(@$errors->first('victim_name_and_contact_info')) { ?><span class="help-block">{{@$errors->first('victim_name_and_contact_info')}}</span> <?php } ?>
					</div>
				<?php 
				$count++;
				}
				}else{?>
				<div class="dyncDataTableRow">
				<input type="text" name="victim_name_and_contact_info[victim_name][]" id="victim_name" class="form-control add_more_text" placeholder="Victim Name" value="">
				   <textarea name="victim_name_and_contact_info[contact_info][]" placeholder="Contact Info" id="victim_name_and_contact_info" class="md-textarea form-control add_more_text" rows="3"></textarea>
					<input type="button"  value="+" style="width:9%" class="btn btn-primary btn-info add_more_records">
				</div>
				<?php }?>
                <?php 
                $user_role_name = Session::get('user_role_name');
                ?>                  
                </div>
                  </div>
                </div>
				</div>
				 <div class="form-group row @if($errors->first('follow_up_actions')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Persons Of Concern Name And Contact Info {{redstar()}}</label>
                     <div class="col-sm-9">
				  <div class="input-group" >
				  <div class="dyncDataTable2 ">
				 <?php 
				 $persons_of_concern_name_and_contact_info="";
				 $persons_of_concern_name_and_contact_info_name="";
				 if(!empty(@$data->persons_of_concern_name_and_contact_info)) { 
				 $persons_of_concern_name_and_contact_info=@unserialize($data->persons_of_concern_name_and_contact_info);
				  if(!empty($persons_of_concern_name_and_contact_info)&& count($persons_of_concern_name_and_contact_info)>0) { 
					$persons_of_concern_name_and_contact_info_name=$persons_of_concern_name_and_contact_info['person_name'];
				 }
				 }
				 $count=0;
				 if(!empty($persons_of_concern_name_and_contact_info_name)&& count($persons_of_concern_name_and_contact_info_name)>0) { 
				 foreach($persons_of_concern_name_and_contact_info_name as $value){
				 $persons_of_concern_name_and_contact_info_value="";
				 if(!empty($persons_of_concern_name_and_contact_info)){
				 $persons_of_concern_name_and_contact_info_value=$persons_of_concern_name_and_contact_info;
				  if(!empty($persons_of_concern_name_and_contact_info_value)&&count($persons_of_concern_name_and_contact_info_value)>0){
						$persons_of_concern_name_and_contact_info_person_name=$persons_of_concern_name_and_contact_info_value['person_name'][$count];
						$persons_of_concern_name_and_contact_info_contact_info=$persons_of_concern_name_and_contact_info_value['contact_info'][$count];
					 }
				 }
				 ?><div class="dyncDataTableRow">
				 <input type="text" name="persons_of_concern_name_and_contact_info[person_name][]" id="person_name" class="form-control add_more_text" placeholder="Person Name" value="{{old('name',@$persons_of_concern_name_and_contact_info_person_name)}}">
				 <textarea name="persons_of_concern_name_and_contact_info[contact_info][]" placeholder="Contact Info" id="persons_of_concern_name_and_contact_info" class="md-textarea form-control add_more_text" rows="3">{{old('name',@$persons_of_concern_name_and_contact_info_contact_info)}}</textarea>				
				   <?php if($count==0){?>
					<input type="button"  value="+" style="width:9%" class="btn btn-primary btn-info add_more_records">
					<?php }else{?>
					<input type="button" style="width:9%" class="ibtnDelRow btn btn-md btn-danger"  value="-">
					<?php }?>
                    <?php if(@$errors->first('persons_of_concern_name_and_contact_info')) { ?><span class="help-block">{{@$errors->first('persons_of_concern_name_and_contact_info')}}</span> <?php } ?>
					</div>
				<?php 
				$count++;
				}
				}else{?>
				<div class="dyncDataTableRow">
				 <input type="text" name="persons_of_concern_name_and_contact_info[person_name][]" id="person_name" class="form-control add_more_text" placeholder="Person Name" value="">
				   <textarea name="persons_of_concern_name_and_contact_info[contact_info][]" placeholder="Contact Info" id="persons_of_concern_name_and_contact_info" class="md-textarea form-control add_more_text" rows="3"></textarea>	
					<input type="button"  value="+" style="width:9%" class="btn btn-primary btn-info add_more_records">
				</div>
				<?php }?>
                  </div>
                </div>
                </div>
				</div>
				 <div class="form-group row @if($errors->first('follow_up_actions')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Witnesses Names And Contact Info {{redstar()}}</label>				  
                   <div class="col-sm-9">
				  <div class="input-group" >
				  <div class="dyncDataTable3 ">
				  <?php 
				 $witnesses_names_and_contact_info="";
				 $witnesses_names_and_contact_info_name="";
				 if(!empty(@$data->witnesses_names_and_contact_info)) { 
				 $witnesses_names_and_contact_info=@unserialize($data->witnesses_names_and_contact_info);
				  if(!empty($witnesses_names_and_contact_info)&& count($witnesses_names_and_contact_info)>0) { 
					$witnesses_names_and_contact_info_name=$witnesses_names_and_contact_info['witness_name'];
				 }
				 }
				 $count=0;
				 if(!empty($witnesses_names_and_contact_info_name)&& count($witnesses_names_and_contact_info_name)>0) { 
				 foreach($witnesses_names_and_contact_info_name as $value){
				 $witnesses_names_and_contact_info_value="";
				 if(!empty($witnesses_names_and_contact_info)){
				 $witnesses_names_and_contact_info_value=$witnesses_names_and_contact_info;				 
				if(!empty($witnesses_names_and_contact_info_value)&&count($witnesses_names_and_contact_info_value)>0){
						$witnesses_names_and_contact_info_witness_name=$witnesses_names_and_contact_info_value['witness_name'][$count];
						$witnesses_names_and_contact_info_contact_info=$witnesses_names_and_contact_info_value['contact_info'][$count];
					 }
				 }
				 ?><div class="dyncDataTableRow">
				 <input type="text" name="witnesses_names_and_contact_info[witness_name][]" id="witness_name" class="form-control add_more_text" placeholder="Witness Name" value="{{old('name',@$witnesses_names_and_contact_info_witness_name)}}">			 
				   <textarea name="witnesses_names_and_contact_info[contact_info][]" placeholder="Contact Info" id="witnesses_names_and_contact_info" class="md-textarea form-control add_more_text" rows="3">{{old('name',@$witnesses_names_and_contact_info_contact_info)}}</textarea>
				   <?php if($count==0){?>
					<input type="button"  value="+" style="width:9%" class="btn btn-primary btn-info add_more_records">
					<?php }else{?>
					<input type="button" style="width:9%" class="ibtnDelRow btn btn-md btn-danger"  value="-">
					<?php }?>
                    <?php if(@$errors->first('victim_name_and_contact_info')) { ?><span class="help-block">{{@$errors->first('victim_name_and_contact_info')}}</span> <?php } ?>
					</div>
				<?php 
				$count++;
				}
				}else{?>
				<div class="dyncDataTableRow">				
				<input type="text" name="witnesses_names_and_contact_info[witness_name][]" id="witness_name" class="form-control add_more_text" placeholder="Witness Name" value="">	
				   <textarea name="witnesses_names_and_contact_info[contact_info][]" placeholder="Contact Info" id="witnesses_names_and_contact_info" class="md-textarea form-control add_more_text" rows="3"></textarea>
					<input type="button"  value="+" style="width:9%" class="btn btn-primary btn-info add_more_records">
				</div>
				<?php }?>
                  </div>
                </div>
                </div>
				</div>
                <?php 
                $user_role_name = Session::get('user_role_name');
                ?>                  
                </div>
                  </div>
                </div>           
                </div>
              <!-- /.box-body -->
              <div class="box-footer form-group row col-sm-9">
                <a href="{{route('admin-incidentList')}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info">
				@if(isset($data->id))
				
        
				
				@endif
				
				
				
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
        <!--/.col (right) -->
        </div>
         <div class="panel panel-default margin15">
    <div class="panel-heading">Linked Report</div>
    <div class="panel-body">
        

    <div class="row">
          <div class="col-sm-12" id="ajaxresp">
              <div class="table-responsive">
                    <table class="table table-hover" id="printTable">
                          <tr>
                          <th>Sr.No.</th>
                          <th width="25%">{{_i('Title')}}</th>
                          <?php
                          if ($user_role_name=="superAdmin")
                          {
                          ?>
                          <th>Account</th>
                          <?php } ?>
                          <th>Name</th>
                          <th>{{_i('Email Address')}}</th>
                          <th>{{_i('Phone No.')}}</th>
                          <th>{{_i('Created Date')}}</th>
                          <th>{{_i('Unlink')}}</th>
                          </tr>
                          @if(count($reportdata)>0)

                          @foreach($reportdata as $k=> $row)
                          <tr>
                          <td><a target="_blank"  href="{{route('admin-viewReport',['id'=>$row->id])}}">{{wordwrap($row->title, 15, "\n", true)}} </a></td>

                          <?php
                          if ($user_role_name=="superAdmin")
                          {
                          ?>
                          <td>{{wordwrap($row->account_name, 15, "\n", true)}}</td> 
                          <?php } ?>
                          <td>{{wordwrap($row->name, 15, "\n", true)}}</td>
                          <td>{{wordwrap($row->email_address, 15, "\n", true)}}</td>
                          <td>{{wordwrap($row->phone_no, 15, "\n", true)}}</td>
                          <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                          <td><form class="form-horizontal" id="frm_{{$row->id}}" action="{{route('admin-linkincidentToReportAction')}}" method="POST" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <input type="hidden"  value="{{$data->id}}" name="incidentid">
                          <input type="hidden" value="{{$row->id}}" name="reportid[]">
                          <input type="submit" name="reportunlink" id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link this Task to Incident?')">
                          </form>
                          </td>
                          </tr>
                          @endforeach
                          @else
                          <tr class="bg-info">
                          <td colspan="8">Record(s) not found.</td>
                          </tr>
                          @endif
                          @if(isset($data->id))
                          <tr>
                            <td colspan="7">
                              <a href="{{route('admin-linkincidentToReport',['id'=>@$data->id])}}" class="btn btn-info " title ="List of Related Reports"> Link Reports</span></a>
                            </td>
                          </tr>
                          @endif
                    </table>
                </div>
             </div>
       </div>
    </div>
</div>




<div class="panel panel-default margin15">
    <div class="panel-heading">Linked Case</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12" id="ajaxresp">
                      <div class="table-responsive">
                            <table class="table" id="printTable">
                                  <tr>
                                    <th>S.No</th>
                                    <th width="25%">{{_i('Title')}}</th>
                                    <th>Assign To</th>
                                    <th>{{_i('Status')}}</th>
                                    <th>{{_i('Created Date')}}</th>                                
                                    <th>{{_i('Unlink')}}</th>                                
                                  </tr>
                                  @if(count($caselistdata)>0)                          
                                      @foreach($caselistdata as $k=>$row)
                                          <tr>
                                            <td scope="row">{{$k+1}}</td>
        								                    <td><a target="_blank"  href="{{route('admin-viewCase',['id'=>$row->id])}}">{{wordwrap($row->title, 20, "\n", true)}} </a></td>
                                            <td>{{$row->CaseOwnerName[0]->first_name}}</td>
                                            <td>{{$row->status}}</td>
                                            <td>{{date("F j, Y", strtotime($row->created_at))}}</td>
                                            <td><form class="form-horizontal" id="frm_{{$row->id}}" action="{{route('admin-linkincidentToCaseAction')}}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden"  value="{{$data->id}}" name="incidentid">
                                            <input type="hidden" value="{{$row->id}}" name="caseid[]">
                                            <input type="submit" name="caseunlink"id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected case to Incident?')">
                                            </form>
                                            </td>
                                          </tr>                            
                                       @endforeach
                                    @else
                                    <tr class="bg-info">
                                        <td colspan="8">Record(s) not found.</td>
                                    </tr>
                                    @endif
                                    @if(isset($data->id))
                                    <tr>
                                    <td colspan="6">
                                    <a href="{{route('admin-linkincidentToCase',['id'=>@$data->id])}}" class="btn btn-info"> Link Cases</a>
                                    </td>
                                    </tr>
                                    @endif
                              </table>
                      </div>
                </div>
            </div>
        </div>
</div>
<div class="panel panel-default margin15">
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
                                    <th>Case </th> 
                                    <th>Status</th> 
                                    <th>{{_i('Created Date')}}</th>                                
                                    <th>{{_i('Unlink')}}</th>                                
                                  </tr>
                                  @if( !empty($data->incident) && (count($data->incident)>0))                          
                                      @foreach($data->incident as $k=>$row)
                                          <tr>
                                            <td scope="row">{{$k+1}}</td>
                                            <td><a href="javascript:open_change_status_task_modal({{$row->task->id}}, {{$data->id}}, '{{route('admin-ajaxGetTaskDetailsChangeStatus')}}','{{route('admin-ajaxAssignTaskDetails')}}');" class="add-tasks" Title="Update Task Status">{{wordwrap($row->task->title, 20, "\n", true)}}</a></td>
                                            <td>{{ @$row->task['user']['first_name'] }} &nbsp; {{ @$row->task['user']['last_name'] }}</td> 
                                            <td>{{date("F j, Y", strtotime($row->task->due_date))}}</td> 
                                            <td><?php 
                                              if(!empty(@$row->task->casetasklist)){
                                                foreach(@$row->task->casetasklist as $innerRow){
                                                  echo $innerRow->case->title.'<br>';
                                                }
                                              }
                                            ?></td>
                                            <td><?php echo getStatusTitle($row->task->status); ?></td>
                                            <td>{{date("F j, Y", strtotime($row->task->created_at))}}</td>
                                            <td><form class="form-horizontal" id="frm_{{$row->id}}" action="{{route('admin-linkincidentToTaskAction')}}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="hidden"  value="{{$data->id}}" name="incidentid">
                                            <input type="hidden" value="{{$row->task->id}}" name="taskid">
                                            <input type="submit" name="taskunlink"id="add-button" value="Un-Link" class="btn btn-info" onclick="return confirm('Are you sure you want to Un-Link selected Task to Incident?')">
                                            </form>
                                            </td>
                                          </tr>                            
                                       @endforeach
                                    @else
                                    <tr class="bg-info">
                                        <td colspan="8">Record(s) not found.</td>
                                    </tr>
                                    @endif
                                    @if(isset($data->id))
                                    <tr>
                                    <td colspan="8">
                                    <a href="{{route('admin-addnewTaskIncident',['id'=>@$data->id])}}" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Add New Task</a>
                                    </td>
                                    </tr>
                                    @endif
                              </table>
                      </div>
                </div>
            </div>
        </div>
</div>
	  
	  
	
	  <script src="{{asset('js/tasklist.js')}}"></script>
<style>
    .error{
        color:red;
    }
	.add_more_text{
	width: 40% !important;
    margin-right: 8px;
	}
	.dyncDataTableRow{
	width:100%;
	min-height:100px;
	}
</style>

        <script>
          $(document).ready(function() {
                $("input:text").keypress(function(event) {
                  if (event.keyCode == 13) {
                      event.preventDefault();
                      return false;
                  }
                });

                $( ".getcoordonate" ).click(function() {
                    var location = $('#location').val();
                        $.ajax({
                          type: "POST",
                          headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          url: "{{route('admin-ajaxtogetlatitudeandlongitude')}}",
                          dataType: 'json',
                          data: {// change data to this object
                            token: $('meta[name="csrf-token"]').attr('content'),
                            location: location
                          },
                          success: function (data) {
                            console.log(data);
                            var obj = jQuery.parseJSON( JSON.stringify(data) );
                            console.log(obj);
                            if( (obj.place_id !='') || (obj.place_id !='') || (obj.place_id !='') ){
                                $('#place_id').val(obj.place_id);
                                $('#longitude').val(obj.longitude);
                                $('#latitude').val(obj.latitude);
                                $('#latitude_').val(obj.latitude);
                                $('#longitude_').val(obj.longitude);
                            }else{
                                $('#location').val('');
                            }                            
                            console.log(obj.latitude);
                            console.log(obj.longitude);
                            return false;
                          }
                        });
                  return false;
                });

          
                $("form[name='addIncidentTypeForm']").validate({
                      ignore: ".ignore",
                      rules: {                 
                  incident_type_name: "required",
                  incident_type_desc: "required"
                        
                      },
                      // Specify validation error messages
                      messages: {
                        
                        
                      },
                submitHandler: function(form) {
                  var incident_type_name=$('#incident_type_name').val();
                  var incident_type_desc=$('#incident_type_desc').val();
                  
                    $.ajax({
                    type: "POST",
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('admin-ajaxAddNewIncidentType')}}",
                    dataType: 'html',
                    data: {// change data to this object
                    token : $('meta[name="csrf-token"]').attr('content'),
                    incidentType:incident_type_name,incidentTypeDesc:incident_type_desc
                    },
                    success: function (data) {
                      location.reload();
                    }
                  });
                }
                  });

                $("#group").change(function () {
                  var currenturl = "<?php echo Request::url()  ?>";
                  var longitude = $(this).find(':selected').attr('data-longitude');
                  var latitude = $(this).find(':selected').attr('data-latitude');
                  var optionSelected = $("option:selected", this);
                  var valueSelected = this.value;
                  var queryString = '?latitude='+latitude+'&longitude='+longitude+'&group_id='+valueSelected;
                  var href = currenturl+queryString;
                  //alert(valueSelected);
                  window.location.href = href;
                  //alert(currenturl);
                });


            });

        $(".locationfromgraph").click(function(){
          $(".mapdiv").toggle();
        });
        $(".close").click(function(){
          $(".mapdiv").hide();
        });

          var map;
          var marker;
          var geocoder = new google.maps.Geocoder();
          var infowindow = new google.maps.InfoWindow();
          function initMap() {

              var latlng2 = new google.maps.LatLng("<?php echo $lati;?>","<?php echo $longi; ?>");
              var myOptions2 =  {
                  zoom: 12,
                  center: latlng2,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
              };
              var map2 = new google.maps.Map(document.getElementById("map_canvas"), myOptions2);

              var myMarker2 = new google.maps.Marker(
              {
                  position: latlng2,
                  map: map2,
                  title:"<?php echo $smalllocation;?>"
              });

              var longitude = $("#longitude").val();
              var latitude  = $("#latitude").val();
              var myLatlng = new google.maps.LatLng(longitude,latitude);
                var mapOptions = {
                            zoom: 12,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            draggable: true
                };
                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                var card = document.getElementById('pac-card');
                var input = document.getElementById('pac-input');
                var types = document.getElementById('type-selector');
                var strictBounds = document.getElementById('strict-bounds-selector');
                map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
                var autocomplete = new google.maps.places.Autocomplete(input);

                  // Bind the map's bounds (viewport) property to the autocomplete object,
                  // so that the autocomplete requests use the current map bounds for the
                  // bounds option in the request.
                autocomplete.bindTo('bounds', map);

            // Set the data fields to return when the user selects a place.
                autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

                var infowindow = new google.maps.InfoWindow();
                var infowindowContent = document.getElementById('infowindow-content');
                infowindow.setContent(infowindowContent);
                var marker = new google.maps.Marker({
                  map: map,
                  anchorPoint: new google.maps.Point(0, -29),
                  position: myLatlng,
                  draggable: true 
                });
              var geocoder = new google.maps.Geocoder();
              geocoder.geocode({'latLng': myLatlng }, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                  if (results[0]) {
                    $('#latitude,#longitude').show();
                    $('#location').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                    }
                  }
              });
              google.maps.event.addListener(marker, 'dragend', function() {
                  geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                          $('#location').val(results[0].formatted_address);
                          $('#latitude').val(marker.getPosition().lat());
                          $('#longitude').val(marker.getPosition().lng());
                          infowindow.setContent(results[0].formatted_address);
                          infowindow.open(map, marker);
                      }
                      }
                  });
            });

            autocomplete.addListener('place_changed', function() {
              infowindow.close();
              marker.setVisible(false);
              var place = autocomplete.getPlace();
              if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
              }

              // If the place has a geometry, then present it on a map.
              if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
              } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
              }
              marker.setPosition(place.geometry.location);
              marker.setVisible(true);

              var address = '';
              if (place.address_components) {
                address = [
                  (place.address_components[0] && place.address_components[0].short_name || ''),
                  (place.address_components[1] && place.address_components[1].short_name || ''),
                  (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
              }

              infowindowContent.children['place-icon'].src = place.icon;
              infowindowContent.children['place-name'].textContent = place.name;
              infowindowContent.children['place-address'].textContent = address;
              infowindow.open(map, marker);
            });

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
              var radioButton = document.getElementById(id);
              radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
              });
            }

          
          }

          $('#pac-input').keypress(function(event) {
          if (event.keyCode == 13) {
             event.preventDefault();
             return false;
          }
        });
        </script>
                  
<script type="text/javascript">google.maps.event.addDomListener(window, 'load', initialize);</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2H-kU8WBtolE7HScebuNUwRGQgBaHHCI&libraries=places&callback=initMap" async defer></script>

                  
                  
  @endsection
  
  
  