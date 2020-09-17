@extends('layout.backened.header')
@section('content')
<style>
.getcoordonate{height: 32px;padding: 6px 9px;}
</style>
<button id="modalBt" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
<div id="sectorDetails"></div>
<?php //dd($data); ?>
<div class="clearfix"></div>
 <div class="section" >
  <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>@if(@$data->id){{'Update'}} @else {{'Add'}} @endif Incident</h3>
      <ol class="breadcrumb">
        <li><a href="{{route('admin-dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{_i('Home')}}</a></li>
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
            messages: {
              
               
            },
        });
    });

  
</script>
        



 <!-- Modal HTML -->
   <!--  <div class="moda<!-- l" id="myModal" tabindex="-1" role="dialog" aria-labelledby="add-sector-title" aria-hidden="true">
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
    </div> -->
 
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
                                        @foreach($group as $row) 
                                        <?php $selectedClass = (isset($data->incidentGroup) && $data->incidentGroup->group_id==$row->id)?'selected':''; ?>  
                                        <option value="<?php echo $row->id; ?>" <?php echo $selectedClass; ?>><?php echo $row->name ?></option>
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
                   <div class="col-sm-6">
            <div class="input-group date datetimepicker1" >
                      <input type="text" name="date_of_report" id="date_of_report" class="form-control datetimepicker2" placeholder="Reported By" value="{{old('name',@$data->date_of_report)}}">
                <span class="input-group-addon " style=""><i class="fa fa-calendar "></i></span>
                    <?php if(@$errors->first('date_of_report')) { ?><span class="help-block">{{@$errors->first('date_of_report')}}</span> <?php } ?>
                  </div>
          </div>
                </div>
                  
                <div class="form-group row @if($errors->first('location')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Location {{redstar()}}</label>
                  <div class="col-sm-6">
                  <input type="text" name="location" id="location" readonly = "true"  class="form-control" placeholder="Location with zipcode" value="{{old('name',@$data->location)}}">
                    <?php if(@$errors->first('location')) { ?><span class="help-block">{{@$errors->first('location')}}</span> <?php } ?>
                  </div>
                     <div class="col-sm-3">
                     <a href="javascript:open_gragh_to_get_location('{{route('admin-getLocationAndLongitudeAndLatitudeGraph')}}');" class="btn btn-primary btn-info" Title="Location from Graph">Location from Graph</a>
                     </div>                                     
                </div>
            <div class="form-group row @if($errors->first('location')) {{' has-error has-feedback'}} @endif ">
                  <label for="inputError" class="col-sm-3 control-label"> Geo Co-ordinate {{redstar()}}</label>
                 
                     <div class="col-sm-3">
                     <input type="text" name="latitude" id="latitude" value="{{old('name',@$data->latitude)}}" readonly_ class="form-control small" placeholder="Latitude"><span><i>Latitude</i></span> 
                     </div>                 
                     <div class="col-sm-3">
                     <input type="text" name="longitude" id="longitude" value="{{old('name',@$data->longitude)}}" readonly_ class="form-control" placeholder="Longitude"><span><i>Longitude</i></span>                   
                     <input type="hidden" name="place_id" id="place_id" value="{{old('name',@$data->location)}}" >   
                     </div> 
                     <!-- Modal HTML -->
                     @php $lati =  '36.225649152931204'; $longi = '-101.27017082311954';  @endphp
                     @php if(!empty(@$data->latitude)) $lati = $data->latitude;  @endphp                     
                     @php if(!empty(@$data->longitude)) $longi = $data->longitude;  @endphp                     
                     <?php $latLongArray = array('latitude'=>$lati,'longitude'=>$longi);?>
                     @include('admin.include.get_location_and_latitude_longitude_graph',$latLongArray)
                      <!-- End of model popup -->               
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
                <input type="hidden" name="caseId" id="caseId" value="{{@$data['case_id']}}">
                <a href="{{route('admin-incidentList')}}" class="btn btn-default">Cancel</a>
                <input type="submit" id="add-button" value="Submit" class="btn btn-info">
        
        
        
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          </div>
    
    
  
    
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
<script src="{{asset('js/tasklist.js')}}"></script>
<script>


$(document).ready(function() {
  
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
  
  





});


</script>

  @endsection
  
  
  